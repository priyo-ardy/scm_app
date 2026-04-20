<?php

namespace App\Filament\Resources\PaymentMethods\Tables;

use App\Filament\Exports\PaymentMethodExporter;
use Filament\Actions\Action;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ExportAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
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
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;

class PaymentMethodsTable
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
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('categoryList.name')
                    ->label('Settlement Category')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('type')
                    ->label('Business Type')
                    ->searchable()
                    ->sortable()
                    ->toggleable()
                    ->formatStateUsing(fn(string $state) => ucwords(str_replace('_', ' ', $state))),
                TextColumn::make('commission_fee')
                    ->label('Commission Fee')
                    ->badge()
                    ->sortable()
                    ->formatStateUsing(fn(string $state) => $state ? 'Yes' : 'No')
                    ->color(fn(string $state) => $state ? 'success' : 'gray')
                    ->alignCenter()
                    ->toggleable(),
                TextColumn::make('payment_mode')
                    ->label('Mode of Payment')
                    ->searchable()
                    ->formatStateUsing(fn(string $state) => ucwords(str_replace('_', ' ', $state)))
                    ->toggleable(),
                TextColumn::make('is_active')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn(string $state): string => $state ? 'Enable' : 'Disable')
                    ->color(fn(string $state): string => $state ? 'success' : 'gray')
                    ->alignCenter(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('creatorList.name')
                    ->label('Created By')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updaterList.name')
                    ->label('Updated By')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                QueryBuilder::make()
                    ->constraints([
                        TextConstraint::make('code')
                            ->label('code'),
                        TextConstraint::make('name')
                            ->label('Name'),
                        SelectConstraint::make('category_id')
                            ->label('Settlement Category')
                            ->searchable()
                            ->relationship('categoryList', 'name'),
                        SelectConstraint::make('type')
                            ->label('Business type')
                            ->options([
                                'cash' => 'Cash',
                                'banking' => 'Banking',
                                'bill_transaction' => 'Bill Transaction',
                                'internal_settlement' => 'Internal Settlement'
                            ])
                            ->searchable(),
                        SelectConstraint::make('commission_fee')
                            ->label('Commission Fee')
                            ->options([
                                '0' => 'No',
                                '1' => 'Yes'
                            ])
                            ->searchable(),
                        SelectConstraint::make('payment_mode')
                            ->label('Payment Mode')
                            ->options([
                                'directly_withheld' => 'Directly Withheld'
                            ])
                            ->searchable(),
                        TextConstraint::make('description')
                            ->label('Remarks')
                    ])->constraintPickerColumns(3)
            ], layout: FiltersLayout::Modal)
            ->filtersFormWidth('3xl')
            ->filtersTriggerAction(
                fn($action) => $action
                    ->button()
                    ->label('Filter')
                    ->icon(Heroicon::OutlinedFunnel)
            )
            ->persistFiltersInSession()
            ->recordActions([
                ViewAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                    BulkAction::make('bulkEdit')
                        ->label('Mass Edit')
                        ->icon(Heroicon::OutlinedPencilSquare)
                        ->color('warning')
                        ->modalWidth('4xl')
                        ->schema([
                            Grid::make(3)
                                ->schema([
                                    Select::make('column_to_edit')
                                        ->label('Edit field name')
                                        ->searchable()
                                        ->live()
                                        ->options([
                                            'category_id' => 'Settlement Category',
                                            'type' => 'Business Type',
                                            'commission_fee' => 'Commission Fee',
                                            'payment_mode' => 'Mode of Payment',
                                            'description' => 'Remarks',
                                            'is_active' => 'Status'
                                        ])
                                        ->columnSpan(1),
                                    Select::make('value_category_id')
                                        ->label('Settlement Category')
                                        ->relationship('categoryList', 'name')
                                        ->searchable()
                                        ->visible(fn(Get $get) => $get('column_to_edit') === 'category_id')
                                        ->columnSpan(2)
                                        ->required(),
                                    Select::make('value_type')
                                        ->label('Business Type')
                                        ->options([
                                            'cash' => 'Cash',
                                            'banking' => 'Banking',
                                            'bill_transaction' => 'Bill Transaction',
                                            'internal_settlement' => 'Internal Settlement'
                                        ])
                                        ->searchable()
                                        ->required()
                                        ->columnSpan(2)
                                        ->visible(fn(Get $get) => $get('column_to_edit') === 'type'),
                                    Select::make('value_commission_fee')
                                        ->label('Commission Fee')
                                        ->options([
                                            '0' => 'No',
                                            '1' => 'Yes'
                                        ])
                                        ->searchable()
                                        ->required()
                                        ->columnSpan(2)
                                        ->visible(fn(Get $get) => $get('column_to_edit') === 'commission_fee'),
                                    Select::make('value_payment_mode')
                                        ->label('Payment Mode')
                                        ->options([
                                            'directly_withheld' => 'Directly Withheld'
                                        ])
                                        ->searchable()
                                        ->columnSpan(2)
                                        ->required()
                                        ->visible(fn(Get $get) => $get('column_to_edit') === 'payment_mode'),
                                    Select::make('value_is_active')
                                        ->label('Status')
                                        ->options([
                                            '0' => "Disable",
                                            '1' => "Enable"
                                        ])
                                        ->searchable()
                                        ->columnSpan(2)
                                        ->required()
                                        ->visible(fn(Get $get) => $get('column_to_edit') === 'is_active'),
                                    Textarea::make('value_description')
                                        ->required()
                                        ->columnSpan(2)
                                        ->visible(fn(Get $get) => $get('column_to_edit') === 'description')
                                        ->nullable()

                                ])
                        ])
                        ->action(function (Collection $records, array $data): void {
                            $column = $data['column_to_edit'];

                            $newValue = match (true) {
                                ($column === 'category_id') => $data['value_category_id'],
                                ($column === 'type') => $data['value_type'],
                                ($column === 'commission_fee') => $data['value_commission_fee'],
                                ($column === 'payment_mode') => $data['value_payment_mode'],
                                ($column === 'is_active') => $data['value_is_active'],
                                ($column === 'description') => $data['value_description'],
                            };

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
                    ->exporter(PaymentMethodExporter::class)
            ]);
    }
}
