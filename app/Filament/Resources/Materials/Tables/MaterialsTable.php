<?php

namespace App\Filament\Resources\Materials\Tables;

use App\Filament\Exports\MaterialExporter;
use Filament\Actions\Action;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ExportAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\QueryBuilder\Constraints\BooleanConstraint;
use Filament\QueryBuilder\Constraints\NumberConstraint;
use Filament\QueryBuilder\Constraints\SelectConstraint;
use Filament\QueryBuilder\Constraints\TextConstraint;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\QueryBuilder;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class MaterialsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('companyList.slug')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('categoryList.name')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('code')
                    ->searchable(),
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('unitList.code')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('purchaseUnitList.code')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('unit_conversion_rate')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('spq')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('qty_bag')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('net_weight')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('gross_weight')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('sprue')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('cycle_time')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('shift_capacity')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('properties')
                    ->badge(),
                TextColumn::make('color')
                    ->searchable(),
                TextColumn::make('cavity')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('workshopList.name')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('cust_part_no')
                    ->searchable(),
                TextColumn::make('cust_part_name')
                    ->searchable(),
                TextColumn::make('delivery_location')
                    ->searchable(),
                TextColumn::make('mold_no')
                    ->searchable(),
                TextColumn::make('enable_min_stock')
                    ->badge()
                    ->alignCenter()
                    ->color(fn(bool $state): string => $state ? 'success' : 'danger')
                    ->formatStateUsing(fn(bool $state): string => $state ? 'Yes' : 'No'),
                TextColumn::make('min_stock')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('enable_safety_stock')
                    ->badge()
                    ->alignCenter()
                    ->color(fn(bool $state): string => $state ? 'success' : 'danger')
                    ->formatStateUsing(fn(bool $state): string => $state ? 'Yes' : 'No'),
                TextColumn::make('safety_stock')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('enabl_max_stock')
                    ->badge()
                    ->alignCenter()
                    ->color(fn(bool $state): string => $state ? 'success' : 'danger')
                    ->formatStateUsing(fn(bool $state): string => $state ? 'Yes' : 'No'),
                TextColumn::make('max_stock')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('reorder_point')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('supplierList.name')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('is_hazardous')
                    ->badge()
                    ->alignCenter()
                    ->color(fn(bool $state): string => $state ? 'success' : 'danger')
                    ->formatStateUsing(fn(bool $state): string => $state ? 'Yes' : 'No'),
                TextColumn::make('storage_location_id')
                    ->searchable(),
                TextColumn::make('enable_expired')
                    ->badge()
                    ->alignCenter()
                    ->color(fn(bool $state): string => $state ? 'success' : 'danger')
                    ->formatStateUsing(fn(bool $state): string => $state ? 'Yes' : 'No'),
                TextColumn::make('expiry_days')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('lead_time_days')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('status')
                    ->badge(),
                TextColumn::make('revision_no')
                    ->searchable(),
                TextColumn::make('hs_code')
                    ->searchable(),
                TextColumn::make('regrind_method')
                    ->badge(),
                TextColumn::make('carton_category')
                    ->searchable(),
                TextColumn::make('carton_length')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('carton_width')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('carton_height')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('dimensionUnitList.code')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('stacking_limit')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('is_inspection_required')
                    ->badge()
                    ->alignCenter()
                    ->color(fn(bool $state): string => $state ? 'success' : 'danger')
                    ->formatStateUsing(fn(bool $state): string => $state ? 'Yes' : 'No'),
                TextColumn::make('last_purchase_price')
                    ->money('IDR')
                    ->sortable(),
                TextColumn::make('drawing_no')
                    ->searchable(),
                TextColumn::make('process_routes')
                    ->searchable(),
                TextColumn::make('drawing_level')
                    ->searchable(),
                TextColumn::make('tonnageList.name')
                    ->label('Tonnage')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('creator.name')
                    ->sortable(),
                TextColumn::make('updater.name')
                    ->sortable(),
            ])
            ->filters([
                QueryBuilder::make()
                    ->constraints([
                        // TEXT: Untuk Nama, Code, Spec, dll
                        TextConstraint::make('code')
                            ->label('Material Code'),
                        TextConstraint::make('name')
                            ->label('Material Name'),
                        TextConstraint::make('specification'),

                        // NUMBER: Untuk Weight, SPQ, Cavity (Otomatis ada operator > < =)
                        NumberConstraint::make('net_weight')
                            ->label('Net Weight'),
                        NumberConstraint::make('cavity'),
                        NumberConstraint::make('cycle_time'),

                        // SELECT: Untuk Status, Workshop (Otomatis ada operator Is/Is Not)
                        SelectConstraint::make('status')
                            ->options([
                                'draft' => 'Draft',
                                'active' => 'Active',
                                'phase_out' => 'Phase Out',
                            ]),
                        SelectConstraint::make('workshop_id')
                            ->label('Workshop')
                            ->options(\App\Models\Workshop::pluck('name', 'id')->toArray()),

                        // BOOLEAN: Untuk Hazardous, dll
                        BooleanConstraint::make('is_hazardous')
                            ->label('Is Hazardous'),
                    ])
            ], layout: FiltersLayout::Modal)
            ->filtersFormWidth('4xl')
            ->filtersFormColumns(1)
            ->persistFiltersInSession()
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    BulkAction::make('bulkEdit')
                        ->label('Mass Edit')
                        ->color('warning')
                        ->icon(HeroIcon::OutlinedPencilSquare)
                        ->schema([
                            Select::make('column_to_update')
                                ->label('Edit field name')
                                ->searchable()
                                ->live()
                                ->options([
                                    'specification' => 'Specification',
                                    'spq' => 'SPQ',
                                    'qty_bag' => 'Qty/Bag',
                                    'net_weight' => 'Net Weight',
                                    'gross_weight' => 'Gross Weight',
                                    'cycle_time' => 'Cycle Time',
                                    'shift_capacity' => 'Shift Capacity',
                                    'cavity' => 'Cavity',
                                    'workshop_id' => 'Workshop',
                                    'cust_part_no' => 'Customer Part No',
                                    'cust_part_name' => 'Customer Part Name',
                                    'delivery_location' => 'Delivery Location',
                                    'mold_no' => 'Mold No',
                                    'supplier_id' => 'Suppilier',
                                    'is_hazardous' => 'Is Hazardous',
                                    'status' => 'Status',
                                    'drawing_no' => 'Drawing No',
                                    'process_routes' => 'Process Routes',
                                    'drawing_level' => 'Drawing Level',
                                    'revision_no' => 'Revision No',
                                    'tonnage_id' => 'Tonnage',
                                    'hs_code' => 'HS Code',
                                    'regrind_method' => 'Regrind Method',
                                    'carton_category' => 'Carton Category',
                                    'carton_length' => 'Carton Length',
                                    'carton_width' => 'Carton Width',
                                    'carton_height' => 'Carton Height',
                                    'dimension_unit_id' => 'Carton Dimension Unit',
                                    'stacking_limit' => 'Stacking Limit',
                                    'is_inspection_required' => 'Is Inspection Required',
                                ]),

                            // Tipe TEXTAREA (Specification)
                            Textarea::make('value_textarea')
                                ->label('New Specification')
                                ->visible(fn(Get $get) => $get('column_to_update') === 'specification')
                                ->required(),

                            // Tipe NUMERIC (SPQ, Qty/Bag, Cavity, Capacity)
                            TextInput::make('value_numeric')
                                ->label('New Value (Integer)')
                                ->numeric()
                                ->visible(fn(Get $get) => in_array($get('column_to_update'), ['spq', 'qty_bag', 'shift_capacity', 'cavity']))
                                ->required(),

                            // Tipe DECIMAL (Weights, Cycle Time, Carton Dims)
                            TextInput::make('value_decimal')
                                ->label('New Value (Decimal)')
                                ->numeric()
                                ->step('0.00001')
                                ->visible(fn(Get $get) => in_array($get('column_to_update'), ['net_weight', 'gross_weight', 'cycle_time', 'carton_length', 'carton_width', 'carton_height']))
                                ->required(),

                            // Tipe RELATIONSHIP (Workshop, Supplier, Tonnage, Unit)
                            Select::make('value_relation_workshop')
                                ->label('Select New Workshop')
                                ->relationship('workshopList', 'name')
                                ->visible(fn(Get $get) => $get('column_to_update') === 'workshop_id')
                                ->required(),

                            Select::make('value_relation_supplier')
                                ->label('Select New Supplier')
                                ->relationship('supplierList', 'name')
                                ->visible(fn(Get $get) => $get('column_to_update') === 'supplier_id')
                                ->required(),

                            // Tipe ENUM (Status)
                            Select::make('value_status')
                                ->label('Select New Status')
                                ->options(['draft' => 'Draft', 'active' => 'Active', 'phase_out' => 'Phase out', 'obsolete' => 'Obsolete'])
                                ->visible(fn(Get $get) => $get('column_to_update') === 'status')
                                ->required(),

                            // Tipe ENUM (Regrind Method)
                            Select::make('value_regrind')
                                ->label('Select New Regrind Method')
                                ->options(['inline' => 'Inline', 'offline' => 'Offline', 'no_regrind' => 'No regrind'])
                                ->visible(fn(Get $get) => $get('column_to_update') === 'regrind_method')
                                ->required(),

                            // Tipe BOOLEAN (Hazardous, Inspection)
                            Select::make('value_boolean')
                                ->label('Select Yes/No')
                                ->options(['0' => 'No', '1' => 'Yes'])
                                ->visible(fn(Get $get) => in_array($get('column_to_update'), ['is_hazardous', 'is_inspection_required']))
                                ->required(),

                            // Tipe STRING BIASA (Part No, Part Name, Delivery Loc, Mold No)
                            TextInput::make('value_string')
                                ->label('New Text Value')
                                ->visible(fn(Get $get) => in_array($get('column_to_update'), ['cust_part_no', 'cust_part_name', 'delivery_location', 'mold_no', 'drawing_no', 'hs_code']))
                                ->required(),
                        ])
                        ->action(function (Collection $records, array $data): void {
                            $column = $data['column_to_update'];

                            // Mapping input mana yang harus diambil berdasarkan kolomnya
                            $newValue = match (true) {
                                ($column === 'specification') => $data['value_textarea'],
                                in_array($column, ['spq', 'qty_bag', 'shift_capacity', 'cavity']) => $data['value_numeric'],
                                in_array($column, ['net_weight', 'gross_weight', 'cycle_time', 'carton_length', 'carton_width', 'carton_height']) => $data['value_decimal'],
                                ($column === 'workshop_id') => $data['value_relation_workshop'],
                                ($column === 'supplier_id') => $data['value_relation_supplier'],
                                ($column === 'status') => $data['value_status'],
                                ($column === 'regrind_method') => $data['value_regrind'],
                                in_array($column, ['is_hazardous', 'is_inspection_required']) => $data['value_boolean'],
                                default => $data['value_string'],
                            };

                            // Eksekusi Update massal
                            $records->each->update([$column => $newValue]);

                            Notification::make()
                                ->title('Mass edit success')
                                ->body(count($records) . " Records updated on field: {$column}")
                                ->success()
                                ->send();
                        })
                        ->deselectRecordsAfterCompletion()
                ]),
                Action::make('refresh')
                    ->label('Refresh')
                    ->icon(Heroicon::OutlinedArrowPath)
                    ->action(fn() => null),
                ExportAction::make('export')
                    ->label('Export')
                    ->icon(Heroicon::OutlinedArrowDownTray)
                    ->exporter(MaterialExporter::class)
            ]);
    }
}
