<?php

namespace App\Filament\Resources\MaterialCategories;

use App\Filament\Resources\MaterialCategories\Pages\CreateMaterialCategory;
use App\Filament\Resources\MaterialCategories\Pages\EditMaterialCategory;
use App\Filament\Resources\MaterialCategories\Pages\ListMaterialCategories;
use App\Filament\Resources\MaterialCategories\Schemas\MaterialCategoryForm;
use App\Filament\Resources\MaterialCategories\Tables\MaterialCategoriesTable;
use App\Models\MaterialCategory;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class MaterialCategoryResource extends Resource
{
    protected static ?string $model = MaterialCategory::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static string|UnitEnum|null $navigationGroup = 'Master Data';

    protected static ?int $navigationSort = 8;

    protected static ?string $pluralLabel = 'Material Categories';

    protected static ?string $label = 'Material Category';

    protected static ?string $recordTitleAttribute = 'Material Category';

    public static function form(Schema $schema): Schema
    {
        return MaterialCategoryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MaterialCategoriesTable::configure($table);
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
            'index' => ListMaterialCategories::route('/'),
            'create' => CreateMaterialCategory::route('/create'),
            'edit' => EditMaterialCategory::route('/{record}/edit'),
        ];
    }
}
