<?php

namespace App\Filament\Resources\Workshops\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class WorkshopForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->schema([
                        TextInput::make('code')
                            ->label('Workshop Code')
                            ->readOnly()
                            ->placeholder('Automatically generate after save')
                            ->columnSpan(2),
                        TextInput::make('name')
                            ->label('Workshop Name')
                            ->maxLength(150)
                            ->placeholder('Workshop name')
                            ->autofocus()
                            ->autocomplete(false)
                            ->required()
                            ->live()
                            ->afterStateUpdated(fn ($set, $state) => $set('name', ucwords($state)))
                            ->dehydrateStateUsing(fn ($state) => ucwords(strtolower($state)))
                            ->columnSpan(4),
                        Select::make('branch_id')
                            ->label('Branch')
                            ->required()
                            ->relationship('branch', 'name')
                            ->native()
                            ->preload()
                            ->searchable()
                            ->columnSpan(3),
                        Textarea::make('location_detail')
                            ->label('Location Details')
                            ->placeholder('Please specify which floor or which building.')
                            ->nullable()
                            ->rows(2)
                            ->columnSpan(3),
                        Select::make('pic_id')
                            ->label('Workshop PIC')
                            ->required()
                            ->relationship('user', 'name')
                            ->native()
                            ->preload()
                            ->searchable()
                            ->columnSpan(3),
                        TextInput::make('phone')
                            ->label('Workshop Phone Ext.')
                            ->tel()
                            ->nullable()
                            ->placeholder('Fill if the workshop has an extension no.')
                            ->columnSpan(3),
                        Textarea::make('remarks')
                            ->label('Additional Information')
                            ->rows(2)
                            ->columnSpan(6)
                            ->placeholder('Describe additional information here')
                            ->nullable(),
                    ])
                    ->columns(12)
                    ->columnSpanFull(),
            ]);
    }
}
