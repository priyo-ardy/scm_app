<?php

namespace App\Filament\Resources\Sections\Schemas;

use App\Models\Company;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SectionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->schema([
                        Select::make('company_id')
                            ->label('Company')
                            ->relationship('companyList', 'name', modifyQueryUsing: fn($query) => $query->orderBy('name', 'asc'))
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
                                return Company::where('is_default', '=', true, 'and')->first()?->id;
                            })
                            ->disabled(fn() => session('active_company') !== null)
                            ->dehydrated(true)
                            ->columnSpan(4),
                        Select::make('department_id')
                            ->label('Department')
                            ->relationship('dept', 'name', modifyQueryUsing: fn($query) => $query->where('is_active', true)->orderBy('name', 'asc'))
                            ->searchable()
                            ->preload()
                            ->native(false)
                            ->required()
                            ->columnSpan(3),
                        TextInput::make('code')
                            ->label('Code')
                            ->readOnly()
                            ->placeholder('Automatic generate after save')
                            ->columnSpan(2),
                        TextInput::make('name')
                            ->label('Section Name')
                            ->maxLength(150)
                            ->required()
                            ->columnSpan(3)
                            ->placeholder('Section Name')
                            ->autocomplete(false),
                        Select::make('section_head_id ')
                            ->label('Section Head')
                            ->relationship('sectionHead', 'name', modifyQueryUsing: fn($query) => $query->where('is_active', true)->orderBy('name'))
                            ->searchable()
                            ->preload()
                            ->native(false)
                            ->required()
                            ->columnSpan(3),
                        Textarea::make('description')
                            ->label('Description')
                            ->placeholder('Write additional information here ...')
                            ->rows(3)
                            ->columnSpan(9)
                    ])
                    ->columns(12)
                    ->columnSpanFull()
            ]);
    }
}
