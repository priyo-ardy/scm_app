<?php

namespace App\Filament\Resources\SetllementCategories\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SetllementCategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->schema([
                        TextInput::make('code')
                            ->label('Code')
                            ->placeholder('Automatic generate after save')
                            ->readOnly()
                            ->columnSpan(2),
                        TextInput::make('name')
                            ->label('Name')
                            ->maxLength(150)
                            ->placeholder('Settlement Category Name')
                            ->required()
                            ->columnSpan(4)
                            ->autocomplete(false),
                        Textarea::make('description')
                            ->label('Remarks')
                            ->placeholder('Additional information')
                            ->nullable()
                            ->rows(3)
                            ->columnSpanFull()
                    ])
                    ->columns(12)
                    ->columnSpanFull()
            ]);
    }
}
