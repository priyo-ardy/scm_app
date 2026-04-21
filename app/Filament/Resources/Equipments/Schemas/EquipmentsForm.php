<?php

namespace App\Filament\Resources\Equipments\Schemas;

use App\Models\Equipment;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;

class EquipmentsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->description('Company Information')
                    ->schema([
                        Select::make('company_id')
                            ->label('Company')
                            ->relationship('companyList', 'name')
                            ->native(false)
                            ->preload()
                            ->required()
                            ->live()
                            ->afterStateUpdated(fn(Set $set) => $set('branch_id', null))
                            ->searchable()
                            ->columnSpan(4),
                        Select::make('branch_id')
                            ->label('Branch')
                            ->relationship('branchList', 'name', modifyQueryUsing: fn(Builder $query, Get $get) => $query->where('company_id', $get('company_id')))
                            ->native(false)
                            ->preload()
                            ->required()
                            ->live()
                            ->searchable()
                            ->columnSpan(3),
                    ])
                    ->columns(12)
                    ->columnSpanFull(),
                Section::make()
                    ->schema([
                        Select::make('category_id')
                            ->label('Machine/Equipment Category')
                            ->relationship('category', 'name')
                            ->native(false)
                            ->preload()
                            ->required()
                            ->searchable()
                            ->live()
                            ->afterStateUpdated(function ($state, $set) {
                                if ($state) {
                                    $code = Equipment::generateCurrentCode($state);
                                    $set('code', $code);
                                } else {
                                    $set('code', null);
                                }
                            })
                            ->columnSpan(3),
                        TextInput::make('code')
                            ->label('Code')
                            ->readOnly()
                            ->placeholder('Automatically generate after save')
                            ->dehydrated()
                            ->columnSpan(2),
                        TextInput::make('name')
                            ->label('Name')
                            ->maxLength(150)
                            ->placeholder('Equipment/Machine Name')
                            ->required()
                            ->autocomplete(false)
                            ->columnSpan(7),
                        Textarea::make('specification')
                            ->label('Specification')
                            ->required()
                            ->placeholder('Equipment/Machine Specification')
                            ->columnSpanFull()
                            ->autocomplete(false)
                            ->rows(5),
                        TextInput::make('equipment_no')
                            ->label('Machine/Equipment No.')
                            ->nullable()
                            ->placeholder('Machine/Equipment No.')
                            ->columnSpan(3)
                            ->autocomplete(false),
                        Select::make('workshop_id')
                            ->label('Workshop')
                            ->relationship('workshopList', 'name', modifyQueryUsing: fn(Builder $query, Get $get) => $query->where('branch_id', $get('branch_id')))
                            ->native(false)
                            ->preload()
                            ->searchable()
                            ->required()
                            ->columnSpan(3),
                        Select::make('tonnage_id')
                            ->label('Tonnage')
                            ->relationship('tonnageList', 'name')
                            ->native(false)
                            ->preload()
                            ->nullable()
                            ->columnSpan(3)
                            ->searchable(),
                        TextInput::make('brand')
                            ->label('Equipment/Machine Brand')
                            ->placeholder('Equipment/Machine Brand')
                            ->columnSpan(3)
                            ->autocomplete(false),
                        TextInput::make('model_number')
                            ->label('Model Number')
                            ->maxLength(50)
                            ->placeholder('Model Number')
                            ->autocomplete(false)
                            ->columnSpan(3),
                        TextInput::make('serial_number')
                            ->label('Serial No.')
                            ->placeholder('Serial No')
                            ->maxLength(50)
                            ->autocomplete(false)
                            ->columnSpan(3),
                        DatePicker::make('purchase_date')
                            ->label('Purchase Date')
                            ->columnSpan(2),
                        DatePicker::make('installation_date')
                            ->label('Installation Date')
                            ->columnSpan(2),
                        DatePicker::make('last_maintenance')
                            ->label('Last Maintenance')
                            ->readOnly()
                            ->columnSpan(2),
                        TextInput::make('machine_rate')
                            ->label('Machine/Equipment Rate')
                            ->placeholder('Machine/Equipment Rate')
                            ->autocomplete(false)
                            ->columnSpan(3),
                        Select::make('status')
                            ->label('Machine/Equipment Status')
                            ->options([
                                'standby' => 'Standby',
                                'running' => 'Running',
                                'breakdown' => 'Breakdown',
                                'repair' => 'Repair',
                            ])
                            ->searchable()
                            ->native(false)
                            ->required()
                            ->columnSpan(3),
                        TextInput::make('total_shots')
                            ->numeric()
                            ->nullable()
                            ->readOnly()
                            ->placeholder('Total Shots')
                            ->default(0)
                            ->columnSpan(2),
                        FileUpload::make('avatar')
                            ->label('Machine/Equipment Image')
                            ->imageEditor()
                            ->visibility('public')
                            ->directory('equipment-avatar')
                            ->disk('public')
                            ->saveRelationshipsUsing(null)
                            ->columnSpan(6),
                        Textarea::make('description')
                            ->label('Description')
                            ->placeholder('Additional information here')
                            ->rows(3)
                            ->columnSpan(6),
                    ])
                    ->columns(12)
                    ->columnSpanFull(),
            ]);
    }
}
