<?php

namespace App\Filament\Resources\EquipmentCategories\Schemas;

use App\Models\Company;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
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
                        Select::make('company_id')
                            ->label('Company')
                            ->relationship('companyList', 'name')
                            ->searchable(['slug', 'name'])
                            ->preload()
                            ->required()
                            ->default(function () {
                                $sessionCompanyId = session('active_company');

                                // 2. Jika session tidak null, jadikan itu sebagai default
                                if ($sessionCompanyId) {
                                    return $sessionCompanyId;
                                }

                                // 3. Jika session null (Super Admin), ambil company default dari DB
                                return Company::where('is_default', 1)->first()?->id;
                            })
                            ->disabled(fn () => session('active_company') !== null)
                            ->dehydrated(true)
                            ->columnSpanFull()
                            ->columnSpan(4),
                        TextInput::make('code')
                            ->label('Code')
                            ->readOnly()
                            ->placeholder('Automatically generate after save')
                            ->columnSpan(2),
                        TextInput::make('name')
                            ->label('Name')
                            ->placeholder('Equipment category name')
                            ->maxLength(150)
                            ->autofocus()
                            ->autocomplete(false)
                            ->columnSpan(6),
                        TextInput::make('prefix')
                            ->label('Prefix')
                            ->maxLength(10)
                            ->unique(ignoreRecord: true)
                            ->autocomplete(false)
                            ->placeholder('Prefix for this category')
                            ->columnSpan(3),
                        Textarea::make('description')
                            ->label('Remark')
                            ->placeholder('Add additional information here')
                            ->rows(3)
                            ->columnSpan(9),
                    ])
                    ->columns(12)
                    ->columnSpanFull(),
            ]);
    }
}
