<?php

namespace App\Filament\Resources\Equipments\Tables;

use App\Filament\Exports\EquipmentExporter;
use App\Models\Branch;
use App\Models\Company;
use App\Models\EquipmentCategory;
use App\Models\Tonnage;
use App\Models\Workshop;
use Filament\Actions\Action;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ExportAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\QueryBuilder\Constraints\DateConstraint;
use Filament\QueryBuilder\Constraints\NumberConstraint;
use Filament\QueryBuilder\Constraints\SelectConstraint;
use Filament\QueryBuilder\Constraints\TextConstraint;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\QueryBuilder;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;

class EquipmentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('companyList.name')
                    ->label('Company')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('branchList.name')
                    ->label('Branch')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('category.name')
                    ->label('Category')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('code')
                    ->label('Code')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('name')
                    ->label('Name')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('specification')
                    ->label('Specification')
                    ->sortable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('equipment_no')
                    ->label('Machine No.')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('workshopList.name')
                    ->label('Workshop')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('tonnageList.name')
                    ->label('Tonnage')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('brand')
                    ->label('Brand')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('model_number')
                    ->label('Model Number')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('serial_number')
                    ->label('Serial No.')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('machine_rate')
                    ->label('Machine Rate')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('purchase_date')
                    ->date('d-M-Y')
                    ->label('Purchase Date')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('installation_date')
                    ->label('Installation Date')
                    ->date('d-M-Y')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('last_maintenance')
                    ->label('Last Maintenance Date')
                    ->date('d-M-Y')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('total_shots')
                    ->label('Total Shots')
                    ->sortable()
                    ->searchable()
                    ->alignRight()
                    ->toggleable(),
                TextColumn::make('status')
                    ->label('Machine/Equipment Status')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'standby' => 'Standby',
                        'running' => 'Running',
                        'breakdown' => 'Breakdown',
                        'repair' => 'Repair',
                        default => ucfirst($state), // Fallback kalau ada data lain
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'standby' => 'info',      // Biru: Sedang bersiap/menunggu
                        'running' => 'success',   // Hijau: Aman dan beroperasi normal
                        'breakdown' => 'danger',  // Merah: Rusak parah/berhenti beroperasi
                        'repair' => 'warning',    // Kuning/Oranye: Sedang dalam perbaikan
                        default => 'gray',        // Abu-abu: Default
                    })
                    ->icon(fn (string $state): string => match ($state) {
                        'standby' => 'heroicon-m-pause-circle',
                        'running' => 'heroicon-m-play-circle',
                        'breakdown' => 'heroicon-m-exclamation-triangle',
                        'repair' => 'heroicon-m-wrench-screwdriver',
                        default => 'heroicon-m-question-mark-circle',
                    })
                    ->toggleable()
                    ->searchable()
                    ->sortable(),
                TextColumn::make('is_active')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn ($state) => $state ? 'Enable' : 'Disable')
                    ->color(fn ($state) => $state ? 'success' : 'gray')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('description')
                    ->label('Remark')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('created_at')
                    ->label('Created Date')
                    ->date('Y-m-d H:i:s')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('creator.name')
                    ->label('Created By')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Updated Date')
                    ->date('Y-m-d H:i:s')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updater.name')
                    ->label('Updated By')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                QueryBuilder::make()
                    ->constraints([
                        TextConstraint::make('code ')
                            ->label('Code'),
                        TextConstraint::make('equipment_no')
                            ->label('Machine/Equipment No.'),
                        TextConstraint::make('name')
                            ->label('Name'),
                        TextConstraint::make('specification')
                            ->label('Specification'),
                        TextConstraint::make('brand')
                            ->label('Brand'),
                        TextConstraint::make('model_number')
                            ->label('Model No.'),
                        TextConstraint::make('serial_number ')
                            ->label('Serial No'),
                        TextConstraint::make('machine_rate')
                            ->label('Machine/Equipment Rate'),
                        TextConstraint::make('description')
                            ->label('Remark'),
                        NumberConstraint::make('total_shots')
                            ->label('Total Shots'),
                        DateConstraint::make('purchase_date')
                            ->label('Purchase Date'),
                        DateConstraint::make('installation_date')
                            ->label('Installation Date'),
                        DateConstraint::make('last_maintenance')
                            ->label('Last Maintenance Date'),
                        DateConstraint::make('created_at')
                            ->label('Created Date'),
                        DateConstraint::make('updated_at')
                            ->label('Updated Date'),
                        SelectConstraint::make('company_id')
                            ->label('Company')
                            ->options(fn () => Company::pluck('name', 'id'))
                            ->searchable(),
                        SelectConstraint::make('Branch')
                            ->label('Branch')
                            ->options(fn () => Branch::pluck('name', 'id'))
                            ->searchable(),
                        SelectConstraint::make('category_id')
                            ->label('Category')
                            ->options(fn () => EquipmentCategory::pluck('name', 'id'))
                            ->searchable(),
                        SelectConstraint::make('tonnage_id')
                            ->label('Tonnage')
                            ->options(fn () => Tonnage::pluck('code', 'id'))
                            ->searchable(),
                        SelectConstraint::make('status')
                            ->label('Machine Status')
                            ->options([
                                'standby' => 'Standby',
                                'running' => 'Running',
                                'breakdown' => 'Breakdown',
                                'repair' => 'Repair',
                            ])
                            ->searchable(),
                        SelectConstraint::make('is_active')
                            ->label('Status')
                            ->options([
                                '0' => 'Disable',
                                '1' => 'Enable',
                            ])
                            ->searchable(),
                        SelectConstraint::make('workshop_id ')
                            ->label('Workshop')
                            ->options(fn () => Workshop::pluck('name', 'id'))
                            ->searchable(),
                    ])
                    ->constraintPickerColumns(3),
            ])
            ->filtersLayout(FiltersLayout::Modal)
            ->filtersFormWidth('3xl')
            ->persistFiltersInSession()
            ->filtersTriggerAction(
                fn ($action) => $action
                    ->button()
                    ->label('Filter')
                    ->icon(Heroicon::OutlinedFunnel)
            )
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
                        ->modalWidth('3xl')
                        ->schema([
                            Grid::make(3)
                                ->schema([
                                    Select::make('column_to_update')
                                        ->label('Edit field name')
                                        ->options([
                                            'branch_id' => 'Branch',
                                            'equipment_no' => 'Machine/Equipment No.',
                                            'specification' => 'Specification',
                                            'tonnage_id' => 'Tonnage',
                                            'brand' => 'Brand',
                                            'model_number' => 'Model No.',
                                            'purchase_date' => 'Purchase Date',
                                            'machine_rate' => 'Machine/Equipment Rate',
                                            'status' => 'Machine/Equipment Status',
                                            'installation_date' => 'Installation Date',
                                            'total_shots' => 'Total Shots',
                                            'last_maintenance' => 'Last Maintenance Date',
                                            'workshop_id' => 'Workshop',
                                            'is_active' => 'Status',
                                        ])
                                        ->searchable()
                                        ->live()
                                        ->columnSpan(1),
                                    Select::make('value_branch_id')
                                        ->label('Branch')
                                        ->options(fn () => Branch::pluck('name', 'id'))
                                        ->searchable()
                                        ->preload()
                                        ->visible(fn (Get $get) => $get('column_to_update') === 'branch_id')
                                        ->required()
                                        ->columnSpan(2),
                                    Select::make('value_tonnage')
                                        ->label('Branch')
                                        ->options(fn () => Tonnage::pluck('code', 'id'))
                                        ->searchable()
                                        ->preload()
                                        ->visible(fn (Get $get) => $get('column_to_update') === 'tonnage_id')
                                        ->required()
                                        ->columnSpan(2),
                                    Select::make('value_workshop_id')
                                        ->label('Workshop')
                                        ->options(fn () => Workshop::pluck('name', 'id'))
                                        ->searchable()
                                        ->preload()
                                        ->visible(fn (Get $get) => $get('column_to_update') === 'workshop_id')
                                        ->required()
                                        ->columnSpan(2),
                                    Select::make('value_status')
                                        ->label('Branch')
                                        ->options([
                                            'standby' => 'Standby',
                                            'running' => 'Running',
                                            'breakdown' => 'Breakdown',
                                            'repair' => 'Repair',
                                        ])
                                        ->searchable()
                                        ->visible(fn (Get $get) => $get('column_to_update') === 'status')
                                        ->required()
                                        ->columnSpan(2),
                                    Select::make('value_is_active')
                                        ->label('Status')
                                        ->options([
                                            '0' => 'Disable',
                                            '1' => 'Enable',
                                        ])
                                        ->searchable()
                                        ->visible(fn (Get $get) => $get('column_to_update') === 'is_active')
                                        ->required()
                                        ->columnSpan(2),
                                    TextInput::make('value_equipment_no')
                                        ->label('Machine/Equipment No.')
                                        ->placeholder('Edit Machine/Equipment No.')
                                        ->required()
                                        ->visible(fn (Get $get) => $get('column_to_update') === 'equipment_no')
                                        ->columnSpan(2),
                                    TextInput::make('value_specification')
                                        ->label('Specification')
                                        ->placeholder('Edit specification')
                                        ->required()
                                        ->visible(fn (Get $get) => $get('column_to_update') === 'specification')
                                        ->columnSpan(2),
                                    TextInput::make('value_brand')
                                        ->label('Brand')
                                        ->placeholder('Edit specification')
                                        ->required()
                                        ->visible(fn (Get $get) => $get('column_to_update') === 'brand')
                                        ->columnSpan(2),
                                    TextInput::make('value_model_number')
                                        ->label('Model Number')
                                        ->placeholder('Edit model number')
                                        ->required()
                                        ->visible(fn (Get $get) => $get('column_to_update') === 'model_number')
                                        ->columnSpan(2),
                                    TextInput::make('value_machine_rate')
                                        ->label('Model Number')
                                        ->placeholder('Edit machine rate')
                                        ->required()
                                        ->visible(fn (Get $get) => $get('column_to_update') === 'machine_rate')
                                        ->columnSpan(2),
                                    TextInput::make('value_total_shots')
                                        ->label('Total Shots')
                                        ->placeholder('Edit total shots')
                                        ->numeric()
                                        ->required()
                                        ->visible(fn (Get $get) => $get('column_to_update') === 'total_shots')
                                        ->columnSpan(2),
                                    DatePicker::make('value_purchase_date')
                                        ->label('Purchase Date')
                                        ->required()
                                        ->visible(fn (Get $get) => $get('column_to_update') === 'purchase_date')
                                        ->columnSpan(2),
                                    DatePicker::make('value_installation_date')
                                        ->label('Installation Date')
                                        ->required()
                                        ->visible(fn (Get $get) => $get('column_to_update') === 'installation_date')
                                        ->columnSpan(2),
                                    DatePicker::make('value_last_maintenance')
                                        ->label('Last Maintenance Date')
                                        ->required()
                                        ->visible(fn (Get $get) => $get('column_to_update') === 'last_maintenance')
                                        ->columnSpan(2),
                                ]),
                        ])
                        ->action(function (Collection $records, array $data) {
                            $column = $data['column_to_update'];
                        })
                        ->deselectRecordsAfterCompletion()
                        ->modalSubmitActionLabel('Update'),
                ]),
                Action::make('refresh')
                    ->label('Refresh')
                    ->icon(Heroicon::OutlinedArrowPath)
                    ->action(fn () => null),
                ExportAction::make('export')
                    ->label('Export')
                    ->icon(Heroicon::OutlinedArrowDownTray)
                    ->exporter(EquipmentExporter::class),
                // ->columnMapping(false)
            ]);
    }
}
