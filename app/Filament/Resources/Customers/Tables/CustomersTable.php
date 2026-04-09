<?php

namespace App\Filament\Resources\Customers\Tables;

use App\Filament\Exports\CustomerExporter;
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
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class CustomersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('email')
                    ->label('Email address')
                    ->searchable(),
                TextColumn::make('phone')
                    ->searchable(),
                TextColumn::make('fax')
                    ->searchable(),
                TextColumn::make('website')
                    ->searchable(),
                TextColumn::make('contact_person')
                    ->searchable(),
                TextColumn::make('contact_person_email')
                    ->searchable(),
                TextColumn::make('contact_person_phone')
                    ->searchable(),
                TextColumn::make('registration_no')
                    ->searchable(),
                TextColumn::make('tax_no')
                    ->searchable(),
                TextColumn::make('vat')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('bank_name')
                    ->searchable(),
                TextColumn::make('bank_account_no')
                    ->searchable(),
                TextColumn::make('bank_account_name')
                    ->searchable(),
                TextColumn::make('avatar')
                    ->searchable(),
                TextColumn::make('payment_method')
                    ->badge(),
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
                Filter::make('customer_filter')
                    ->columns(3)
                    ->schema([
                        TextInput::make('code')->label('Customer Code')->placeholder('Search with customer coode ...')->autocomplete(false),
                        TextInput::make('name')->label('Cutomer Name')->placeholder('Search with customer name ...')->autocomplete(false),
                        TextInput::make('email')->label('Email Address')->placeholder('Search with customer official email ...')->email()->autocomplete(false),
                        TextInput::make('phone')->label('Phone Number')->placeholder('Search with customer officila phone number')->tel()->autocomplete(false),
                        TextInput::make('fax')->label('Fax')->placeholder('Search with customer official fax number ...')->tel()->autocomplete(false),
                        TextInput::make('contact_person')->label('Contact Person')->placeholder('Contact person ...')->autocomplete(false),
                        TextInput::make('contact_person_email')->label('Contact Person Email')->email()->autocomplete(false),
                        TextInput::make('contact_person_phone')->label('Contact Person Phone No.')->tel()->autocomplete(false),
                        Select::make('payment_method')
                            ->label('Payment Term')
                            ->options([
                                'cash' => "Cash",
                                'bank' => 'Bank Transfer',
                                'cheque' => 'Cheque',
                                '30' => '30 days after delivery',
                                '60' => '60 days after delivery',
                                '90' => '90 days afted delivery'
                            ])
                            ->native(),
                        Grid::make(2)
                            ->schema([
                                DatePicker::make('created_from')
                                    ->label('Created From'),
                                DatePicker::make('created_until')
                                    ->label('Created Until')
                            ])->columnSpan(3)
                    ])->columns(3)
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['code'],
                                fn(Builder $query, $code): Builder => $query->where('code', 'like', "%$code%")
                            )
                            ->when(
                                $data['name'],
                                fn(Builder $query, $name): Builder => $query->where('code', 'like', "%$name%")
                            )
                            ->when(
                                $data['email'],
                                fn(Builder $query, $email): Builder => $query->where('code', 'like', "%$email%")
                            )
                            ->when(
                                $data['phone'],
                                fn(Builder $query, $phone): Builder => $query->where('code', 'like', "%$phone%")
                            )
                            ->when(
                                $data['fax'],
                                fn(Builder $query, $fax): Builder => $query->where('code', 'like', "%$fax%")
                            )
                            ->when(
                                $data['contact_person'],
                                fn(Builder $query, $contact_person): Builder => $query->where('code', 'like', "%$contact_person%")
                            )
                            ->when(
                                $data['contact_person_email'],
                                fn(Builder $query, $contact_person_email): Builder => $query->where('code', 'like', "%$contact_person_email%")
                            )
                            ->when(
                                $data['contact_person_phone'],
                                fn(Builder $query, $contact_person_phone): Builder => $query->where('code', 'like', "%$contact_person_phone%")
                            )
                            ->when(
                                $data['created_from'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];

                        if ($data['code'] ?? null) {
                            $indicators[] = 'Code: ' . $data['code'];
                        }

                        if ($data['name'] ?? null) {
                            $indicators[] = 'Name: ' . $data['name'];
                        }

                        if ($data['email'] ?? null) {
                            $indicators[] = 'Email: ' . $data['email'];
                        }

                        if ($data['phone'] ?? null) {
                            $indicators[] = 'Phone: ' . $data['phone'];
                        }

                        if ($data['fax'] ?? null) {
                            $indicators[] = 'Fax: ' . $data['fax'];
                        }

                        if ($data['contact_person'] ?? null) {
                            $indicators[] = 'Contact Person: ' . $data['contact_person'];
                        }

                        if ($data['contact_person_email'] ?? null) {
                            $indicators[] = 'Contact Person Email: ' . $data['contact_person_email'];
                        }

                        if ($data['contact_person_phone'] ?? null) {
                            $indicators[] = 'Contact Person Phone: ' . $data['contact_person_phone'];
                        }

                        return $indicators;
                    })
            ])
            ->filtersLayout(FiltersLayout::Modal)
            ->filtersFormWidth('4xl')
            ->filtersTriggerAction(
                fn($action) => $action
                    ->button()
                    ->label('Filter')
                    ->icon('heroicon-o-funnel')
            )
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make()
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
                    ->action(fn() => null),
                ExportAction::make()
                    ->exporter(CustomerExporter::class)
                    ->label('Export')
                    ->icon('heroicon-o-arrow-down-tray')
            ]);
    }
}
