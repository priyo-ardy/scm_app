<?php

namespace App\Filament\Resources\MaterialCategories\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class MaterialCategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->schema([
                        TextInput::make('code')
                            ->label('Material Category Code')
                            ->readOnly()
                            ->placeholder('Auto generated after save')
                            ->columnSpan(2),
                        TextInput::make('name')
                            ->label('Material Categor Name')
                            ->required()
                            ->maxLength(150)
                            ->placeholder('Material category name')
                            ->autofocus()
                            ->autocomplete(false)
                            ->columnSpan(8),
                        TextInput::make('prefix')
                            ->required()
                            ->unique(ignoreRecord: false)
                            ->validationMessages([
                                'This prefix already in use'
                            ])
                            ->maxLength(20)
                            ->placeholder('Material prefix')
                            ->columnSpan(2),
                        Textarea::make('remark')
                            ->default(null)
                            ->columnSpanFull()->nullable(),
                    ])
                    ->columns(12)
                    ->columnSpanFull()
            ]);
    }
}
