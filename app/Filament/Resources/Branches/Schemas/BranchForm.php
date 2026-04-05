<?php

namespace App\Filament\Resources\Branches\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class BranchForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('company_id')
                    ->required()
                    ->numeric(),
                TextInput::make('code')
                    ->required(),
                TextInput::make('name')
                    ->required(),
                Select::make('category')
                    ->options(['plant' => 'Plant', 'warehouse' => 'Warehouse', 'office' => 'Office'])
                    ->default('plant')
                    ->required(),
                TextInput::make('phone_ext')
                    ->tel()
                    ->default(null),
                TextInput::make('manager_name')
                    ->default(null),
                TextInput::make('total_manpower')
                    ->required()
                    ->numeric()
                    ->default(0),
                Textarea::make('address')
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('map_url')
                    ->url()
                    ->default(null),
                Toggle::make('is_active')
                    ->required(),
            ]);
    }
}
