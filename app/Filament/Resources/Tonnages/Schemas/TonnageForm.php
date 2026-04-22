<?php

namespace App\Filament\Resources\Tonnages\Schemas;

use Filament\Forms\Components\Select;
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
                        Select::make('company_id')
                            ->label('Company')
                            ->relationship('companyList', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->columnSpan(4),
                        TextInput::make('code')
                            ->label('Tonnage Code')
                            ->validationMessages([
                                'This tonnage code already registered',
                            ])
                            ->maxLength(20)
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->columnSpan(2)
                            ->placeholder('Tonnage Code')
                            ->validationMessages([
                                'required' => 'This field is required',
                                'unique' => 'This code already registered',
                            ])
                            ->autocomplete(false),
                        TextInput::make('name')
                            ->label('Tonnage Name')
                            ->maxLength(150)
                            ->placeholder('Tonnage name')
                            ->autocomplete(false)
                            ->required()
                            ->columnSpan(3),
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
                            ->columnSpan(10),
                    ])
                    ->columns(12)
                    ->columnSpanFull(),
            ]);
    }
}
