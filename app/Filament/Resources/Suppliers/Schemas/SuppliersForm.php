<?php

namespace App\Filament\Resources\Suppliers\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SuppliersForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->schema([
                Section::make()
                    ->description('Supplier Logo')
                    ->schema([
                        FileUpload::make('avatar')
                            ->hiddenLabel()
                            ->image()
                            ->imageEditor()
                            ->avatar()
                            ->alignCenter()
                            ->visibility('public')
                            ->directory('supplier-avatar')
                            ->disk('public')
                            ->columnSpanFull()
                            ->imagePreviewHeight('350px')
                            ->removeUploadedFileButtonPosition('right')
                            ->saveRelationshipsUsing(null),
                    ])->columnSpan(1),
                Section::make()
                    ->description('Base Information')
                    ->schema([
                        TextInput::make('code')
                            ->label('Supplier Code')
                            ->placeholder('Automatically generated after saving')
                            ->readOnly(true)
                            ->dehydrated(false)
                            ->columnSpan(2),
                        TextInput::make('name')
                            ->label('Supplier Name')
                            ->live()
                            ->afterStateUpdated(fn($set, $state) => $set('name', ucwords($state)))
                            ->required()
                            ->maxLength(150)
                            ->autocomplete(false)
                            ->autofocus()
                            ->placeholder('Supplier Name')
                            ->columnSpan(4)
                            ->dehydrateStateUsing(fn($state) => ucwords(strtolower($state))),
                        Textarea::make('address')
                            ->label('Supplier Address')
                            ->rows(1)
                            ->placeholder('Supplier Address')
                            ->columnSpan(6),
                        TextInput::make('email')
                            ->label('Email Address')
                            ->maxLength(255)
                            ->placeholder('Email Address')
                            ->email()
                            ->columnSpan(3),
                        TextInput::make('phone')
                            ->label('Phone Number')
                            ->tel()
                            ->maxLength(20)
                            ->placeholder('Phone Number')
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
                    ->description('Contact Information')
                    ->schema([
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
                    ->collapsed(false)
                    ->columnSpanFull(),
                Section::make()
                    ->description('Bank, Tax and Payment Information')
                    ->schema([
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
                            ->numeric(),
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
                        Select::make('payment_method')
                            ->label('Payment Method')
                            ->options([
                                'cash' => 'Cash',
                                'bank' => 'Bank Trasfer',
                                'cheque' => 'Cheque',
                                'advance' => 'Advance Payment',
                                '30' => '30 Days After Delivery',
                                '45' => '45 Days After Deivery',
                                '60' => '60 Days After Delivery',
                                '90' => '90 Days After Delivery',
                            ])
                            ->placeholder('Payment Method')
                            ->searchable()
                            ->columnSpan(3),
                    ])
                    ->columns(12)
                    ->collapsed(false)
                    ->columnSpanFull(),
            ]);
    }
}
