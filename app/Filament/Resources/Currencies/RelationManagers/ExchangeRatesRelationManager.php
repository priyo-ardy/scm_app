<?php

namespace App\Filament\Resources\Currencies\RelationManagers;

use App\Filament\Resources\ExchangeRates\ExchangeRateResource;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ExchangeRatesRelationManager extends RelationManager
{
    protected static string $relationship = 'ExchangeRates';

    protected static ?string $relatedResource = ExchangeRateResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('rate_date')
            ->columns([
                TextColumn::make('rate_date')
                    ->label('Effective Date')
                    ->date('d M Y')
                    ->sortable(),
                TextColumn::make('rates')
                    ->numeric(2)
                    ->sortable()
                    ->alignRight(),
                TextColumn::make('note')
                    ->label('Additional Information')
                    ->sortable(),
                TextColumn::make('user.name')
                    ->label('Editor')
                    ->alignCenter(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->toggleable(isToggledHiddenByDefault: true),
            ]);
    }
}
