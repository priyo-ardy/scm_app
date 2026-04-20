<?php

namespace App\Filament\Resources\SetllementCategories;

use App\Filament\Resources\SetllementCategories\Pages\CreateSetllementCategory;
use App\Filament\Resources\SetllementCategories\Pages\EditSetllementCategory;
use App\Filament\Resources\SetllementCategories\Pages\ListSetllementCategories;
use App\Filament\Resources\SetllementCategories\Schemas\SetllementCategoryForm;
use App\Filament\Resources\SetllementCategories\Tables\SetllementCategoriesTable;
use App\Models\SettlementCategory;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SetllementCategoryResource extends Resource
{
    protected static ?string $model = SettlementCategory::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'SetllementCategory';

    public static function form(Schema $schema): Schema
    {
        return SetllementCategoryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SetllementCategoriesTable::configure($table);
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
            'index' => ListSetllementCategories::route('/'),
            'create' => CreateSetllementCategory::route('/create'),
            'edit' => EditSetllementCategory::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
