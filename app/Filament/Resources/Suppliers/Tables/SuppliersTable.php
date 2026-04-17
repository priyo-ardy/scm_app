<?php

namespace App\Filament\Resources\Suppliers\Tables;

use App\Filament\Exports\SupplierExporter;
use App\Models\Currency;
use App\Models\PaymentTerm;
use Filament\Actions\Action;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ExportAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\QueryBuilder\Constraints\BooleanConstraint;
use Filament\QueryBuilder\Constraints\NumberConstraint;
use Filament\QueryBuilder\Constraints\SelectConstraint;
use Filament\QueryBuilder\Constraints\TextConstraint;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Actions\Action as TableAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\QueryBuilder;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class SuppliersTable
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
                    ->label('Company'),
                TextColumn::make('code')
                    ->label('Supplier Code')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('name')
                    ->label('Supplier Name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('address')
                    ->label('Address')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->label('Email Address')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('phone')
                    ->label('Phone No.')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('fax')
                    ->label('Fax No.')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('website')
                    ->label('Website')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('contact_person')
                    ->label('Contact Person Name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('contact_person_email')
                    ->label('Contact Person Email')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('contact_person_phone')
                    ->label('Contact Person Phone')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('registration_no')
                    ->label('Company Registratoon No')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('tax_no')
                    ->label('Tax Registration No.')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('vat')
                    ->label('VAT (%)')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('bank_name')
                    ->label('Bank Name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('bank_account_no')
                    ->label('Bank Account No')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('bank_account_name')
                    ->label('Bank Account Name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('paymentList.name')
                    ->label('Payment Method')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('is_active')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn($state) => $state ? 'Enable' : 'Disable')
                    ->color(fn(bool $state): string => $state ? 'success' : 'gray'),
                TextColumn::make('category')
                    ->label('Supplier Category')
                    ->searchable()
                    ->formatStateUsing(fn(string $state): string => ($state = 'local') ? 'Domestic' : 'Overseas'),
                TextColumn::make('currencyList.code')
                    ->label('Default Currency')
                    ->searchable(['code', 'name', 'symbol']),
                TextColumn::make('remark')
                    ->label('Remark'),
            ])
            ->filters([
                QueryBuilder::make()
                    ->constraints([
                        TextConstraint::make('code')->label('Code'),
                        TextConstraint::make('nake')->label('Name'),
                        TextConstraint::make('address')->label('Address'),
                        TextConstraint::make('email')->label('Email Address'),
                        TextConstraint::make('phone')->label('Phone Number'),
                        TextConstraint::make('fax')->label('Fax'),
                        TextConstraint::make('website')->label('Website'),
                        TextConstraint::make('contact_person')->label('Contact Person'),
                        TextConstraint::make('contact_person_email')->label('Contact Person Email'),
                        TextConstraint::make('contact_person_phone')->label('Contact Person Phone'),
                        TextConstraint::make('registration_no')->label('Company Registration No.'),
                        TextConstraint::make('tax_no')->label('Tax Registration No.'),
                        TextConstraint::make('bank_name')->label('Bank Name'),
                        TextConstraint::make('bank_account_no')->label('Bank Account No.'),
                        TextConstraint::make('bank_account_name')->label('Bank Account Name'),
                        TextConstraint::make('remark')->label('Remark'),
                        NumberConstraint::make('vat')->label('VAT %'),
                        SelectConstraint::make('payment_terms_id')
                            ->label('Payment Terms')
                            ->options(PaymentTerm::pluck('name', 'id'))
                            ->searchable(),
                        SelectConstraint::make('category')
                            ->label('Category')
                            ->options([
                                'local' => 'Domestic',
                                'export' => 'Overseas'
                            ]),
                        SelectConstraint::make('default_currency ')
                            ->label('Default Currency')
                            ->options(Currency::pluck('code', 'id')),
                        BooleanConstraint::make('is_active')
                            ->label('Status'),
                    ])->constraintPickerColumns(3)
            ], layout: FiltersLayout::Modal)
            ->filtersFormWidth('4xl')
            ->filtersTriggerAction(
                fn($action) => $action
                    ->button()
                    ->label('Filter')
                    ->icon(Heroicon::OutlinedFunnel),
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
                                            'is_active' => 'Disable Status',
                                            'category' => 'Category',
                                            'default_currency' => 'Default Currency'
                                        ])->columnSpan(1),

                                    Select::make('value_is_active')
                                        ->options(['0' => 'Disable', '1' => 'Enable'])
                                        ->visible(fn(Get $get) => $get('column_to_update') === 'is_active')
                                        ->required()
                                        ->columnSpan(2),
                                    Select::make('value_category')
                                        ->options(['local' => 'Domestic', 'export' => 'Overseas'])
                                        ->visible(fn(Get $get) => $get('column_to_update') === 'category')
                                        ->required()
                                        ->columnSpan(2),
                                    Select::make('value_default_currency')
                                        ->relationship('currencyList', 'code')
                                        ->visible()
                                        ->searchable()
                                        ->visible(fn(Get $get) => $get('column_to_update') === 'default_currency')
                                        ->preload()
                                        ->required()
                                        ->columnSpan(2)
                                ])
                        ])
                        ->action(function (Collection $records, array $data): void {
                            $column = $data['column_to_update'];

                            $newValue = match (true) {
                                ($column === 'is_active') => $data['value_is_active'],
                                ($column === 'category') => $data['value_category'],
                                ($column === 'default_currency') => $data['value_default_currency'],
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
                    ->icon('heroicon-o-arrow-path')
                    ->action(fn() => null),
                ExportAction::make()
                    ->label('Export')
                    ->exporter(SupplierExporter::class)
                    ->icon('heroicon-o-arrow-down-tray'),
            ]);
    }
}
