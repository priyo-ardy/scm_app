<?php

namespace App\Filament\Resources\PurchaseOrders\Schemas;

use App\Models\Company;
use App\Models\Material;
use App\Models\PurchaseRequisitionHeader;
use App\Models\Supplier;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Repeater\TableColumn;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Support\RawJs;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Validation\ValidationException;

class PurchaseOrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->schema([
                        Select::make('company_id')
                            ->label('Company')
                            ->relationship('company', 'name')
                            ->searchable()
                            ->preload()
                            ->native(false)
                            ->columnSpan(4)
                            ->default(function () {
                                $sessionCompanyId = session('active_company');

                                if ($sessionCompanyId) {
                                    return $sessionCompanyId;
                                }

                                return Company::where('is_default', 1)->first()?->id;
                            })
                            ->disabled(fn () => session('active_company') !== null)
                            ->dehydrated(true)
                            ->required(),
                        TextInput::make('code')
                            ->label('Code')
                            ->readOnly()
                            ->columnSpan(2)
                            ->placeholder('Automatic generate after save'),
                        DatePicker::make('doc_date')
                            ->label('Date')
                            ->required()
                            ->default(now())
                            ->columnSpan(2),
                        Select::make('supplier_id')
                            ->label('Supplier')
                            ->relationship('supplier', 'name', modifyQueryUsing: fn (Builder $query) => $query->where('is_active', true)->orderBy('name', 'asc'))
                            ->searchable()
                            ->preload()
                            ->native(false)
                            ->required()
                            ->live()
                            ->afterStateUpdated(function ($state, Set $set) {
                                if (! $state) {
                                    $set('currency_id', null);
                                    $set('exchange_rate', 1);
                                    $set('payment_term_id', null);
                                }

                                $supplier = Supplier::find($state);

                                if ($supplier && $supplier->id) {
                                    $set('currency_id', $supplier->default_currency);
                                    $set('payment_term_id', $supplier->payment_term_id);
                                }
                            })
                            ->columnSpan(4),
                        Select::make('currency_id')
                            ->label('Currency')
                            ->relationship('currency', 'code', modifyQueryUsing: fn (Builder $query) => $query->where('is_active', true)->orderBy('code', 'asc'))
                            ->searchable()
                            ->preload()
                            ->native(false)
                            ->required()
                            ->columnSpan(2),
                        Select::make('purchase_requisition_id')
                            ->label('Purchase Requisition')
                            ->relationship('purchaseRequisition', 'code', modifyQueryUsing: fn (Builder $query) => $query->where('doc_status', 'approved')->where('is_closed', false)->orderBy('code', 'desc'))
                            ->searchable()
                            ->optionsLimit(5)
                            ->preload(true)
                            ->reactive()
                            ->afterStateUpdated(function (Get $get, Set $set, ?string $state) {
                                $currentSupplierId = $get('supplier_id');

                                if (! $get('supplier_id')) {
                                    $set('purchase_requisition_id', null);
                                    throw ValidationException::withMessages([
                                        'data.supplier_id' => 'Please choose supplier',
                                        'data.purchase_requisition_id' => 'Please choose supplier first.',
                                    ]);
                                }

                                if (! $state) {
                                    $set('details', []);

                                    return;
                                }

                                $pr = PurchaseRequisitionHeader::with('details')->find($state);

                                if ($pr && $pr->is_closed == false) {
                                    $filterDetails = $pr->details->filter(function ($detail) use ($currentSupplierId) {
                                        if ($detail->item_status !== 'open') {
                                            return false;
                                        }

                                        if (! empty($detail->supplier_id)) {
                                            return $detail->supplier_id == $currentSupplierId;
                                        }

                                        return true;
                                    });

                                    $set('department_id', $pr->department_id);
                                    $set('reason', $pr->reason);

                                    $repeaterData = $filterDetails->map(function ($detail) {
                                        $material = Material::find($detail->material_id);

                                        return [
                                            'pr_detail_id' => $detail->id,
                                            'material_id' => $detail->material_id,
                                            'material_name' => $material?->name,
                                            'specification' => $material?->specification,
                                            'unit_id' => $detail->unit_id,
                                            'qty' => $detail->qty,
                                            'unit_price' => 0,
                                            'amount' => 0,
                                            'discount_rate' => 0,
                                            'discount_amount' => 0,
                                            'price_after_discount' => 0,
                                            'tax_rate' => 0,
                                            'tax_amount' => 0,
                                            'price_after_tax' => 0,
                                            'total_amount' => 0,
                                            'delivery_date' => $detail->arrival_date ?? now(),
                                            'remark' => $detail->remark,
                                        ];
                                    })->toArray();

                                    $set('details', $repeaterData);
                                }
                            })
                            ->native(false)
                            ->columnSpan(3)
                            ->required(),
                        Select::make('department_id')
                            ->label('Requested Department')
                            ->relationship('department', 'name', modifyQueryUsing: fn (Builder $query) => $query->where('is_active', true)->orderBy('name', 'asc'))
                            ->searchable()
                            ->preload()
                            ->native(false)
                            ->required()
                            ->columnSpan(2),
                        TextInput::make('doc_status')
                            ->label('Document Status')
                            ->columnSpan(2)
                            ->disabled()
                            ->default('draft')
                            ->readOnly(),
                        TextInput::make('exchange_rate')
                            ->label('Exchange Rate')
                            ->numeric()
                            ->mask(RawJs::make('$money($input)'))
                            ->stripCharacters(',')
                            ->live(onBlur: true)
                            ->columnSpan(2)
                            ->placeholder('Exchange Rate')
                            ->required()
                            ->default(1)
                            ->extraInputAttributes(['style' => 'text-align: right']),
                        TextInput::make('printed_count')
                            ->label('Print Count')
                            ->default(0)
                            ->columnSpan(1)
                            ->readOnly()
                            ->numeric()
                            ->extraInputAttributes(['style' => 'text-align: right']),
                        Select::make('payment_term_id')
                            ->label('Payment Term')
                            ->relationship('paymentTerm', 'name', modifyQueryUsing: fn (Builder $query) => $query->where('is_active', true)->orderBy('name', 'asc'))
                            ->searchable()
                            ->preload()
                            ->native(false)
                            ->required()
                            ->columnSpan(3),
                        TextInput::make('reason')
                            ->label('Purchase Reason')
                            ->placeholder('Purchase reason')
                            ->columnSpan(9)
                            ->maxLength(255)
                            ->nullable(),
                        Textarea::make('shipping_address')
                            ->label('Shipping Address')
                            ->columnSpanFull()
                            ->rows(3),
                    ])
                    ->columns(12)
                    ->columnSpanFull(),
                Repeater::make('details')
                    ->relationship()
                    ->table([
                        TableColumn::make('Material Code')->markAsRequired()->wrapHeader(),
                        TableColumn::make('Material Name')->wrapHeader(),
                        TableColumn::make('Specification')->wrapHeader(),
                        TableColumn::make('UoM')->markAsRequired()->wrapHeader(),
                        TableColumn::make('Qty')->markAsRequired()->wrapHeader(),
                        TableColumn::make('Unit Price')->markAsRequired()->wrapHeader(),
                        TableColumn::make('Amount')->markAsRequired()->wrapHeader(),
                        TableColumn::make('Discount Rate (%)')->wrapHeader(),
                        TableColumn::make('Discount Amount')->wrapHeader(),
                        TableColumn::make('Price After Discount')->wrapHeader(),
                        TableColumn::make('Tax Rate (%)'),
                        TableColumn::make('Tax Amount'),
                        TableColumn::make('Unit Price After Tax')->wrapHeader(),
                        TableColumn::make('Total Amount')->wrapHeader(),
                        TableColumn::make('Arrival Date'),
                        TableColumn::make('Remark'),
                    ])
                    ->compact()
                    ->schema([
                        Hidden::make('pr_detail_id'),
                        Select::make('material_id')
                            ->relationship('material', 'code')
                            ->searchable(['code', 'name'])
                            ->searchPrompt('Write material code/name')
                            ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->code} - {$record->name}")
                            ->extraAttributes(['style' => '400px !important'])
                            ->required()
                            ->live()
                            ->optionsLimit(5)
                            ->afterStateUpdated(function ($state, Set $set, Get $get) {
                                if ($state) {
                                    $material = Material::find($state);
                                    $set('material_name', $material?->name);
                                    $set('specification', $material?->specification);
                                    $set('unit_id', $material?->purchase_unit_id);

                                    self::calculateAmount($get, $set);
                                }
                            })
                            ->native(false)
                            ->preload(true)
                            ->required(),
                        TextInput::make('material_name')
                            ->readOnly()
                            ->placeholder('Material name')
                            ->extraAttributes(['class' => 'break-words text-sm;']),
                        TextInput::make('specification')
                            ->readOnly()
                            ->placeholder('Specification')
                            ->extraAttributes(['class' => 'break-words text-sm']),
                        Select::make('unit_id')
                            ->relationship('units', 'code', modifyQueryUsing: fn (Builder $query) => $query->where('is_active', true)->orderBy('code', 'asc'))
                            ->searchable()
                            ->searchPrompt('')
                            ->preload()
                            ->required()
                            ->native(false)
                            ->extraAttributes(['style' => 'min-width: 60px !important']),
                        TextInput::make('qty')
                            ->numeric()
                            ->default(0)
                            ->extraInputAttributes(['style' => 'text-align: right'])
                            ->afterStateUpdated(function (Get $get, Set $set) {
                                self::calculateAmount($get, $set);
                            })
                            ->required()
                            ->minValue(0.001)
                            ->step(0.001)
                            ->live(onBlur: true)
                            ->mask(RawJs::make('$money($input)'))
                            ->dehydrateStateUsing(fn ($state) => self::parseMoney($state) ?? 0)
                            ->stripCharacters(',')
                            ->validationMessages([
                                'required' => 'Qty is required',
                                'min' => 'Qty must be greater than 0',
                            ])
                            ->required(),
                        TextInput::make('unit_price')
                            ->numeric()
                            ->default(0)
                            ->extraInputAttributes(['style' => 'text-align: right'])
                            ->afterStateUpdated(function (Get $get, Set $set) {
                                self::calculateAmount($get, $set);
                            })
                            ->live(onBlur: true)
                            ->required()
                            ->minValue(0.001)
                            ->step(0.001)
                            ->validationMessages([
                                'required' => 'Unit price is required',
                                'min' => 'Unit price must be greater than 0',
                            ])
                            ->mask(RawJs::make('$money($input)'))
                            ->dehydrateStateUsing(fn ($state) => self::parseMoney($state) ?? 0)
                            ->stripCharacters(',')
                            ->required(),
                        TextInput::make('amount')
                            ->numeric()
                            ->default(0)
                            ->readOnly()
                            ->extraInputAttributes(['style' => 'text-align: right'])
                            ->mask(RawJs::make('$money($input)'))
                            ->dehydrateStateUsing(fn ($state) => self::parseMoney($state) ?? 0)
                            ->stripCharacters(',')
                            ->required()
                            ->minValue(0.001)
                            ->step(0.001)
                            ->validationMessages([
                                'required' => 'Amount is required',
                                'min' => 'Amount must be greater than 0',
                            ]),
                        TextInput::make('discount_rate')
                            ->numeric()
                            ->default(0)
                            ->extraInputAttributes(['style' => 'text-align: right'])
                            ->mask(RawJs::make('$money($input)'))
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (Get $get, Set $set) {
                                self::calculateDiscountAmount($get, $set);
                            })
                            ->stripCharacters(',')
                            ->dehydrateStateUsing(fn ($state) => self::parseMoney($state) ?? 0),
                        TextInput::make('discount_amount')
                            ->numeric()
                            ->default(0)
                            ->extraInputAttributes(['style' => 'text-align: right'])
                            ->mask(RawJs::make('$money($input)'))
                            ->afterStateUpdated(function (Get $get, Set $set) {
                                self::calculateDiscountRate($get, $set);
                            })
                            ->live(onBlur: true)
                            ->stripCharacters(',')
                            ->dehydrateStateUsing(fn ($state) => self::parseMoney($state) ?? 0),
                        TextInput::make('price_after_discount')
                            ->default(0)
                            ->readOnly()
                            ->extraInputAttributes(['style' => 'text-align: right'])
                            ->mask(RawJs::make('$money($input)'))
                            ->dehydrateStateUsing(fn ($state) => self::parseMoney($state) ?? 0),
                        TextInput::make('tax_rate')
                            ->numeric()
                            ->default(0)
                            ->extraInputAttributes(['style' => 'text-align: right'])
                            ->mask(RawJs::make('$money($input)'))
                            ->stripCharacters(',')
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (Get $get, Set $set) {
                                self::calculateTaxAmount($get, $set);
                            })
                            ->dehydrateStateUsing(fn ($state) => self::parseMoney($state) ?? 0),
                        TextInput::make('tax_amount')
                            ->numeric()
                            ->default(0)
                            ->extraInputAttributes(['style' => 'text-align: right'])
                            ->mask(RawJs::make('$money($input)'))
                            ->stripCharacters(',')
                            ->readOnly()
                            ->afterStateUpdated(function (Get $get, Set $set) {})
                            ->dehydrateStateUsing(fn ($state) => self::parseMoney($state) ?? 0),
                        TextInput::make('price_after_tax')
                            ->default(0)
                            ->readOnly()
                            ->extraInputAttributes(['style' => 'text-align: right'])
                            ->mask(RawJs::make('$money($input)'))
                            ->stripCharacters(','),
                        TextInput::make('total_amount')
                            ->default(0)
                            ->extraInputAttributes(['style' => 'text-align: right'])
                            ->mask(RawJs::make('$money($input)'))
                            ->required()
                            ->minValue(0.001)
                            ->step(0.001)
                            ->validationMessages([
                                'required' => 'Total amount is required',
                                'min' => 'Total amount must greather than 0',
                            ])
                            ->readOnly()
                            ->dehydrateStateUsing(fn ($state) => self::parseMoney($state) ?? 0),
                        DatePicker::make('delivery_date')
                            ->default(now()),
                        TextInput::make('remark')
                            ->placeholder('Write remark here ...'),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    private static function parseMoney($value): float
    {
        if (is_null($value)) {
            return 0;
        }
        if (is_numeric($value)) {
            return (float) $value;
        }

        $clean = str_replace([',', ' '], '', $value);

        return (float) $clean;
    }

    public static function calculateAmount(Get $get, Set $set): void
    {
        $material = $get('material_id');

        $qty = self::parseMoney($get('qty'));
        $unitPrice = self::parseMoney($get('unit_price'));

        if (blank($material)) {
            $set('amount', 0);
            $set('price_after_discount', 0);
            $set('price_after_tax', 0);
            $set('discount_amount', 0);
            $set('tax_amount', 0);

            return;
        }

        if ($qty <= 0 || $unitPrice <= 0) {
            $set('amount', 0);
            $set('price_after_discount', 0);
            $set('price_after_tax', 0);
            $set('discount_amount', 0);
            $set('tax_amount', 0);

            return;
        }

        $amount = round($qty * $unitPrice, 4);

        $set('amount', $amount);

        self::calculateDiscountAmount($get, $set);
        self::calculateTotalAmount($get, $set);
    }

    public static function calculateDiscountAmount(Get $get, Set $set): void
    {
        $amount = self::parseMoney($get('amount'));

        $discountRate = (float) ($get('discount_rate') ?? 0);

        if ($amount <= 0) {
            $set('discount_amount', 0);
            $set('price_after_discount', 0);

            self::calculateTaxAmount($get, $set);

            return;
        }

        // clamp 0-100
        $discountRate = min(max($discountRate, 0), 100);

        $discountAmount = round(
            $amount * ($discountRate / 100),
            4
        );

        $priceAfterDiscount = round(
            $amount - $discountAmount,
            4
        );

        if (
            round(self::parseMoney($get('discount_amount')), 4)
            !== $discountAmount
        ) {
            $set('discount_amount', $discountAmount);
        }

        $set('price_after_discount', $priceAfterDiscount);

        self::calculateTaxAmount($get, $set);
        self::calculateTotalAmount($get, $set);
    }

    public static function calculateDiscountRate(Get $get, Set $set): void
    {
        $amount = self::parseMoney($get('amount'));

        $discountAmount = self::parseMoney(
            $get('discount_amount')
        );

        if ($amount <= 0) {
            $set('discount_rate', 0);
            $set('price_after_discount', 0);

            self::calculateTaxAmount($get, $set);

            return;
        }

        $discountAmount = min($discountAmount, $amount);

        $rate = round(
            ($discountAmount / $amount) * 100,
            2
        );

        $priceAfterDiscount = round(
            $amount - $discountAmount,
            4
        );

        if (
            round((float) $get('discount_rate'), 2)
            !== $rate
        ) {
            $set('discount_rate', $rate);
        }

        $set('price_after_discount', $priceAfterDiscount);

        self::calculateTaxAmount($get, $set);
        self::calculateTotalAmount($get, $set);
    }

    public static function calculateTaxAmount(Get $get, Set $set): void
    {
        $priceAfterDiscount = self::parseMoney(
            $get('price_after_discount')
        );

        $amount = self::parseMoney(
            $get('amount')
        );

        $discountRate = (float) ($get('discount_rate') ?? 0);

        $taxRate = (float) ($get('tax_rate') ?? 0);

        $taxBase = $discountRate > 0
            ? $priceAfterDiscount
            : $amount;

        if ($taxBase <= 0) {
            $set('tax_amount', 0);
            $set('price_after_tax', 0);

            return;
        }

        $taxRate = max($taxRate, 0);

        if ($taxRate <= 0) {
            $set('tax_amount', 0);
            $set('price_after_tax', round($taxBase, 4));

            return;
        }

        $taxAmount = round(
            $taxBase * ($taxRate / 100),
            4
        );

        $priceAfterTax = round(
            $taxBase + $taxAmount,
            4
        );

        $set('tax_amount', $taxAmount);

        $set('price_after_tax', $priceAfterTax);

        self::calculateTotalAmount($get, $set);
    }

    public static function calculateTotalAmount(Get $get, Set $set): void
    {
        $amount = self::parseMoney($get('amount'));
        $priceAfterDiscount = self::parseMoney($get('price_after_discount'));
        $priceAfterTax = self::parseMoney($get('price_after_tax'));

        if ($priceAfterTax != 0) {
            $total = $priceAfterTax;
        } elseif ($priceAfterDiscount != 0) {
            $total = $priceAfterDiscount;
        } else {
            $total = $amount;
        }

        $set('total_amount', round($total, 4));
    }
}
