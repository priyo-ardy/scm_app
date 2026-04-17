<?php

namespace App\Filament\Resources\Customers\Schemas;

use App\Models\Company;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CustomerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([
                Section::make()
                    ->components([
                        FileUpload::make('avatar')
                            ->hiddenLabel()
                            ->image()
                            ->imageEditor()
                            ->avatar()
                            ->alignCenter()
                            ->visibility('public')
                            ->directory('customer-avatar')
                            ->disk('public')
                            ->columnSpanFull()
                            ->imagePreviewHeight('350px')
                            ->removeUploadedFileButtonPosition('right')
                            ->saveRelationshipsUsing(null),
                        Select::make('company_id')
                            ->label('Company')
                            ->relationship('companyList', 'name')
                            ->searchable(['slug', 'name'])
                            ->preload()
                            ->required()
                            ->default(function () {
                                $sessionCompanyId = session('active_company');

                                // 2. Jika session tidak null, jadikan itu sebagai default
                                if ($sessionCompanyId) {
                                    return $sessionCompanyId;
                                }

                                // 3. Jika session null (Super Admin), ambil company default dari DB
                                return Company::where('is_default', 1)->first()?->id;
                            })
                            ->disabled(fn() => session('active_company') !== null)
                            ->dehydrated(true)
                            ->columnSpanFull()
                    ])->columnSpan(1),
                Section::make()
                    ->description('Basic Information')
                    ->components([
                        TextInput::make('code')
                            ->label('Customer Code')
                            ->placeholder('Automatically generated after saving')
                            ->readOnly(true)
                            ->dehydrated(false)
                            ->columnSpan(2),
                        TextInput::make('name')
                            ->label('Customer Name')
                            ->required()
                            ->live()
                            ->afterStateUpdated(fn($set, $state) => $set('name', strtoupper($state)))
                            ->maxLength(150)
                            ->autocomplete(false)
                            ->autofocus()
                            ->placeholder('Customer Name')
                            ->columnSpan(4)
                            ->dehydrateStateUsing(fn($state) => strtoupper(strtolower($state))),
                        Textarea::make('address')
                            ->label('Customer Address')
                            ->rows(1)
                            ->placeholder('Supplier Address')
                            ->columnSpan(6),
                        TextInput::make('email')
                            ->label('Email Address')
                            ->email()
                            ->maxLength(255)
                            ->placeholder('Official Email Address')
                            ->columnSpan(3),
                        TextInput::make('phone')
                            ->label('Phone Number')
                            ->tel()
                            ->maxLength(20)
                            ->placeholder('Official phone number')
                            ->columnSpan(3)
                            ->nullable()
                            ->regex('/^\+?[0-9]+$/')
                            ->validationMessages([
                                'regex' => 'The :attribute format must be numbers or start with +.',
                            ]),
                        TextInput::make('fax')
                            ->label('Fax Number')
                            ->maxLength(20)
                            ->placeholder('Fax Number')
                            ->columnSpan(3)
                            ->nullable()
                            ->regex('/^\+?[0-9]+$/')
                            ->validationMessages([
                                'regex' => 'The :attribute format must be numbers or start with +.',
                            ]),
                        TextInput::make('website')
                            ->label('Website')
                            ->maxLength(255)
                            ->placeholder('Website')
                            ->url()
                            ->columnSpan(3),
                        Textarea::make('remark')
                            ->label('Remark')
                            ->placeholder('Additional Information')
                            ->rows(3)
                            ->columnSpan(12),
                    ])
                    ->columns(12)
                    ->columnSpan(2)
                    ->collapsed(false),
                Section::make()
                    ->description('Contact Person Information')
                    ->components([
                        TextInput::make('contact_person')
                            ->label('Contact Person Name')
                            ->placeholder('Contact Person Name')
                            ->columnSpan(4),
                        TextInput::make('contact_person_email')
                            ->label('Contact Person Email')
                            ->placeholder('Contact Person Email')
                            ->email()
                            ->columnSpan(4),
                        TextInput::make('contact_person_phone')
                            ->label('Contact Person Phone')
                            ->placeholder('Contact Person Phone')
                            ->tel()
                            ->columnSpan(4)
                            ->nullable()
                            ->regex('/^\+?[0-9]+$/')
                            ->validationMessages([
                                'regex' => 'The :attribute format must be numbers or start with +.',
                            ]),
                    ])
                    ->columns(12)
                    ->columnSpanFull()
                    ->collapsed(false),
                Section::make()
                    ->schema([
                        Select::make('category')
                            ->label('Category')
                            ->options([
                                'local' => 'Domestic',
                                'overseas' => 'Overseas'
                            ])
                            ->required()
                            ->columnSpan(3)
                            ->searchable(),
                        Select::make('currency_id')
                            ->label('Default Currency')
                            ->required()
                            ->relationship('currencyList', 'code')
                            ->searchable(['code', 'name'])
                            ->preload()
                            ->getOptionLabelFromRecordUsing(fn($record) => "{$record->code} - {$record->name} ({$record->symbol})")
                            ->columnSpan(3),
                        Select::make('payment_term_id')
                            ->label('Payment Method')
                            ->relationship('paymentList', 'name')
                            ->placeholder('Payment Method')
                            ->preload()
                            ->searchable()
                            ->columnSpan(4)
                            ->required(),
                    ])
                    ->columns(12)
                    ->columnSpanFull(),
                Section::make()
                    ->description('Bank, Tax and Payment Information')
                    ->components([
                        TextInput::make('registration_no')
                            ->label('Company Registration No.')
                            ->placeholder('Company Registration No.')
                            ->maxLength(50)
                            ->columnSpan(3),
                        TextInput::make('tax_no')
                            ->label('Tax Registration No.')
                            ->placeholder('Tax Registration No.')
                            ->maxLength(50)
                            ->columnSpan(3)
                            ->nullable()
                            ->numeric(),
                        TextInput::make('vat')
                            ->label('VAT (%)')
                            ->placeholder('VAT (%)')
                            ->maxLength(10)
                            ->columnSpan(3)
                            ->nullable()
                            ->numeric()
                            ->default(11),
                        TextInput::make('bank_name')
                            ->label('Bank Name')
                            ->placeholder('Bank Name')
                            ->maxLength(255)
                            ->columnSpan(3),
                        TextInput::make('bank_account_no')
                            ->label('Bank Account No')
                            ->placeholder('Bank Account No')
                            ->maxLength(255)
                            ->columnSpan(3)
                            ->nullable()
                            ->numeric(),
                        TextInput::make('bank_account_name')
                            ->label('Bank Account Name')
                            ->placeholder('Bank Account Name')
                            ->maxLength(255)
                            ->columnSpan(3),
                    ])
                    ->columns(12)
                    ->collapsed(false)
                    ->columnSpanFull(),
            ]);
    }
}
