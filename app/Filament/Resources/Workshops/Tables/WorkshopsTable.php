<?php

namespace App\Filament\Resources\Workshops\Tables;

use App\Filament\Exports\WorkshopExporter;
use App\Models\Branch;
use App\Models\Company;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ExportAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\QueryBuilder\Constraints\SelectConstraint;
use Filament\QueryBuilder\Constraints\TextConstraint;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\QueryBuilder;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class WorkshopsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('company.slug')
                    ->label('Company')
                    ->searchable(['name', 'slug'])
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('branch.name')
                    ->label('Branch')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('code')
                    ->label('Workshop Code')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('name')
                    ->label('Workshop Name')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('location_detail')
                    ->label('Location Details')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('user.name')
                    ->label('Workshop PIC')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('phone')
                    ->label('Workshop Ext. No.')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('remarks')
                    ->label('Remark')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('is_active')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn(bool $state): string => $state ? 'Enable' : 'Disable')
                    ->color(fn(bool $state): string => $state ? 'success' : 'gray')
                    ->alignCenter()
                    ->toggleable(),
                TextColumn::make('created_at')
                    ->label('Created At')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('creator.name')
                    ->label('Created By')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Updated At')
                    ->searchable()
                    ->sortable()
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
                        TextConstraint::make('code')->label('Code'),
                        TextConstraint::make('name')->label('name'),
                        TextConstraint::make('location_detail')->label('Location Details'),
                        TextConstraint::make('phone')->label('Ext. No.'),
                        SelectConstraint::make('company_id')
                            ->label('Company')
                            ->options(
                                fn() => Company::query()
                                    ->where('deleted_at', null)
                                    ->pluck('name', 'id')
                            )
                            ->searchable(),
                        SelectConstraint::make('branch_id')
                            ->label('branch_id')
                            ->label('Branch')
                            ->options(
                                fn() => Branch::query()
                                    ->where('is_active', true)
                                    ->where('deleted_at', null)
                                    ->pluck('name', 'id')
                            )
                            ->searchable(),
                        SelectConstraint::make('pic_id')
                            ->label('PIC')
                            ->options(fn() => User::query()
                                ->where('is_active', true)
                                ->where('deleted_at', null)
                                ->orderBy('name', 'asc')
                                ->pluck('name', 'id'))
                            ->searchable(),
                        SelectConstraint::make('is_active')
                            ->label('Status')
                            ->options([
                                '0' => 'Disable',
                                '1' => 'Enable'
                            ])
                            ->searchable()
                    ])
                    ->constraintPickerColumns(2)
            ], layout: FiltersLayout::Modal)
            ->filtersFormWidth('3xl')
            ->filtersTriggerAction(
                fn($action) => $action
                    ->button()
                    ->label('Filter')
                    ->icon(Heroicon::Funnel)
            )
            ->persistFiltersInSession()
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
                    BulkAction::make('bulEdit')
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
                                        ->options([
                                            'branch_id' => 'Branch',
                                            'location_detail' => 'Location Detail',
                                            'pic_id' => 'PIC',
                                            'phone' => 'Extension No.',
                                            'is_active' => 'Status'
                                        ])
                                        ->live()
                                        ->columnSpan(1),
                                    Select::make('value_branch')
                                        ->label('Branch')
                                        ->options(
                                            fn() => Branch::query()
                                                ->where('is_active', true)
                                                ->where('deleted_at', null)
                                                ->orderByLeftPowerJoins('name', 'asc')
                                                ->pluck('name', 'id')
                                        )
                                        ->searchable()
                                        ->required()
                                        ->visible(fn(Get $get) => $get('column_to_update') === 'branch_id')
                                        ->columnSpan(2),
                                    TextInput::make('value_location_detail')
                                        ->label('Location Details')
                                        ->required()
                                        ->placeholder('Edit location details')
                                        ->columnSpan(2)
                                        ->visible(fn(Get $get) => $get('column_to_update') === 'location_detail'),
                                    Select::make('value_pic_id')
                                        ->label('PIC')
                                        ->options(
                                            fn() => User::query()
                                                ->where('is_active', true)
                                                ->where('deleted_at', null)
                                                ->orderBy('name', 'asc')
                                                ->pluck('name', 'id')
                                        )
                                        ->searchable()
                                        ->required()
                                        ->columnSpan(2)
                                        ->visible(fn(Get $get) => $get('column_to_update') === 'pic_id'),
                                    TextInput::make('value_phone')
                                        ->label('Extension No.')
                                        ->required()
                                        ->placeholder('Edit extension no.')
                                        ->columnSpan(2)
                                        ->visible(fn(Get $get) => $get('column_to_update') === 'phone'),
                                    Select::make('value_is_active')
                                        ->label('Status')
                                        ->options([
                                            '0' => 'Disable',
                                            '1' => 'Enable'
                                        ])
                                        ->searchable()
                                        ->required()
                                        ->columnSpan(2)
                                        ->visible(fn(Get $get) => $get('column_to_update') === 'is_active'),
                                ])
                        ])
                        ->action(function (Collection $records, array $data): void {
                            $column = $data['column_to_update'];

                            $newValue = match (true) {
                                ($column === 'branch_id') => $data['value_branch'],
                                ($column === 'location_detail') => $data['value_location_detail'],
                                ($column === 'pic_id') => $data['value_pic_id'],
                                ($column === 'phone') => $data['value_phone'],
                                ($column === 'is_active') => $data['value_is_active'],
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
                    ->label('Export')
                    ->exporter(WorkshopExporter::class)
                    ->icon(Heroicon::OutlinedArrowDownTray),
            ]);
    }
}
