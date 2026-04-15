<?php

namespace App\Filament\Resources\TimeZones\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TimeZoneForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->components([
                        TextInput::make('name')
                            ->label('Time Zone Name')
                            ->required()
                            ->placeholder('Enter time zone name')
                            ->maxLength(255)
                            ->columnSpan(3)
                            ->autocomplete(false)
                            ->live()
                            ->afterStateUpdated(function ($set, $state) {
                                $set('name', ucwords($state));
                            })
                            ->dehydrateStateUsing(fn ($state) => ucwords(strtolower($state))),
                        TextInput::make('offset')
                            ->label('Time Zone Offset')
                            ->required()
                            ->placeholder('Enter time zone offset eg: +08:00')
                            ->maxLength(255)
                            ->columnSpan(3)
                            ->autocomplete(false),
                        TextInput::make('description')
                            ->label('Time Zone Description')
                            ->placeholder('Enter time zone description')
                            ->maxLength(255)
                            ->columnSpan(4)
                            ->autocomplete(false),
                        Toggle::make('is_active')
                            ->label('Is Active')
                            ->default(true)
                            ->columnSpan(2),
                    ])->columns(12)
                    ->columnSpanFull(),
            ]);
    }
}
