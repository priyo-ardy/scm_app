<?php

namespace App\Filament\Resources\Customers\Tables;

use App\Filament\Exports\CustomerExporter;
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
use Filament\QueryBuilder\Constraints\BooleanConstraint;
use Filament\QueryBuilder\Constraints\NumberConstraint;
use Filament\QueryBuilder\Constraints\SelectConstraint;
use Filament\QueryBuilder\Constraints\TextConstraint;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\QueryBuilder;
use Filament\Tables\Table;
use Illuminate\Support\Collection;

class CustomersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('avatar')
                    ->circular()
                    ->disk('public')
                    ->visibility('public'),
                TextColumn::make('companyList.slug')
                    ->label('Company')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('code')
                    ->label('Supplier Code')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('category')
                    ->label('Category')
                    ->formatStateUsing(fn(string $state): string => ($state == 'local') ? 'Domestic' : 'Overseas')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('short_name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->label('Email address')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('phone')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('fax')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('website')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('contact_person')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('contact_person_email')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('contact_person_phone')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('registration_no')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('tax_no')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('vat')
                    ->numeric()
                    ->searchable()
                    ->sortable(),
                TextColumn::make('bank_name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('bank_account_no')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('bank_account_name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('avatar')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('paymentList.name')
                    ->label('Payment Terms')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('currencyList.code')
                    ->label('Default Currency')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('paymentMethodList.name')
                    ->label('Payment Method')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('is_active')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn(bool $state): string => $state ? 'Active' : 'Not Active')
                    ->color(fn(bool $state): string => $state ? 'success' : 'danger')
                    ->alignCenter()
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
            ])
            ->filters([
                QueryBuilder::make()
                    ->constraints([
                        SelectConstraint::make('company_id')
                            ->label('Company')
                            ->relationship('companyList', 'name')
                            ->searchable(),
                        SelectConstraint::make('category')
                            ->label('Category')
                            ->options([
                                'local' => 'Domestic',
                                'overseas' => 'Overseas'
                            ])
                            ->searchable(),
                        BooleanConstraint::make('is_active')->label('Status'),
                        TextConstraint::make('code')->label('Code'),
                        TextConstraint::make('name')->label('Name'),
                        NumberConstraint::make('vat')->label('VAT'),
                        SelectConstraint::make('payment_term_id')
                            ->label('Payment Terms')
                            ->relationship('paymentList', 'name')
                            ->searchable(),
                        SelectConstraint::make('currency_id')
                            ->label('Default Currency')
                            ->relationship('currencyList', 'code')
                            ->searchable()
                    ])
                    ->constraintPickerColumns(3)
            ], layout: FiltersLayout::Modal)
            ->filtersFormWidth('4xl')
            ->filtersTriggerAction(
                fn($action) => $action
                    ->button()
                    ->label('Filter')
                    ->icon('heroicon-o-funnel')
            )
            ->persistFiltersInSession()
            ->recordActions([])
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
                                            'is_active' => 'Status',
                                            'vat' => 'VAT',
                                            'payment_term_id' => 'Payment Terms',
                                            'currency_id' => 'Default Currency'
                                        ])
                                        ->columnSpan(1),
                                    Select::make('value_is_active')
                                        ->options([
                                            '0' => 'Disable',
                                            '1' => 'Enable'
                                        ])
                                        ->required()
                                        ->columnSpan(2)
                                        ->visible(fn(Get $get) => $get('column_to_update' === 'is_active')),
                                    TextInput::make('value_vat')
                                        ->numeric()
                                        ->required()
                                        ->columnSpan(2)
                                        ->visible(fn(Get $get) => $get('column_to_update' === 'vat')),
                                    Select::make('value_payment_term')
                                        ->relationship('paymentList', 'name')
                                        ->searchable()
                                        ->preload()
                                        ->columnSpan(2)
                                        ->visible(fn(Get $get) => $get('column_to_update' === 'payment_term_id')),
                                    Select::make('value_currency_id')
                                        ->relationship('currencyList', 'code')
                                        ->searchable()
                                        ->preload()
                                        ->columnSpan(2)
                                        ->visible(fn(Get $get) => $get('column_to_update' === 'currency_id')),
                                ])
                        ])
                        ->action(function (Collection $records, array $data): void {
                            $column = $data['column_to_update'];

                            $newValue = match (true) {
                                ($column === 'is_active') => $data['value_is_active'],
                                ($column === 'vat') => $data['value_vat'],
                                ($column === 'value_payment_term') => $data['value_payment_term'],
                                ($column === 'value_currency_id') => $data['value_currency_id'],
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
                    ->icon('heroicon-o-arrow-path')
                    ->action(fn() => null),
                ExportAction::make()
                    ->exporter(CustomerExporter::class)
                    ->label('Export')
                    ->icon('heroicon-o-arrow-down-tray'),
            ]);
    }
}
