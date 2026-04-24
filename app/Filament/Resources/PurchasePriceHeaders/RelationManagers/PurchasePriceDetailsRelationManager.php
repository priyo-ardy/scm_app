<?php

namespace App\Filament\Resources\PurchasePriceHeaders\RelationManagers;

use App\Filament\Resources\PurchasePriceHeaders\PurchasePriceHeaderResource;
use App\Models\Material;
use Closure;
use Filament\Actions\CreateAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Support\RawJs;
use Filament\Tables\Columns\TextColumn;

class PurchasePriceDetailsRelationManager extends RelationManager
{
    protected static string $relationship = 'PurchasePriceDetails';

    // protected static ?string $relatedResource = PurchasePriceHeaderResource::class;

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Select::make('material_id')
                    ->label('Material')
                    ->relationship('materialList', 'code')
                    ->searchable(['code', 'name'])
                    ->preload()
                    ->native(false)
                    ->required()
                    ->columnSpanFull()
                    ->getOptionLabelFromRecordUsing(fn($record) => "{$record->code} - {$record->name}")
                    ->afterStateUpdated(function ($state, Set $set) {
                        if (!$state) {
                            $set('unit_id', null);
                            return;
                        }

                        $material = Material::find($state);

                        if ($material && $material->unit_id) {
                            $set('unit_id', $material->unit_id);
                        }
                    })
                    ->live()
                    ->columnSpan(3),
                Select::make('unit_id')
                    ->label('UoM')
                    ->relationship('unitList', 'code')
                    ->searchable()
                    ->preload()
                    ->native(false)
                    ->required()
                    ->columnSpan(3),
                TextInput::make('from_qty')
                    ->label('From Qty')
                    ->numeric()
                    ->default(0)
                    ->required()
                    ->columnSpan(2),
                TextInput::make('to_qty')
                    ->label('To Qty')
                    ->numeric()
                    ->default(0)
                    ->required()
                    ->columnSpan(2),
                TextInput::make('unit_price')
                    ->label('U/P')
                    ->required()
                    ->numeric()
                    ->default(0)
                    ->placeholder('Input Unit Price')
                    // ->rule('[gt:0]')
                    ->mask(RawJs::make('$money($input)'))
                    ->stripCharacters(',')
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (Get $get, Set $set) {
                        self::calculatePriceAfterTax($get, $set);
                    })
                    ->columnSpan(2),
                TextInput::make('tax_rate')
                    ->label('Tax (%)')
                    ->numeric()
                    ->maxLength(5)
                    ->placeholder('Tax rate')
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (Get $get, Set $set) {
                        self::calculatePriceAfterTax($get, $set);
                    })
                    ->columnSpan(2),
                TextInput::make('unit_price_after_tax')
                    ->label('U/P After Tax')
                    ->numeric()
                    ->readOnly()
                    ->placeholder('Unit price after tax')
                    ->mask(RawJs::make('$money($input)'))
                    ->stripCharacters(',')
                    ->columnSpan(2),
                DatePicker::make('effective_date')
                    ->label('Effective Date')
                    ->required()
                    ->live()
                    ->columnSpan(2),
                DatePicker::make('expired_date')
                    ->label('Expired Date')
                    ->required()
                    ->afterOrEqual('effective_date')
                    ->minDate(fn(Get $get) => $get('effective_date'))
                    ->validationMessages([
                        'afterOrEqual' => 'Tanggal expired tidak boleh mendahului tanggal efektif.',
                        'minDate' => 'Expired date cannot less than effective date'
                    ])
                    ->columnSpan(2),
                TextInput::make('remark')
                    ->label('Remark')
                    ->nullable()
                    ->placeholder('Write additional information here')
                    ->columnSpan(4)
            ])
            ->columns(12);
    }

    public function table(Table $table): Table
    {
        return $table
            ->headerActions([
                CreateAction::make()->label('Add Details')->icon(Heroicon::OutlinedPlusCircle)->modalWidth('7xl')->modalHeading('Add Material Item'),
            ])
            ->columns([
                TextColumn::make('materialList.code')->label('Material Code'),
                TextColumn::make('materialList.name')->label('Material Name'),
                TextColumn::make('materialList.specification')->label('Specification'),
                TextColumn::make('unitList.code')->label('UoM'),
                TextColumn::make('from_qty')->label('From Qty')->numeric(
                    decimalPlaces: 4,
                    decimalSeparator: '.',
                    thousandsSeparator: ','
                ),
                TextColumn::make('to_qty')->label('To Qty')->numeric(
                    decimalPlaces: 4,
                    decimalSeparator: '.',
                    thousandsSeparator: ','
                ),
                TextColumn::make('unit_price')->label('U/P')->numeric(
                    decimalPlaces: 4,
                    decimalSeparator: '.',
                    thousandsSeparator: ','
                ),
                TextColumn::make('tax_rate')->label('Tax Rate %'),
                TextColumn::make('unit_price_after_tax')->label('U/P After Tax')->numeric(
                    decimalPlaces: 4,
                    decimalSeparator: '.',
                    thousandsSeparator: ','
                ),
                TextColumn::make('effective_date')->label('Effective Date')->date('d/M/Y'),
                TextColumn::make('expired_date')->label('Expired Date')->date('d/M/Y'),
                TextColumn::make('is_active')->label('Status')->formatStateUsing(fn($state) => $state ? 'Approved' : 'Not Approved')->color(fn($state) => $state ? 'success' : 'warning')->badge(),
                TextColumn::make('remark')->label('Remark'),
            ])
            ->recordActions([
                ViewAction::make()->modalWidth('7xl'),
                EditAction::make()->modalWidth('7xl'),
            ]);
    }

    public static function calculatePriceAfterTax(Get $get, Set $set): void
    {
        // Ambil data dari input, pastikan diclean dari koma (masking) dan diconvert ke float
        $unitPrice = (float) str_replace(',', '', $get('unit_price') ?? 0);
        $taxRate = (float) ($get('tax_rate') ?? 0);

        // Rumus: unit_price + (unit_price * tax_rate / 100)
        $afterTax = $unitPrice + ($unitPrice * ($taxRate / 100));

        // Masukkan hasilnya ke field unit_price_after_tax
        $set('unit_price_after_tax', $afterTax);
    }
}
