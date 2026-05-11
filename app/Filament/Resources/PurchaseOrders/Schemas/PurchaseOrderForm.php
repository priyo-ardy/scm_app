<?php

namespace App\Filament\Resources\PurchaseOrders\Schemas;

use App\Models\Material;
use App\Models\Supplier;
use Filament\Forms\Components\DatePicker;
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
use Filament\Tables\Columns\Column;
use Illuminate\Database\Eloquent\Builder;

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
                        Select::make('department_id')
                            ->label('Requested Department')
                            ->relationship('department', 'name', modifyQueryUsing: fn(Builder $query) => $query->where('is_active', true)->orderBy('name', 'asc'))
                            ->searchable()
                            ->preload()
                            ->native(false)
                            ->required()
                            ->columnSpan(2),
                        TextInput::make('doc_status')
                            ->label('Document Status')
                            ->columnSpan(2)
                            ->default('draft')
                            ->readOnly(),
                        Select::make('supplier_id')
                            ->label('Supplier')
                            ->relationship('supplier', 'name', modifyQueryUsing: fn(Builder $query) => $query->where('is_active', true)->orderBy('name', 'asc'))
                            ->searchable()
                            ->preload()
                            ->native(false)
                            ->required()
                            ->live()
                            ->afterStateUpdated(function ($state, Set $set) {
                                if (!$state) {
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
                            ->relationship('currency', 'code', modifyQueryUsing: fn(Builder $query) => $query->where('is_active', true)->orderBy('code', 'asc'))
                            ->searchable()
                            ->preload()
                            ->native(false)
                            ->required()
                            ->columnSpan(2),
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
                        Select::make('payment_term_id')
                            ->label('Payment Term')
                            ->relationship('paymentTerm', 'name', modifyQueryUsing: fn(Builder $query) => $query->where('is_active', true)->orderBy('name', 'asc'))
                            ->searchable()
                            ->preload()
                            ->native(false)
                            ->required()
                            ->columnSpan(3),
                        TextInput::make('printed_count')
                            ->label('Print Count')
                            ->default(0)
                            ->columnSpan(1)
                            ->readOnly()
                            ->numeric()
                            ->extraInputAttributes(['style' => 'text-align: right']),
                        Select::make('purchase_requisition_id')
                            ->label('Purchase Requisition')
                            ->relationship('purchaseRequisition', 'code', modifyQueryUsing: fn(Builder $query) => $query->where('doc_status', 'approved')->orderBy('code', 'desc'))
                            ->searchable()
                            ->preload()
                            ->live()
                            ->afterStateUpdated(function ($state, Set $set) {})
                            ->native(false)
                            ->columnSpan(3)
                            ->required(),
                        Textarea::make('shipping_address')
                            ->label('Shipping Address')
                            ->columnSpan(9)
                            ->rows(3)
                    ])
                    ->columns(12)
                    ->columnSpanFull(),
                Repeater::make('details')
                    ->relationship()
                    ->extraAttributes([
                        // 'class' => 'repeater-table-overflow',
                        // Tambahkan style inline ini untuk memastikan overflow bekerja
                        // 'style' => 'overflow-x: auto; display: block; width: 100%;'
                    ])
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
                        TableColumn::make('Unit Price After Tax')->wrapHeader()

                        // TableColumn::make('Total Amount'),
                        // TableColumn::make('Arrival Date'),
                        // TableColumn::make('Remark'),
                    ])
                    ->compact()
                    ->schema([
                        Select::make('material_id')
                            ->relationship('material', 'code')
                            ->searchable(['code', 'name'])
                            ->searchPrompt('Write material code/name')
                            ->getOptionLabelFromRecordUsing(fn($record) => "{$record->code} - {$record->name}")
                            ->extraAttributes(['style' => '400px !important'])
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
                            ->extraAttributes(['class' => 'break-words text-sm; min-width: 200px']),
                        TextInput::make('specification')
                            ->readOnly()
                            ->placeholder('Specification')
                            ->extraAttributes(['class' => 'break-words text-sm; min-width: 400px']),
                        Select::make('unit_id')
                            ->relationship('units', 'code', modifyQueryUsing: fn(Builder $query) => $query->where('is_active', true)->orderBy('code', 'asc'))
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
                            ->live(onBlur: true)
                            ->mask(RawJs::make('$money($input)'))
                            ->dehydrateStateUsing(fn($state) => $state !== null ? (float) str_replace(',', '', $state) : 0)
                            ->stripCharacters(',')
                            ->required(),
                        TextInput::make('unit_price')
                            ->numeric()
                            ->default(0)
                            ->extraInputAttributes(['style' => 'text-align: right'])
                            ->afterStateUpdated(function (Get $get, Set $set) {
                                self::calculateAmount($get, $set);
                            })
                            ->live(onBlur: true)
                            ->mask(RawJs::make('$money($input)'))
                            ->dehydrateStateUsing(fn($state) => $state !== null ? (float) str_replace(',', '', $state) : 0)
                            ->stripCharacters(',')
                            ->required(),
                        TextInput::make('amount')
                            ->numeric()
                            ->default(0)
                            ->readOnly()
                            ->extraInputAttributes(['style' => 'text-align: right'])
                            ->mask(RawJs::make('$money($input)'))
                            ->dehydrateStateUsing(fn($state) => $state !== null ? (float) str_replace(',', '', $state) : 0)
                            ->stripCharacters(','),
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
                            ->dehydrateStateUsing(fn($state) => $state !== null ? (float) str_replace(',', '', $state) : 0),
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
                            ->dehydrateStateUsing(fn($state) => $state !== null ? (float) str_replace(',', '', $state) : 0),
                        TextInput::make('price_after_discount')
                            ->numeric()
                            ->default(0)
                            ->readOnly()
                            ->extraInputAttributes(['style' => 'text-align: right'])
                            ->mask(RawJs::make('$money($input)'))
                            ->dehydrateStateUsing(fn($state) => $state !== null ? (float) str_replace(',', '', $state) : 0),
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
                            ->dehydrateStateUsing(fn($state) => $state !== null ? (float) str_replace(',', '', $state) : 0),
                        TextInput::make('tax_amount')
                            ->numeric()
                            ->default(0)
                            ->extraInputAttributes(['style' => 'text-align: right'])
                            ->mask(RawJs::make('$money($input)'))
                            ->stripCharacters(',')
                            ->readOnly()
                            ->afterStateUpdated(function (Get $get, Set $set) {})
                            ->dehydrateStateUsing(fn($state) => $state !== null ? (float) str_replace(',', '', $state) : 0),
                        TextInput::make('price_after_tax')
                            ->numeric()
                            ->default(0)
                            ->readOnly()
                            ->extraInputAttributes(['style' => 'text-align: right'])
                            ->mask(RawJs::make('$money($input)'))
                            ->stripCharacters(','),
                        // TextInput::make('total_amount')
                        //     ->numeric()
                        //     ->default(0)
                        //     ->extraInputAttributes(['style' => 'text-align: right'])
                        //     ->mask(RawJs::make('$money($input)'))
                        //     ->extraInputAttributes(['style' => 'text-align: right; min-width: 200px'])
                        //     ->readOnly()
                        //     ->dehydrateStateUsing(fn($state) => $state !== null ? (float) str_replace(',', '', $state) : 0),
                        // DatePicker::make('delivery_date')
                        //     ->default(now())
                        //     ->extraInputAttributes(['style' => 'min-width: 200px']),
                        // TextInput::make('remark')
                        //     ->placeholder('Write remark here ...')
                        //     ->extraInputAttributes(['style' => 'min-width: 400px']),
                    ])
                    ->columnSpanFull()
            ]);
    }

    private static function parseMoney($value): float
    {
        return (float) str_replace([',', ' '], '', $value ?? 0);
    }

    public static function calculateAmount(Get $get, Set $set): void
    {
        $material = $get('material_id');

        $qty = self::parseMoney($get('qty'));
        $unitPrice = self::parseMoney($get('unit_price'));

        // no material
        if (blank($material)) {
            $set('amount', 0);
            $set('price_after_discount', 0);
            $set('price_after_tax', 0);
            $set('discount_amount', 0);
            $set('tax_amount', 0);

            return;
        }

        // invalid amount
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

        // downstream recalc
        self::calculateDiscountAmount($get, $set);
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

        // anti loop
        if (
            round(self::parseMoney($get('discount_amount')), 4)
            !== $discountAmount
        ) {
            $set('discount_amount', $discountAmount);
        }

        $set('price_after_discount', $priceAfterDiscount);

        self::calculateTaxAmount($get, $set);
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

        // clamp biar gak lebih dari amount
        $discountAmount = min($discountAmount, $amount);

        $rate = round(
            ($discountAmount / $amount) * 100,
            2
        );

        $priceAfterDiscount = round(
            $amount - $discountAmount,
            4
        );

        // anti loop
        if (
            round((float) $get('discount_rate'), 2)
            !== $rate
        ) {
            $set('discount_rate', $rate);
        }

        $set('price_after_discount', $priceAfterDiscount);

        self::calculateTaxAmount($get, $set);
    }

    public static function calculateTaxAmount(Get $get, Set $set): void
    {
        $priceAfterDiscount = self::parseMoney(
            $get('price_after_discount')
        );

        $amount = self::parseMoney(
            $get('amount')
        );

        $taxRate = (float) ($get('tax_rate') ?? 0);

        // IMPORTANT:
        // kalau discount belum dihitung,
        // fallback ke amount
        $taxBase = $priceAfterDiscount > 0
            ? $priceAfterDiscount
            : $amount;

        if ($taxBase <= 0) {
            $set('tax_amount', 0);
            $set('price_after_tax', 0);

            return;
        }

        // clamp
        $taxRate = max($taxRate, 0);

        // no tax
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
    }
}
