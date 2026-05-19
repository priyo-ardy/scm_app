<?php

namespace App\Filament\Resources\Materials\Tables;

use App\Filament\Exports\MaterialExporter;
use App\Models\Company;
use App\Models\MaterialCategory;
use App\Models\Supplier;
use App\Models\User;
use App\Models\Workshop;
use Filament\Actions\Action;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ExportAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\QueryBuilder\Constraints\SelectConstraint;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\QueryBuilder;
use Filament\Tables\Table;
use Illuminate\Support\Collection;

class MaterialsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('companyList.slug')
                    ->label('Company')
                    ->numeric()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('code')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('short_code')
                    ->label('Short Code')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('unitList.code')
                    ->label('Base Unit')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('purchaseUnitList.code')
                    ->label('Purchase Unit')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('unit_conversion_rate')
                    ->label('Unit Conversion Rate')
                    ->numeric()
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('spq')
                    ->label('SPQ')
                    ->numeric()
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('qty_bag')
                    ->label('Qty/Bag')
                    ->numeric()
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('net_weight')
                    ->label('Net Weight')
                    ->numeric()
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('gross_weight')
                    ->label('Gross Weight')
                    ->numeric()
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('sprue')
                    ->label('Sprue Weight')
                    ->numeric()
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('cycle_time')
                    ->label('Cycle Time')
                    ->numeric()
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('shift_capacity')
                    ->label('Shift Capacity')
                    ->numeric()
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('properties')
                    ->label('Material Properties')
                    ->formatStateUsing(fn ($state) => ucwords(str_replace('_', ' ', $state)))
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('color')
                    ->label('Product Color')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('cavity')
                    ->label('Number of Cavity')
                    ->numeric()
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('workshopList.name')
                    ->label('Workshop')
                    ->numeric()
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('categoryList.name')
                    ->label('Category')
                    ->numeric()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('cust_part_no')
                    ->label('Customer Part No.')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('cust_part_name')
                    ->label('Customer Part Name')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('delivery_location')
                    ->label('Delivery Location')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('mold_no')
                    ->label('Mold No.')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('enable_min_stock')
                    ->label('Enable Min. Stock')
                    ->badge()
                    ->alignCenter()
                    ->color(fn (bool $state): string => $state ? 'success' : 'danger')
                    ->formatStateUsing(fn (bool $state): string => $state ? 'Yes' : 'No')
                    ->toggleable(),
                TextColumn::make('min_stock')
                    ->numeric()
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('enable_safety_stock')
                    ->label('Enable Safety Stock')
                    ->badge()
                    ->alignCenter()
                    ->color(fn (bool $state): string => $state ? 'success' : 'danger')
                    ->formatStateUsing(fn (bool $state): string => $state ? 'Yes' : 'No')
                    ->toggleable(),
                TextColumn::make('safety_stock')
                    ->numeric()
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('enabl_max_stock')
                    ->label('Enable Max. Stock')
                    ->badge()
                    ->alignCenter()
                    ->color(fn (bool $state): string => $state ? 'success' : 'danger')
                    ->formatStateUsing(fn (bool $state): string => $state ? 'Yes' : 'No')
                    ->toggleable(),
                TextColumn::make('max_stock')
                    ->numeric()
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('reorder_point')
                    ->label('Reorder Point')
                    ->numeric()
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('supplierList.name')
                    ->label('Default Supplier')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('is_hazardous')
                    ->label('Hazardous Status')
                    ->badge()
                    ->alignCenter()
                    ->color(fn (bool $state): string => $state ? 'success' : 'danger')
                    ->formatStateUsing(fn (bool $state): string => $state ? 'Yes' : 'No')
                    ->toggleable(),
                TextColumn::make('storage_location_id')
                    ->label('Default Storage Location')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('enable_expired')
                    ->label('Enable Expired Date')
                    ->badge()
                    ->alignCenter()
                    ->color(fn (bool $state): string => $state ? 'success' : 'danger')
                    ->formatStateUsing(fn (bool $state): string => $state ? 'Yes' : 'No')
                    ->toggleable(),
                TextColumn::make('expiry_days')
                    ->label('Expaired Days')
                    ->numeric()
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('lead_time_days')
                    ->label('Lead Time')
                    ->numeric()
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->formatStateUsing(fn ($state) => ucwords(str_replace('_', ' ', $state)))
                    ->color(fn ($state) => match ($state) {
                        'draft' => 'gray',
                        'active' => 'success',
                        'phase_out' => 'warning',
                        'obsolete' => 'danger',
                        default => 'secondary',
                    })
                    ->badge()
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('revision_no')
                    ->label('Drawing Revision No.')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('hs_code')
                    ->label('HS Code')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('regrind_method')
                    ->label('Regrid Method')
                    ->badge()
                    ->formatStateUsing(fn ($state) => ucwords(str_replace('_', ' ', $state)))
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('carton_category')
                    ->label('Carton Category')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('carton_length')
                    ->label('Carton Length')
                    ->numeric()
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('carton_width')
                    ->label('Cartong Width')
                    ->numeric()
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('carton_height')
                    ->label('Carton Height')
                    ->numeric()
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('dimensionUnitList.code')
                    ->label('Carton Dimension Unit')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('stacking_limit')
                    ->label('Stacking Limit')
                    ->numeric()
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('is_inspection_required')
                    ->label('Required Inspection Status')
                    ->badge()
                    ->alignCenter()
                    ->color(fn (bool $state): string => $state ? 'success' : 'danger')
                    ->formatStateUsing(fn (bool $state): string => $state ? 'Yes' : 'No')
                    ->toggleable(),
                TextColumn::make('last_purchase_price')
                    ->label('Last Purchase Price')
                    ->money('IDR')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('drawing_no')
                    ->label('Drawing No.')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('process_routes')
                    ->label('Process Routes')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('drawing_level')
                    ->label('Drawing Level')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('tonnageList.name')
                    ->label('Tonnage')
                    ->label('Tonnage')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('created_at')
                    ->label('Created Date')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('creator.name')
                    ->label('Created By')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Updated Date')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updater.name')
                    ->label('Updated By By')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('deleted_at')
                    ->label('Deleted Date')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                QueryBuilder::make()
                    ->constraints([
                        // --- 1. IDENTITAS (TEXT) ---
                        QueryBuilder\Constraints\TextConstraint::make('code')
                            ->label('Material Code'),
                        QueryBuilder\Constraints\TextConstraint::make('short_code')
                            ->label('Short Code'),
                        QueryBuilder\Constraints\TextConstraint::make('name')
                            ->label('Material Name'),
                        QueryBuilder\Constraints\TextConstraint::make('specification')
                            ->label('Specification'),
                        QueryBuilder\Constraints\TextConstraint::make('description')
                            ->label('Description'),
                        QueryBuilder\Constraints\TextConstraint::make('cust_part_no')
                            ->label('Customer Part No'),
                        QueryBuilder\Constraints\TextConstraint::make('cust_part_name')
                            ->label('Customer Part Name'),
                        QueryBuilder\Constraints\TextConstraint::make('drawing_no')
                            ->label('Drawing No'),

                        // --- 2. TEKNIS & BERAT (NUMBER/DECIMAL) ---
                        QueryBuilder\Constraints\NumberConstraint::make('net_weight')
                            ->label('Net Weight'),
                        QueryBuilder\Constraints\NumberConstraint::make('gross_weight')
                            ->label('Gross Weight'),
                        QueryBuilder\Constraints\NumberConstraint::make('cycle_time')
                            ->label('Cycle Time'),
                        QueryBuilder\Constraints\NumberConstraint::make('cavity')
                            ->label('Cavity'),
                        QueryBuilder\Constraints\NumberConstraint::make('spq')
                            ->label('SPQ'),
                        QueryBuilder\Constraints\NumberConstraint::make('qty_bag')
                            ->label('Qty/Bag'),
                        QueryBuilder\Constraints\NumberConstraint::make('shift_capacity')
                            ->label('Shift Capacity'),

                        // --- 3. STATUS & PILIHAN (SELECT) ---
                        QueryBuilder\Constraints\SelectConstraint::make('status')
                            ->options([
                                'draft' => 'Draft',
                                'active' => 'Active',
                                'phase_out' => 'Phase Out',
                                'obsolete' => 'Obsolete',
                            ]),
                        QueryBuilder\Constraints\SelectConstraint::make('properties')
                            ->options([
                                'purchase' => 'Purchase',
                                'self_made' => 'Self Made',
                                'sub_contract' => 'Sub Contract',
                                'asset' => 'Asset',
                            ]),
                        QueryBuilder\Constraints\SelectConstraint::make('regrind_method')
                            ->options([
                                'inline' => 'Inline',
                                'offline' => 'Offline',
                                'no_regrind' => 'No Regrind',
                            ]),

                        // --- 4. RELASI (SELECT DARI DATABASE) ---
                        QueryBuilder\Constraints\SelectConstraint::make('company_id')
                            ->label('Company')
                            ->options(Company::pluck('name', 'id'))
                            ->searchable(),
                        QueryBuilder\Constraints\SelectConstraint::make('workshop_id')
                            ->label('Workshop')
                            ->options(Workshop::pluck('name', 'id'))
                            ->searchable(),
                        QueryBuilder\Constraints\SelectConstraint::make('supplier_id')
                            ->label('Supplier')
                            ->options(Supplier::pluck('name', 'id'))
                            ->searchable(),
                        QueryBuilder\Constraints\SelectConstraint::make('category_id')
                            ->label('Category')
                            ->options(MaterialCategory::pluck('name', 'id'))
                            ->searchable(),
                        SelectConstraint::make('created_by')
                            ->label('Created By')
                            ->options(User::pluck('name', 'id'))
                            ->searchable(),
                        SelectConstraint::make('updated_by')
                            ->label('Created By')
                            ->options(User::pluck('name', 'id'))
                            ->searchable(),

                        // --- 5. LOGIKA / FLAG (BOOLEAN) ---
                        QueryBuilder\Constraints\BooleanConstraint::make('is_hazardous')
                            ->label('Is Hazardous'),
                        QueryBuilder\Constraints\BooleanConstraint::make('is_inspection_required')
                            ->label('Inspection Required'),
                        QueryBuilder\Constraints\BooleanConstraint::make('enable_min_stock')
                            ->label('Enable Min Stock'),
                        QueryBuilder\Constraints\BooleanConstraint::make('enable_expired')
                            ->label('Enable Expired'),

                        // --- 6. TANGGAL (DATE) ---
                        QueryBuilder\Constraints\DateConstraint::make('created_at')
                            ->label('Created Date'),
                        QueryBuilder\Constraints\DateConstraint::make('updated_at')
                            ->label('Updated Date'),
                    ])
                    ->constraintPickerColumns(4),
            ], layout: FiltersLayout::Modal)
            ->filtersFormWidth('4xl')
            ->filtersFormColumns(1)
            ->persistFiltersInSession()
            ->recordActions([
                // EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                    BulkAction::make('bulkEdit')
                        ->label('Mass Edit')
                        ->color('warning')
                        ->icon(Heroicon::OutlinedPencilSquare)
                        ->schema([
                            Grid::make(3)
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
                                        ])
                                        ->columnSpan(1),

                                    // Tipe TEXTAREA (Specification)
                                    Textarea::make('value_textarea')
                                        ->label('New Specification')
                                        ->visible(fn (Get $get) => $get('column_to_update') === 'specification')
                                        ->required()
                                        ->columnSpan(2),

                                    // Tipe NUMERIC (SPQ, Qty/Bag, Cavity, Capacity)
                                    TextInput::make('value_numeric')
                                        ->label('New Value (Integer)')
                                        ->numeric()
                                        ->visible(fn (Get $get) => in_array($get('column_to_update'), ['spq', 'qty_bag', 'shift_capacity', 'cavity']))
                                        ->required()
                                        ->columnSpan(2),

                                    // Tipe DECIMAL (Weights, Cycle Time, Carton Dims)
                                    TextInput::make('value_decimal')
                                        ->label('New Value (Decimal)')
                                        ->numeric()
                                        ->step('0.00001')
                                        ->visible(fn (Get $get) => in_array($get('column_to_update'), ['net_weight', 'gross_weight', 'cycle_time', 'carton_length', 'carton_width', 'carton_height']))
                                        ->required()
                                        ->columnSpan(2),

                                    // Tipe RELATIONSHIP (Workshop, Supplier, Tonnage, Unit)
                                    Select::make('value_relation_workshop')
                                        ->label('Select New Workshop')
                                        ->relationship('workshopList', 'name')
                                        ->visible(fn (Get $get) => $get('column_to_update') === 'workshop_id')
                                        ->required()
                                        ->columnSpan(2),

                                    Select::make('value_relation_supplier')
                                        ->label('Select New Supplier')
                                        ->relationship('supplierList', 'name')
                                        ->visible(fn (Get $get) => $get('column_to_update') === 'supplier_id')
                                        ->required()
                                        ->columnSpan(2),

                                    // Tipe ENUM (Status)
                                    Select::make('value_status')
                                        ->label('Select New Status')
                                        ->options(['draft' => 'Draft', 'active' => 'Active', 'phase_out' => 'Phase out', 'obsolete' => 'Obsolete'])
                                        ->visible(fn (Get $get) => $get('column_to_update') === 'status')
                                        ->required()
                                        ->columnSpan(2),

                                    // Tipe ENUM (Regrind Method)
                                    Select::make('value_regrind')
                                        ->label('Select New Regrind Method')
                                        ->options(['inline' => 'Inline', 'offline' => 'Offline', 'no_regrind' => 'No regrind'])
                                        ->visible(fn (Get $get) => $get('column_to_update') === 'regrind_method')
                                        ->required()
                                        ->columnSpan(2),

                                    // Tipe BOOLEAN (Hazardous, Inspection)
                                    Select::make('value_boolean')
                                        ->label('Select Yes/No')
                                        ->options(['0' => 'No', '1' => 'Yes'])
                                        ->visible(fn (Get $get) => in_array($get('column_to_update'), ['is_hazardous', 'is_inspection_required']))
                                        ->required()
                                        ->columnSpan(2),

                                    // Tipe STRING BIASA (Part No, Part Name, Delivery Loc, Mold No)
                                    TextInput::make('value_string')
                                        ->label('New Text Value')
                                        ->visible(fn (Get $get) => in_array($get('column_to_update'), ['cust_part_no', 'cust_part_name', 'delivery_location', 'mold_no', 'drawing_no', 'hs_code']))
                                        ->required()
                                        ->columnSpan(2),
                                ]),
                        ])
                        ->modalWidth('3xl')
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
                                ->body(count($records)." Records updated on field: {$column}")
                                ->success()
                                ->send();
                        })
                        ->deselectRecordsAfterCompletion(),
                ]),
                Action::make('refresh')
                    ->label('Refresh')
                    ->icon(Heroicon::OutlinedArrowPath)
                    ->action(fn () => null),
                ExportAction::make('export')
                    ->label('Export')
                    ->icon(Heroicon::OutlinedArrowDownTray)
                    ->exporter(MaterialExporter::class),
            ]);
    }
}
