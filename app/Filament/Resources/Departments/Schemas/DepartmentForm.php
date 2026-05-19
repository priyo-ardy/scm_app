<?php

namespace App\Filament\Resources\Departments\Schemas;

use App\Models\Company;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class DepartmentForm
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
                            ->columnSpan(4),
                        TextInput::make('code')
                            ->label('Code')
                            ->readOnly()
                            ->placeholder('Automatic generate after save')
                            ->columnSpan(2),
                        TextInput::make('name')
                            ->label('Name')
                            ->maxLength(150)
                            ->placeholder('Department name')
                            ->required()
                            ->columnSpan(3)
                            ->autocomplete(false),
                        Select::make('manager_id')
                            ->label('Department Manager')
                            ->relationship('managerList', 'name')
                            ->searchable()
                            ->preload()
                            ->native(false)
                            ->columnSpan(3)
                            ->required(),
                        TextInput::make('cost_center_code')
                            ->label('Cost Center')
                            ->maxLength(50)
                            ->placeholder('Cost Center')
                            ->nullable()
                            ->unique(ignoreRecord: true)
                            ->validationMessages([
                                'unique' => 'This cost center already registered',
                            ])
                            ->columnSpan(2),
                        Textarea::make('remark')
                            ->label('Remark')
                            ->placeholder('Write additional information here ...')
                            ->columnSpan(10)
                            ->rows(3)
                            ->nullable(),
                    ])
                    ->columns(12)
                    ->columnSpanFull(),
            ]);
    }
}
