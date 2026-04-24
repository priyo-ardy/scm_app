<?php

namespace App\Filament\Resources\PurchasePriceHeaders;

use App\Filament\Resources\PurchasePriceHeaders\Pages\CreatePurchasePriceHeader;
use App\Filament\Resources\PurchasePriceHeaders\Pages\EditPurchasePriceHeader;
use App\Filament\Resources\PurchasePriceHeaders\Pages\ListPurchasePriceHeaders;
use App\Filament\Resources\PurchasePriceHeaders\RelationManagers\DetailsRelationManager;
use App\Filament\Resources\PurchasePriceHeaders\RelationManagers\PurchasePriceDetailsRelationManager;
use App\Filament\Resources\PurchasePriceHeaders\Schemas\PurchasePriceHeaderForm;
use App\Filament\Resources\PurchasePriceHeaders\Tables\PurchasePriceHeadersTable;
use App\Models\PurchasePriceHeader;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use UnitEnum;

class PurchasePriceHeaderResource extends Resource
{
    protected static ?string $model = PurchasePriceHeader::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'PurchasePriceHeader';
    protected static ?string $navigationLabel = 'Purchase Price';
    protected static string|UnitEnum|null $navigationGroup = 'Master Data';
    protected static ?int $navigationSort = 13;

    public static function form(Schema $schema): Schema
    {
        return PurchasePriceHeaderForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PurchasePriceHeadersTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            PurchasePriceDetailsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPurchasePriceHeaders::route('/'),
            'create' => CreatePurchasePriceHeader::route('/create'),
            'edit' => EditPurchasePriceHeader::route('/{record}/edit'),
        ];
    }

    public static function getModelLabel(): string
    {
        // return parent::getModelLabel();
        return 'Purchase Price';
    }

    public static function getPluralLabel(): ?string
    {
        // return parent::getPluralLabel();
        return 'list of Puchase Price';
    }
}
