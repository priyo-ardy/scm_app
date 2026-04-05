<?php

namespace App\Filament\Resources\Companies\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class CompanyForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('code')
                    ->required(),
                TextInput::make('name')
                    ->required(),
                TextInput::make('legal_name')
                    ->default(null),
                TextInput::make('slug')
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->default(null),
                TextInput::make('phone')
                    ->tel()
                    ->default(null),
                TextInput::make('fax')
                    ->default(null),
                TextInput::make('website')
                    ->url()
                    ->default(null),
                Textarea::make('address')
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('postal_code')
                    ->default(null),
                TextInput::make('tax_id')
                    ->default(null),
                TextInput::make('tax_address')
                    ->default(null),
                Toggle::make('is_pkp')
                    ->required(),
                TextInput::make('bank_name')
                    ->default(null),
                TextInput::make('bank_account')
                    ->default(null),
                TextInput::make('bank_beneficiary')
                    ->default(null),
                TextInput::make('logo')
                    ->default(null),
                TextInput::make('favicon')
                    ->default(null),
                TextInput::make('currency_id')
                    ->numeric()
                    ->default(null),
                TextInput::make('timezone_id')
                    ->numeric()
                    ->default(null),
            ]);
    }
}
