<?php

namespace App\Filament\Resources\Departments\Tables;

use App\Filament\Exports\DepartmentExporter;
use App\Models\Company;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ExportAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\QueryBuilder\Constraints\SelectConstraint;
use Filament\QueryBuilder\Constraints\TextConstraint;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\QueryBuilder;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;

class DepartmentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('companyList.slug')
                    ->label('Company')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('code')
                    ->label('Code')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('managerList.name')
                    ->label('Department Manager')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('is_active')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn($state) => $state ? 'Enable' : 'Disable')
                    ->color(fn($state) => $state ? 'success' : 'gray')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('cost_center_code')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('remark')
                    ->label('Remark')
                    ->searchable()
                    ->sortable(),
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
                TextColumn::make('creatorList.name')
                    ->label('Created By')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updaterList.name')
                    ->label('Updated By')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                QueryBuilder::make()
                    ->constraints([
                        TextConstraint::make('code')
                            ->label('Code'),
                        TextConstraint::make('name')
                            ->label('Name'),
                        TextConstraint::make('cost_center_code ')
                            ->label('Cost Center Code'),
                        SelectConstraint::make('company_id')
                            ->label('Company')
                            ->options(fn() => Company::pluck('name', 'id'))
                            ->searchable()
                            ->native(false),
                        SelectConstraint::make('managet_id')
                            ->label('Department Manager')
                            ->options(fn() => User::orderBy('name', 'asc')->pluck('name', 'id'))
                            ->searchable()
                            ->native(false),
                        SelectConstraint::make('is_active')
                            ->label('Status')
                            ->options([
                                '0' => 'Disable',
                                '1' => 'Enable'
                            ])
                            ->searchable()
                            ->native(false)
                    ])
            ], layout: FiltersLayout::Modal)
            ->filtersFormWidth('4xl')
            ->persistFiltersInSession()
            ->filtersTriggerAction(
                fn($action) => $action
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
                        ->schema([
                            Grid::make(3)
                                ->schema([
                                    Select::make('column_to_update')
                                        ->label('Field to update')
                                        ->options([
                                            'manager_id' => 'Department Manager',
                                            'is_active' => 'Status'
                                        ])
                                        ->searchable()
                                        ->live()
                                        ->columnSpan(1),
                                    Select::make('value_manager_id')
                                        ->label('Department Manager')
                                        ->options(fn() => User::orderBy('name', 'asc')->pluck('name', 'id'))
                                        ->searchable()
                                        ->required()
                                        ->visible(fn(Get $get) => $get('column_to_update') === 'manager_id')
                                        ->columnSpan(2),
                                    Select::make('value_is_active')
                                        ->label('Status')
                                        ->options([
                                            '0' => 'Disable',
                                            '1' => "Enable"
                                        ])
                                        ->searchable()
                                        ->required()
                                        ->visible(fn(Get $get) => $get('column_to_update') === 'is_active')
                                        ->columnSpan(2),
                                ])
                        ])
                        ->action(function (Collection $records, array $data): void {
                            $column = $data['column_to_update'];

                            $newValue = match (true) {
                                ($column === 'manager_id') => $data['value_manager_id'],
                                ($column === 'is_active') => $data['value_is_active']
                            };

                            $records->each->update([$column => $newValue]);

                            Notification::make()
                                ->title('Mass edit success')
                                ->body(count($records) . " Records updated on field: {$column}")
                                ->success()
                                ->send();
                        })
                ]),
                Action::make('refresh')
                    ->label('Refresh')
                    ->icon(Heroicon::OutlinedArrowPath)
                    ->action(fn() => null),
                ExportAction::make('export')
                    ->label('Export')
                    ->icon(Heroicon::OutlinedArrowDownTray)
                    ->exporter(DepartmentExporter::class)
            ]);
    }
}
