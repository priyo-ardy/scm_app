<?php

namespace App\Filament\Resources\Tonnages\Tables;

use App\Filament\Exports\TonnageExporter;
use App\Models\Company;
use Filament\Actions\Action;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
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

class TonnagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('companyList.slug')
                    ->label('Company')
                    ->searchable(['name', 'slug'])
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('code')
                    ->label('Tonnage Code')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('name')
                    ->label('Tonnage Name')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('clamping_force_kn')
                    ->label('Clamping Force KN')
                    ->numeric()
                    ->sortable()
                    ->searchable()
                    ->suffix(' kN')
                    ->alignRight()
                    ->toggleable(),
                TextColumn::make('std_dbugging')
                    ->label('Standart Debugging')
                    ->numeric()
                    ->sortable()
                    ->searchable()
                    ->suffix(' Kg')
                    ->alignRight()
                    ->toggleable(),
                TextColumn::make('is_active')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (bool $state): string => $state ? 'Enable' : 'Disable')
                    ->color(fn (bool $state): string => $state ? 'success' : 'gray')
                    ->alignCenter()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('remark')
                    ->label('Remark')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                QueryBuilder::make()
                    ->constraints([
                        TextConstraint::make('code')
                            ->label('Code'),
                        TextConstraint::make('name')
                            ->label('Name'),
                        TextConstraint::make('remark')
                            ->label('Remarks'),
                        NumberConstraint::make('clamping_force_kn')
                            ->label('Clamping Force KN'),
                        NumberConstraint::make('std_dbugging')
                            ->label('Standart Debugging'),
                        SelectConstraint::make('company_id')
                            ->label('Company')
                            ->options(fn () => Company::query()->pluck('name', 'id'))
                            ->searchable(),
                        SelectConstraint::make('is_active')
                            ->label('Status')
                            ->options([
                                '0' => 'Disable',
                                '1' => 'Enable',
                            ])
                            ->searchable(),
                    ])
                    ->constraintPickerColumns(2),
            ], layout: FiltersLayout::Modal)
            ->filtersFormWidth('4xl')
            ->filtersTriggerAction(
                fn ($action) => $action
                    ->button()
                    ->label('Filter')
                    ->icon(Heroicon::OutlinedFunnel)
            )
            ->recordActions([
                // ViewAction::make(),
                // EditAction::make(),
                // DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                    BulkAction::make('bilkEdit')
                        ->label('Mass Edit')
                        ->color('warning')
                        ->icon(Heroicon::OutlinedPencilSquare)
                        ->modalWidth('3xl')
                        ->schema([
                            Grid::make(3)
                                ->schema([
                                    Select::make('column_to_update')
                                        ->label('Edit field name')
                                        ->searchable()
                                        ->options([
                                            'company_id' => 'Company',
                                            'clamping_force_kn' => 'Clamping Force KN',
                                            'std_dbugging' => 'Standart Debugging',
                                            'is_active' => 'Status',
                                            'remark' => 'Remark',
                                        ])
                                        ->live()
                                        ->columnSpan(1),
                                    Select::make('value_company_id')
                                        ->label('Company')
                                        ->options(fn () => Company::pluck('name', 'id'))
                                        ->searchable()
                                        ->required()
                                        ->columnSpan(2)
                                        ->visible(fn (Get $get) => $get('column_to_update') === 'company_id'),
                                    TextInput::make('value_clamping_force_kn')
                                        ->label('Clamping Force KN')
                                        ->numeric()
                                        ->required()
                                        ->placeholder('Edit Clamping Force KN')
                                        ->columnSpan(2)
                                        ->visible(fn (Get $get) => $get('column_to_update') === 'clamping_force_kn'),
                                    TextInput::make('value_std_dbugging')
                                        ->label('Standart Debugging Qty')
                                        ->numeric()
                                        ->required()
                                        ->columnSpan(2)
                                        ->placeholder('Edit Standart Debugging Qty')
                                        ->visible(fn (Get $get) => $get('column_to_update') === 'std_dbugging'),
                                    Select::make('value_is_active')
                                        ->label('Status')
                                        ->options([
                                            '0' => 'Disable',
                                            '1' => 'Enable',
                                        ])
                                        ->searchable()
                                        ->columnSpan(2)
                                        ->required()
                                        ->visible(fn (Get $get) => $get('column_to_update') === 'is_active'),
                                    TextInput::make('value_remark')
                                        ->label('Remark')
                                        ->placeholder('Edit Remark')
                                        ->columnSpan(2)
                                        ->visible(fn (Get $get) => $get('column_to_update') === 'remark'),
                                ]),
                        ])
                        ->action(function (Collection $records, array $data): void {
                            $column = $data['column_to_update'];

                            $newValue = match (true) {
                                ($column === 'company_id') => $data['value_company_id'],
                                ($column === 'clamping_force_kn') => $data['value_clamping_force_kn'],
                                ($column === 'std_dbugging') => $data['value_std_dbugging'],
                                ($column === 'is_active') => $data['value_is_active'],
                                ($column === 'remark') => $data['value_remark'],
                            };

                            $records->each->update([$column => $newValue]);

                            Notification::make()
                                ->title('Mass edit success')
                                ->body(count($records)." Records updated on field: {$column}")
                                ->success()
                                ->send();
                        }),
                ]),
                Action::make('refresh')
                    ->label('Refresh')
                    ->icon(Heroicon::OutlinedArrowPath)
                    ->action(fn () => null),
                ExportAction::make('export')
                    ->label('Export')
                    ->icon(Heroicon::OutlinedArrowDownTray)
                    ->exporter(TonnageExporter::class),
            ]);
    }
}
