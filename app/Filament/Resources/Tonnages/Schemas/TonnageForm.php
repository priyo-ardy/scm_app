<?php

namespace App\Filament\Resources\Tonnages\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TonnageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->schema([
                        TextInput::make('code')
                            ->label('Tonnage Code')
                            ->unique(ignoreRecord: false)
                            ->validationMessages([
                                'This tonnage code already registered',
                            ])
                            ->maxLength(20)
                            ->required()
                            ->columnSpan(2)
                            ->placeholder('Tonnage Code')
                            ->autocomplete(false)
                            ->autofocus(),
                        TextInput::make('name')
                            ->label('Tonnage Name')
                            ->maxLength(150)
                            ->placeholder('Tonnage name')
                            ->autocomplete(false)
                            ->required()
                            ->columnSpan(5),
                        TextInput::make('clamping_force_kn')
                            ->label('Clamping Force KN')
                            ->placeholder('Clamping Force KN')
                            ->numeric()
                            ->columnSpan(3)
                            ->default(null),
                        TextInput::make('std_dbugging')
                            ->label('Standart Debugging')
                            ->numeric()
                            ->required()
                            ->placeholder('Std Debugging')
                            ->columnSpan(2),
                        Textarea::make('remark')
                            ->default(null)
                            ->placeholder('Add additional information here')
                            ->columnSpanFull(),
                    ])
                    ->columns(12)
                    ->columnSpanFull(),
            ]);
    }
}
