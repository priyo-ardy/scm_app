<?php

namespace App\Filament\Resources\MaterialCategories\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
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
                        Select::make('parent_id')
                            ->label('Category Header')
                            ->relationship('header', 'name', fn ($query) => $query->orderBy('code', 'asc'))
                            ->getOptionLabelFromRecordUsing(function ($record) {
                                $depth = substr_count($record->code, '.');
                                $indent = str_repeat('   ', $depth);

                                return "{$indent}{$record->code} - {$record->name}";
                            })
                            ->native(false)
                            ->preload()
                            ->searchable(['name', 'code'])
                            ->columnSpan(4)
                            ->nullable()
                            ->live()
                            ->afterStateUpdated(function ($state, $set, $get, $record) {
                                if (blank($state)) {
                                    // Jika dikosongkan (jadi root), user harus isi manual
                                    $set('code', null);
                                } else {
                                    // Jika state (parent_id) yang baru SAMA dengan parent_id yang lama (di database)
                                    // Kembalikan kode asli dari record tersebut.
                                    if ($record && $state == $record->parent_id) {
                                        $set('code', $record->code);
                                    } else {
                                        // Jika benar-benar ganti parent, baru tampilkan placeholder
                                        $set('code', 'Auto-generated...');
                                    }
                                }
                            }),
                        TextInput::make('code')
                            ->label('Material Category Code')
                            ->placeholder(fn ($get) => $get('parent_id') ? 'Automatically generate after save' : 'Input code manually')
                            ->disabled(fn ($get) => filled($get('parent_id')))
                            ->dehydrated()
                            ->required(fn ($get) => blank($get('parent_id')))
                            ->unique(ignoreRecord: true)
                            ->validationMessages([
                                'This code already registered',
                            ])
                            ->columnSpan(2),
                        TextInput::make('name')
                            ->label('Material Categor Name')
                            ->required()
                            ->maxLength(150)
                            ->placeholder('Material category name')
                            ->autofocus()
                            ->autocomplete(false)
                            ->columnSpan(6),
                        Textarea::make('remark')
                            ->default(null)
                            ->columnSpanFull()->nullable(),
                    ])
                    ->columns(12)
                    ->columnSpanFull(),
            ]);
    }
}
