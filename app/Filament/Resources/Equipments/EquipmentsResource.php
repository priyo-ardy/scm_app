<?php

namespace App\Filament\Resources\Equipments;

use App\Filament\Resources\Equipments\Pages\CreateEquipments;
use App\Filament\Resources\Equipments\Pages\EditEquipments;
use App\Filament\Resources\Equipments\Pages\ListEquipments;
use App\Filament\Resources\Equipments\Schemas\EquipmentsForm;
use App\Filament\Resources\Equipments\Tables\EquipmentsTable;
use App\Models\Equipment;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class EquipmentsResource extends Resource
{
    protected static ?string $model = Equipment::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static string|UnitEnum|null $navigationGroup = 'Master Data';

    protected static ?string $navigationLabel = 'Machine & Equipments';

    protected static ?int $navigationSort = 11;

    protected static ?string $recordTitleAttribute = 'Machine & Equpment';

    public static function form(Schema $schema): Schema
    {
        return EquipmentsForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return EquipmentsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListEquipments::route('/'),
            'create' => CreateEquipments::route('/create'),
            'edit' => EditEquipments::route('/{record}/edit'),
        ];
    }

    public static function getPluralModelLabel(): string
    {
        // return parent::getPluralModelLabel();
        return "List of Machine & Equipments";
    }

    public static function getModelLabel(): string
    {
        // return parent::getModelLabel();
        return  'Machine & Equipments';
    }
}
