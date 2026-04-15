<?php

namespace App\Filament\Resources\Units\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class UnitsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->schema([
                        Select::make('category')
                            ->label('Unit Category')
                            ->required()
                            ->options([
                                'length' => 'Length',
                                'mass' => 'Mass',
                                'volume' => 'Volume',
                                'other' => 'Others',
                            ])
                            ->searchable()
                            ->native()
                            ->preload()
                            ->columnSpan(3),
                        TextInput::make('code')
                            ->label('Unit Code/Symbol')
                            ->required()
                            ->maxLength(10)
                            ->placeholder('Unit Code/Symbol')
                            ->unique(ignoreRecord: false)
                            ->autofocus()
                            ->autocomplete(false)
                            ->validationMessages([
                                'This unit code already registered',
                            ])->columnSpan(2),
                        TextInput::make('name')
                            ->label('Unit Name')
                            ->required()
                            ->maxLength(150)
                            ->placeholder('Unit Name')
                            ->autocomplete(false)
                            ->columnSpan(4),
                        Select::make('base_unit_id')
                            ->label('Base Unit')
                            ->required()
                            ->relationship('baseUnit', 'name')
                            ->nullable()
                            ->native()
                            ->preload()
                            ->searchable()
                            ->columnSpan(3),
                        TextInput::make('conversion_factor')
                            ->label('Conversion')
                            ->required()
                            ->numeric()
                            ->placeholder('Unit Conversion Rate')
                            ->columnSpan(2),
                    ])
                    ->columns(12)
                    ->columnSpanFull(),
            ]);
    }
}
