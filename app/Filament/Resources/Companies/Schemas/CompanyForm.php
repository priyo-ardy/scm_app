<?php

namespace App\Filament\Resources\Companies\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CompanyForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([
                Section::make()
                    ->columns(2)
                    ->schema([
                        Section::make()
                            ->description('Company Logo')
                            ->schema([
                                FileUpload::make('logo')
                                    ->hiddenLabel()
                                    ->image()
                                    ->imageEditor()
                                    ->avatar()
                                    ->alignCenter()
                                    ->visibility('public')
                                    ->directory('company-avatar')
                                    ->disk('public')
                                    ->columnSpanFull()
                                    ->imagePreviewHeight('350px')
                                    ->removeUploadedFileButtonPosition('right')
                                    ->saveRelationshipsUsing(null),
                            ])->columnSpanFull(),
                        Section::make()
                            ->description('Company Favicon')
                            ->schema([
                                FileUpload::make('favicon')
                                    ->hiddenLabel()
                                    ->image()
                                    ->imageEditor()
                                    ->avatar()
                                    ->alignCenter()
                                    ->visibility('public')
                                    ->directory('favicon-avatar')
                                    ->disk('public')
                                    ->columnSpanFull()
                                    ->imagePreviewHeight('350px')
                                    ->removeUploadedFileButtonPosition('right')
                                    ->saveRelationshipsUsing(null),
                            ])->columnSpanFull(),
                    ])->columnSpan(1),
                Section::make()
                    ->schema([
                        TextInput::make('code')
                            ->readOnly()
                            ->maxLength(10)
                            ->autocomplete(false)
                            ->placeholder('Auto generated after save')
                            ->columnSpan(3),
                        TextInput::make('name')
                            ->required()
                            ->autofocus()
                            ->maxLength(255)
                            ->autocomplete(false)
                            ->placeholder('Company Name')
                            ->columnSpan(7),
                        TextInput::make('slug')
                            ->maxLength(255)
                            ->autocomplete(false)
                            ->placeholder('Company Slug')
                            ->required()
                            ->columnSpan(2),
                        TextInput::make('legal_name')
                            ->label('Company Legal Name')
                            ->required()
                            ->maxLength(255)
                            ->autocomplete(false)
                            ->placeholder('Company Legal Name')
                            ->columnSpan(8),
                        TextInput::make('email')
                            ->label('Company Email')
                            ->required()
                            ->email()
                            ->maxLength(255)
                            ->autocomplete(false)
                            ->placeholder('Company Email')
                            ->columnSpan(4),
                        TextInput::make('phone')
                            ->label('Company Phone')
                            ->required()
                            ->tel()
                            ->maxLength(20)
                            ->autocomplete(false)
                            ->placeholder('Company Phone')
                            ->columnSpan(4),
                        TextInput::make('fax')
                            ->label('Company Fax')
                            ->tel()
                            ->maxLength(20)
                            ->autocomplete(false)
                            ->placeholder('Company Fax')
                            ->columnSpan(4),
                        TextInput::make('website')
                            ->label('Company Website')
                            ->url()
                            ->maxLength(255)
                            ->autocomplete(false)
                            ->placeholder('Company Website')
                            ->columnSpan(4),
                        Textarea::make('address')
                            ->label('Company Address')
                            ->required()
                            ->columnSpan(12)
                            ->placeholder('Company Address'),
                        TextInput::make('postal_code')
                            ->label('Postal Code')
                            ->columnSpan(3)
                            ->placeholder('Postal Code'),
                        TextInput::make('tax_id')
                            ->label('Tax ID')
                            ->columnSpan(4)
                            ->placeholder('Tax ID')
                            ->maxLength(20)
                            ->numeric(),
                        Textarea::make('tax_address')
                            ->label('Tax Address')
                            ->columnSpan(5)
                            ->placeholder('Tax Address'),
                        Select::make('is_pkp')
                            ->label('PKP Status')
                            ->options([
                                0 => 'Non PKP',
                                1 => 'PKP',
                            ])
                            ->default(1)
                            ->columnSpan(4)
                            ->searchable(),
                        TextInput::make('bank_name')
                            ->label('Bank Name')
                            ->columnSpan(4)
                            ->placeholder('Bank Name'),
                        TextInput::make('bank_account')
                            ->label('Bank Account No')
                            ->columnSpan(4)
                            ->numeric()
                            ->placeholder('Bank Name'),
                        TextInput::make('bank_beneficiary')
                            ->label('Bank Beneficiary')
                            ->columnSpan(4)
                            ->placeholder('Bank Beneficiary')
                            ->maxLength(255),
                        Select::make('currency_id')
                            ->label('Currency')
                            ->columnSpan(3)
                            ->searchable()
                            ->preload()
                            ->relationship('currency', 'code'),
                        Select::make('timezone_id')
                            ->label('Timezone')
                            ->columnSpan(5)
                            ->searchable()
                            ->preload()
                            ->relationship('timezone', 'name')
                            ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->name} ({$record->offset})"),
                    ])
                    ->columns(12)
                    ->columnSpan(2),
            ]);
    }
}
