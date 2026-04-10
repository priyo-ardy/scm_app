<?php

namespace App\Filament\Resources\Equipments\Schemas;

use App\Models\Equipment;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class EquipmentsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->schema([
                        Select::make('category_id')
                            ->label('Equipment Category')
                            ->relationship('category', 'name')
                            ->native(false)
                            ->preload()
                            ->required()
                            ->searchable()
                            ->live()
                            ->afterStateUpdated(function ($state, $set) {
                                if ($state) {
                                    $code = Equipment::generateCurrentCode($state);
                                    $set('code', $code);
                                } else {
                                    $set('code', null);
                                }
                            })
                            ->columnSpan(3),
                        TextInput::make('code')
                            ->label('Code')
                            ->readOnly()
                            ->placeholder('Automatically generate after save')
                            ->helperText('Code guidance')
                            ->dehydrated()
                            ->columnSpan(2)
                    ])
                    ->columns(12)
                    ->columnSpanFull()
            ]);
    }
}
