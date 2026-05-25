<?php

namespace App\Filament\Resources\PurchaseReceiptHeaders\Schemas;

use App\Models\Company;
use App\Models\Material;
use App\Models\PurchaseOrderDetail;
use App\Models\PurchaseReceiptDetail;
use App\Models\Supplier;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Repeater\TableColumn;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Support\RawJs;
use Illuminate\Database\Eloquent\Builder;

class PurchaseReceiptHeaderForm
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
                            ->disabled(fn() => session('active_company') !== null)
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
                        DatePicker::make('received_date')
                            ->label('Received Date')
                            ->required()
                            ->default(now())
                            ->columnSpan(2),
                        TextInput::make('doc_status')
                            ->label('Status')
                            ->default('draft')
                            ->columnSpan(2)
                            ->readOnly(),
                        Select::make('supplier_id')
                            ->label('Supplier')
                            ->relationship('supplier', 'name')
                            ->searchable()
                            ->preload()
                            ->native(false)
                            ->columnSpan(3)
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
                                }
                            })
                            ->required(),
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
                            ->readOnly()
                            ->extraInputAttributes(['style' => 'text-align: right']),
                        TextInput::make('delivery_note_number')
                            ->label('Delivery Note No.')
                            ->maxLength(50)
                            ->placeholder('Delivery Note No.')
                            ->columnSpan(2),
                        TextInput::make('vehicle_number')
                            ->label('Vehicle No.')
                            ->maxLength(50)
                            ->placeholder('Vehicle No.')
                            ->columnSpan(2),
                        TextInput::make('print_count')
                            ->numeric()
                            ->readOnly()
                            ->columnSpan(1)
                            ->default(0)
                    ])
                    ->columns(12)
                    ->columnSpanFull(),
                Repeater::make('details')
                    ->defaultItems(0)
                    ->relationship()
                    ->hiddenLabel()
                    ->table([
                        TableColumn::make('Material Code')->markAsRequired()->wrapHeader(),
                        TableColumn::make('Material Name')->wrapHeader(),
                        TableColumn::make('Specification')->wrapHeader(),
                        TableColumn::make('UoM')->wrapHeader(),
                        TableColumn::make('Qty Received')->markAsRequired()->wrapHeader(),
                        TableColumn::make('Lot No.')->markAsRequired()->wrapHeader(),
                        TableColumn::make('Remark')->wrapHeader(),
                    ])
                    ->compact()
                    ->schema([
                        Hidden::make('po_detail_id'),
                        Select::make('material_id')
                            ->relationship('material', 'code')
                            ->searchable(['code', 'name'])
                            ->searchPrompt('Write material code/name')
                            ->getOptionLabelFromRecordUsing(fn($record) => "{$record->code} - {$record->name}")
                            ->required()
                            ->live()
                            ->optionsLimit(5)
                            ->afterStateUpdated(function ($state, Set $set, Get $get) {
                                if ($state) {
                                    $material = Material::find($state);
                                    $set('material_name', $material?->name);
                                    $set('specification', $material?->specification);
                                    $set('unit_id', $material?->purchase_unit_id);
                                }
                            })
                            ->afterStateHydrated(function ($state, Set $set) {
                                if ($state) {
                                    $material = Material::find($state);
                                    $set('material_name', $material?->name);
                                    $set('specification', $material?->specification);
                                }
                            })
                            ->native(false)
                            ->preload(true)
                            ->extraAttributes(['class' => 'break-words text-sm;'])
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
                            ->relationship('units', 'code', modifyQueryUsing: fn(Builder $query) => $query->where('is_active', true)->orderBy('code', 'asc'))
                            ->searchable()
                            ->searchPrompt('')
                            ->preload()
                            ->required()
                            ->native(false),
                        TextInput::make('qty_received')
                            ->numeric()
                            ->default(0)
                            ->extraInputAttributes(['style' => 'text-align: right'])
                            ->required()
                            ->minValue(0.001)
                            ->step(0.001)
                            ->live(onBlur: true)
                            ->mask(RawJs::make('$money($input)'))
                            ->dehydrateStateUsing(fn($state) => self::parseMoney($state) ?? 0)
                            ->stripCharacters(',')
                            ->validationMessages([
                                'required' => 'Qty is required',
                                'min' => 'Qty must be greater than 0',
                            ])
                            ->rule([
                                fn(Get $get): \Closure => function (string $attribute, $value, \Closure $fail) use ($get) {
                                    $cleanValue = is_numeric($value) ? (float) $value : (float) str_replace([',', ' '], '', $value);

                                    $poDetailId = $get('po_detail_id');

                                    if ($poDetailId) {
                                        $poDetail = PurchaseOrderDetail::find($poDetailId);

                                        if ($poDetail) {
                                            $receiptDetailId = $get('id');
                                            $alreadyReceiveBefore = 0;

                                            if ($receiptDetailId) {
                                                $alreadyReceiveBefore = PurchaseReceiptDetail::where('id', $receiptDetailId)->value('qty_received') ?? 0;
                                            }

                                            $maxAllowed = $poDetail->qty_remaining + $alreadyReceiveBefore;

                                            if ($cleanValue > $maxAllowed) {
                                                $fail("The quantity received must not exceed the remaining PO quantity (Maximum: {$maxAllowed}).");
                                            }
                                        }
                                    }
                                }
                            ])
                            ->required()
                            ->validationMessages([
                                'required' => 'Qty is required',
                                'min' => 'Qty must be greater than 0',
                            ]),
                        TextInput::make('lot_number')
                            ->required()
                            ->placeholder('Lot No')
                            ->maxLength(50),
                        TextInput::make('remark')
                            ->placeholder('Remark')
                            ->nullable()
                    ])
                    ->columnSpanFull()
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
}
