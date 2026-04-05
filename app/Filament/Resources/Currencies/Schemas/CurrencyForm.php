<?php

namespace App\Filament\Resources\Currencies\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class CurrencyForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('code')
                    ->required(),
                TextInput::make('name')
                    ->required(),
                TextInput::make('symbol')
                    ->required(),
                TextInput::make('decimal_digits')
                    ->required()
                    ->numeric()
                    ->default(2),
                Toggle::make('is_active')
                    ->required(),
            ]);
    }
}
