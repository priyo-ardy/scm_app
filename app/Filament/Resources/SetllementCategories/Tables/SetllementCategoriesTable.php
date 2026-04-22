<?php

namespace App\Filament\Resources\SetllementCategories\Tables;

use App\Filament\Exports\SettlementCategoryExporter;
use Filament\Actions\Action;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ExportAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\QueryBuilder\Constraints\DateConstraint;
use Filament\QueryBuilder\Constraints\SelectConstraint;
use Filament\QueryBuilder\Constraints\TextConstraint;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\QueryBuilder;
use Filament\Tables\Table;
use Illuminate\Support\Collection;

class SetllementCategoriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')
                    ->label('Code')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('name')
                    ->label('Name')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('is_active')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (string $state) => $state ? 'Enable' : 'Disable')
                    ->color(fn (string $state) => $state ? 'success' : 'gray')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('description')
                    ->label('Remark')
                    ->toggleable(),
                TextColumn::make('created_at')
                    ->label('Created At')
                    ->date()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('creatorList.name')
                    ->label('Created By')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Updated At')
                    ->date()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updaterList.name')
                    ->label('Updated By')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                QueryBuilder::make()
                    ->constraints([
                        TextConstraint::make('code')
                            ->label('Code'),
                        TextConstraint::make('name')
                            ->label('Name'),

                        DateConstraint::make('created_at')
                            ->label('Crated At'),
                        DateConstraint::make('updated_at')
                            ->label('Updated_at'),

                        SelectConstraint::make('is_active')
                            ->label('Status')
                            ->options([
                                '0' => 'Disable',
                                '1' => 'Enable',
                            ])
                            ->searchable(),
                        SelectConstraint::make('created_by')
                            ->label('Created By')
                            ->relationship('creatorList', 'name')
                            ->searchable(),
                        SelectConstraint::make('updated_by')
                            ->label('Updated By')
                            ->relationship('updaterList', 'name')
                            ->searchable(),
                    ]),
            ], layout: FiltersLayout::Modal)
            ->filtersFormWidth('3xl')
            ->filtersTriggerAction(
                fn ($action) => $action
                    ->button()
                    ->label('Filter')
                    ->icon(Heroicon::OutlinedFunnel)
            )
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
                        ->icon(Heroicon::OutlinedPencilSquare)
                        ->modalWidth('2xl')
                        ->schema([
                            Grid::make(3)
                                ->schema([
                                    Select::make('column_to_update')
                                        ->label('Edit field name')
                                        ->searchable()
                                        ->live()
                                        ->options([
                                            'is_active' => 'Status',
                                        ])
                                        ->default('is_active')
                                        ->columnSpan(1),

                                    Select::make('value_is_active')
                                        ->label('Status')
                                        ->visible(fn (Get $get) => $get('column_to_update') === 'is_active')
                                        ->options([
                                            '0' => 'Disable',
                                            '1' => 'Enable',
                                        ])
                                        ->searchable()
                                        ->required()
                                        ->columnSpan(2),
                                ]),
                        ])
                        ->action(function (Collection $records, array $data): void {
                            $column = $data['column_to_update'];

                            $newValue = match (true) {
                                ($column === 'is_active') => $data['value_is_active'],
                                default => null
                            };

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
                    ->exporter(SettlementCategoryExporter::class),
            ]);
    }
}
