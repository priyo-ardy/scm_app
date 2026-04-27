<?php

namespace App\Filament\Resources\PurchasePriceHeaders\Schemas;

use App\Filament\Resources\PurchasePriceHeaders\Pages\EditPurchasePriceHeader;
use App\Models\Company;
use App\Models\PurchasePriceHeader;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;

class PurchasePriceHeaderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->schema([
                        Select::make('company_id')
                            ->label('Company')
                            ->relationship('companyList', 'name')
                            ->searchable()
                            ->preload()
                            ->native(false)
                            ->required()
                            ->default(function () {
                                $sessionCompanyId = session('active_company');

                                if ($sessionCompanyId) {
                                    return $sessionCompanyId;
                                }

                                return Company::where('is_default', 1)->first()?->id;
                            })
                            ->disabled(function ($context, $livewire) {
                                if (session('active_company') !== null) {
                                    return true;
                                }

                                if ($context === 'edit' && $livewire instanceof EditPurchasePriceHeader) {
                                    return !$livewire->isEditingEnabled;
                                }
                            })
                            ->dehydrated(true)
                            ->columnSpan(3),
                        TextInput::make('code')
                            ->label('Code')
                            ->placeholder('Automatic generate after save')
                            ->readOnly()
                            ->columnSpan(2),
                        TextInput::make('name')
                            ->label('Name')
                            ->maxLength(150)
                            ->placeholder('Purchase price name')
                            ->required()
                            ->columnSpan(3)
                            ->autocomplete(false)
                            ->autofocus()
                            ->disabled(function ($livewire) {
                                if ($livewire instanceof EditPurchasePriceHeader) {
                                    return !$livewire->isEditingEnabled;
                                }
                                return false;
                            }),
                        Select::make('supplier_id')
                            ->label('Supplier')
                            ->relationship('supplierList', 'name')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->live() // 1. Aktifkan mode real-time
                            ->afterStateUpdated(function ($state, Set $set, ?PurchasePriceHeader $record) {
                                if (! $state) return;

                                $exists = PurchasePriceHeader::where('supplier_id', $state)
                                    ->when($record, function ($query) use ($record) {
                                        return $query->where('id', '!=', $record->id);
                                    })
                                    ->exists();

                                if ($exists) {

                                    Notification::make()
                                        ->title('Supplier Already Registered!')
                                        ->body('Sorry, price data for this supplier has already been entered.')
                                        ->danger()
                                        ->duration(5000) // Popup tampil selama 5 detik
                                        ->send();

                                    $set('supplier_id', null);
                                }
                            })
                            ->unique(ignoreRecord: true)
                            ->validationMessages([
                                'unique' => 'This supplier already registered to purchase price data, please find the data then edit'
                            ])
                            ->native(false)
                            ->columnSpan(4)
                            ->disabled(function ($livewire) {
                                if ($livewire instanceof EditPurchasePriceHeader) {
                                    return !$livewire->isEditingEnabled;
                                }
                                return false;
                            }),
                        Select::make('currency_id')
                            ->label('Currency')
                            ->relationship('currencyList', 'code')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->native(false)
                            ->columnSpan(2)
                            ->disabled(function ($livewire) {
                                if ($livewire instanceof EditPurchasePriceHeader) {
                                    return !$livewire->isEditingEnabled;
                                }
                                return false;
                            }),
                        Textarea::make('remark')
                            ->label('Remark')
                            ->placeholder('Write additional information here ...')
                            ->columnSpan(10)
                            ->disabled(function ($livewire) {
                                if ($livewire instanceof EditPurchasePriceHeader) {
                                    return !$livewire->isEditingEnabled;
                                }
                                return false;
                            })
                    ])
                    ->columns(12)
                    ->columnSpanFull()
            ]);
    }
}
