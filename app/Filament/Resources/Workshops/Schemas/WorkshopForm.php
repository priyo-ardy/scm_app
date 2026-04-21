<?php

namespace App\Filament\Resources\Workshops\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;

class WorkshopForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->schema([
                        Select::make('company_id')
                            ->label('Company')
                            ->relationship('company', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->live()
                            ->autofocus()
                            ->afterStateUpdated(fn(Set $set) => $set('branch_id', null))
                            ->columnSpan(3),
                        Select::make('branch_id')
                            ->label('Branch')
                            ->required()
                            ->relationship('branch', 'name', modifyQueryUsing: fn(Builder $query, Get $get) => $query->where('company_id', $get('company_id')))
                            ->native(false)
                            ->preload()
                            ->searchable()
                            ->columnSpan(3),
                        TextInput::make('code')
                            ->label('Workshop Code')
                            ->readOnly()
                            ->placeholder('Automatically generate after save')
                            ->columnSpan(2),
                        TextInput::make('name')
                            ->label('Workshop Name')
                            ->maxLength(150)
                            ->placeholder('Workshop name')
                            ->autocomplete(false)
                            ->required()
                            ->columnSpan(4),
                        Textarea::make('location_detail')
                            ->label('Location Details')
                            ->placeholder('Please specify which floor or which building.')
                            ->nullable()
                            ->rows(2)
                            ->columnSpan(6),
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
                            ->columnSpanFull()
                            ->placeholder('Describe additional information here')
                            ->nullable(),
                    ])
                    ->columns(12)
                    ->columnSpanFull(),
            ]);
    }
}
