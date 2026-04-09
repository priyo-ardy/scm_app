<?php

namespace App\Filament\Resources\ExchangeRates\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ExchangeRateForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->schema([
                        Select::make('currency_id')
                            ->label('Currency')
                            ->required()
                            ->relationship('currency', 'name')
                            ->native()
                            ->preload()
                            ->searchable()
                            ->columnSpan(3),
                        DatePicker::make('rate_date')
                            ->label('Effective Date')
                            ->required()
                            ->columnSpan(2),
                        TextInput::make('rates')
                            ->label('Rates')
                            ->numeric()
                            ->placeholder('Currency Rates')
                            ->columnSpan(3),
                        Textarea::make('note')
                            ->label('Remark')
                            ->placeholder('Additional information')
                            ->nullable()
                            ->columnSpan(4)
                    ])
                    ->columns(12)
                    ->columnSpanFull()
            ]);
    }
}
