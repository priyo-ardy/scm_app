<?php

namespace App\Filament\Resources\EquipmentCategories\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class EquipmentCategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->schema([
                        TextInput::make('code')
                            ->label('Code')
                            ->readOnly()
                            ->placeholder('Automatically generate after save')
                            ->columnSpan(3),
                        TextInput::make('name')
                            ->label('Name')
                            ->placeholder('Equipment category name')
                            ->maxLength(150)
                            ->autofocus()
                            ->autocomplete(false)
                            ->columnSpan(4),
                        TextInput::make('prefix')
                            ->label('Prefix')
                            ->maxLength(10)
                            ->unique(ignoreRecord: false)
                            ->autocomplete(false)
                            ->validationMessages([
                                'This prefix already registered'
                            ])
                            ->placeholder('Prefix for this category')
                            ->columnSpan(3),
                        Textarea::make('description')
                            ->label('Remark')
                            ->placeholder('Add additional information here')
                            ->rows(3)
                            ->columnSpanFull()
                    ])
                    ->columns(12)
                    ->columnSpanFull()
            ]);
    }
}
