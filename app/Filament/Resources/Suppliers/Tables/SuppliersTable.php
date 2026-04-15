<?php

namespace App\Filament\Resources\Suppliers\Tables;

use App\Filament\Exports\SupplierExporter;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ExportAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Actions\Action as TableAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

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
                TextColumn::make('payment_method')
                    ->label('Payment Method')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'cash' => 'Cash',
                        'bank' => 'Bank Transfer',
                        'cheque' => 'Cheque',
                        '30' => '30 Days after delivery',
                        '60' => '60 Days after delivery',
                        '90' => '90 Days after delivery',
                    })
                    ->searchable()
                    ->sortable(),
                TextColumn::make('remark')
                    ->label('Remark'),
            ])
            ->filters([
                TrashedFilter::make(),
                Filter::make('created_at')
                    ->form([
                        DatePicker::make('created_from'),
                        DatePicker::make('created_until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    }),
            ])
            ->filtersFormColumns(2)
            // ->filtersTriggerAction(
            //     fn(TableAction $action) => $action
            //         ->button()
            //         ->label('Filter'),
            // )
            ->persistFiltersInSession()
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
                Action::make('refresh')
                    ->label('Refresh')
                    ->icon('heroicon-o-arrow-path')
                    ->action(fn () => null),
                ExportAction::make()
                    ->exporter(SupplierExporter::class)
                    ->icon('heroicon-o-arrow-down-tray'),
            ]);
    }
}
