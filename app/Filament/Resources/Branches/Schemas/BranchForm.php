<?php

namespace App\Filament\Resources\Branches\Schemas;

use Dotswan\MapPicker\Fields\Map;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;

use function Laravel\Prompts\textarea;

class BranchForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->schema([
                        TextInput::make('code')
                            ->label('Branch Code')
                            ->readOnly()
                            ->placeholder('Automatic generate after save')
                            ->columnSpan(2),
                        Select::make('company_id')
                            ->label('Company')
                            ->relationship('company', 'name')
                            ->native()
                            ->preload()
                            ->searchable()
                            ->columnSpan(3)
                            ->required()
                            ->autofocus(),
                        TextInput::make('name')
                            ->label('Branch Name')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Branch Name')
                            ->columnSpan(5)
                            ->autocomplete(false),
                        Select::make('category')
                            ->label('Branch Category')
                            ->native()
                            ->searchable()
                            ->options([
                                'plant' => 'Production Plan',
                                'warehouse' => 'Warehouse',
                                'office' => 'Office'
                            ])->columnSpan(2)
                            ->required(),
                        TextInput::make('phone_ext')
                            ->label('Phone Extension')
                            ->tel()
                            ->placeholder('Phone Extension')
                            ->maxLength(20)
                            ->nullable()
                            ->columnSpan(2),
                        TextInput::make('manager_name')
                            ->label('Branch Responsibility')
                            ->maxLength(150)
                            ->placeholder('Branch Responsibility')
                            ->nullable()
                            ->columnSpan(4),
                        TextInput::make('total_manpower')
                            ->label('Total Manpower')
                            ->numeric()
                            ->placeholder('Total manpower on this branch')
                            ->default(1)
                            ->nullable()
                            ->columnSpan(2),
                        Textarea::make('address')
                            ->label('Branch Address')
                            ->placeholder('Branch Address')
                            ->nullable()
                            ->rows(3)
                            ->columnSpan(4),
                        Select::make('is_active')
                            ->label('Is Active ?')
                            ->native()
                            ->default('1')
                            ->options([
                                '0' => 'No',
                                '1' => 'Yes'
                            ])
                            ->searchable()
                            ->columnSpan(2),
                        Map::make('map_url')
                            ->label('Choose Location')
                            ->columnSpanFull()
                            ->formatStateUsing(fn($record) => $record ? [
                                'lat' => $record->latitude,
                                'lng' => $record->longitude,
                            ] : null)
                            ->afterStateHydrated(function (Map $component, ?array $state) {
                                if ($state) {
                                    $component->state($state);
                                }
                            })
                            ->afterStateUpdated(function (Set $set, ?array $state): void {
                                $set('latitude',  $state['lat'] ?? null);
                                $set('longitude', $state['lng'] ?? null);
                            })
                            ->extraControl([
                                'zoomControl' => true,
                                'detectRetina' => true,
                            ])
                            ->live(),
                    ])
                    ->columns(12)
                    ->columnSpanFull()
            ]);
    }
}
