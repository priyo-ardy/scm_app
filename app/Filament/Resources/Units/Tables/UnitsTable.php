<?php

namespace App\Filament\Resources\Units\Tables;

use App\Filament\Exports\UnitExporter;
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

use function Laravel\Prompts\select;

class UnitsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')
                    ->label('Symbol')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('name')
                    ->label('Unit Name')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('category')
                    ->label('Unit Category')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('baseUnit.name')
                    ->label('Base Unit')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('conversion_factor')
                    ->label('Coversion Rate')
                    ->numeric()
                    ->sortable()
                    ->searchable()
                    ->alignRight()
                    ->toggleable(),
                TextColumn::make('is_active')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn(bool $state): string => $state ? 'Enable' : 'Disable')
                    ->color(fn(bool $state): string => $state ? 'success' : 'gray')
                    ->alignCenter()
                    ->toggleable(),
            ])
            ->filters([
                QueryBuilder::make()
                    ->constraints([
                        TextConstraint::make('code')->label('Code'),
                        TextConstraint::make('name')->label('Name'),
                        NumberConstraint::make('conversion_factor')
                            ->label('Conversion Rate'),
                        SelectConstraint::make('category ')
                            ->label('Category')
                            ->options([
                                'length' => 'Length',
                                'mass' => 'Mass',
                                'volume' => 'Volume',
                                'other' => 'Others',
                            ])
                            ->searchable(),
                        SelectConstraint::make('base_unit_id')
                            ->label('Base Unit')
                            ->relationship('baseUnit', 'name')
                            ->searchable(),
                    ])
                    ->constraintPickerColumns(2)
            ], layout: FiltersLayout::Modal)
            ->filtersFormWidth('3xl')
            ->filtersTriggerAction(
                fn($action) => $action
                    ->button()
                    ->label('Filter')
                    ->icon(Heroicon::OutlinedFunnel),
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
                        ->color('warning')
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
                                            'category' => 'Unit Category',
                                            'base_unit_id' => 'Base Unit',
                                            'conversion_factor' => 'Conversion Rate',
                                            'is_active' => 'Status'
                                        ])
                                        ->columnSpan(1),
                                    Select::make('value_category')
                                        ->label('Category')
                                        ->options([
                                            'length' => 'Length',
                                            'mass' => 'Mass',
                                            'volume' => 'Volume',
                                            'other' => 'Others',
                                        ])
                                        ->required()
                                        ->visible(fn(Get $get) => $get('column_to_update') === 'category')
                                        ->columnSpan(2)
                                        ->searchable(),
                                    Select::make('value_base_unit')
                                        ->label('Base Unit')
                                        ->required()
                                        ->relationship('baseUnit', 'name')
                                        ->searchable()
                                        ->visible(fn(Get $get) => $get('column_to_update') === 'base_unit_id')
                                        ->columnSpan(2),
                                    TextInput::make('value_conversion_factor')
                                        ->label('Conversion')
                                        ->required()
                                        ->numeric()
                                        ->visible(fn(Get $get) => $get('column_to_update') === 'conversion_factor')
                                        ->placeholder('Unit Conversion Rate')
                                        ->columnSpan(2),
                                    Select::make('value_is_active')
                                        ->label('Status')
                                        ->options([
                                            '0' => 'Disable',
                                            '1' => 'Enable'
                                        ])
                                        ->searchable()
                                        ->required()
                                        ->columnSpan(2)
                                ])
                        ])
                        ->action(function (Collection $records, array $data): void {
                            $column = $data['column_to_update'];

                            $newValue = match (true) {
                                ($column === 'category') => $data['value_category'],
                                ($column === 'base_unit_id') => $data['value_base_unit'],
                                ($column === 'conversion_factor') => $data['value_conversion_factor'],
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
                ExportAction::make()
                    ->exporter(UnitExporter::class)
                    ->label('Export')
                    ->icon(Heroicon::OutlinedArrowDownTray),
            ]);
    }
}
