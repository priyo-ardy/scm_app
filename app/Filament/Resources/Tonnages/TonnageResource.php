<?php

namespace App\Filament\Resources\Tonnages;

use App\Filament\Resources\Tonnages\Pages\CreateTonnage;
use App\Filament\Resources\Tonnages\Pages\EditTonnage;
use App\Filament\Resources\Tonnages\Pages\ListTonnages;
use App\Filament\Resources\Tonnages\Schemas\TonnageForm;
use App\Filament\Resources\Tonnages\Tables\TonnagesTable;
use App\Models\Tonnage;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class TonnageResource extends Resource
{
    protected static ?string $model = Tonnage::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static string|UnitEnum|null $navigationGroup = 'Master Data';

    protected static ?int $navigationSort = 7;

    protected static ?string $pluralLabel = 'Tonnage';

    protected static ?string $label = 'Tonnage';

    protected static ?string $recordTitleAttribute = 'Tonnage';

    public static function form(Schema $schema): Schema
    {
        return TonnageForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TonnagesTable::configure($table);
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
            'index' => ListTonnages::route('/'),
            'create' => CreateTonnage::route('/create'),
            'edit' => EditTonnage::route('/{record}/edit'),
        ];
    }
}
