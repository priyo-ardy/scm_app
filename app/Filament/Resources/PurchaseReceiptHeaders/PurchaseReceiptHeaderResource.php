<?php

namespace App\Filament\Resources\PurchaseReceiptHeaders;

use App\Filament\Resources\PurchaseReceiptHeaders\Pages\CreatePurchaseReceiptHeader;
use App\Filament\Resources\PurchaseReceiptHeaders\Pages\EditPurchaseReceiptHeader;
use App\Filament\Resources\PurchaseReceiptHeaders\Pages\ListPurchaseReceiptHeaders;
use App\Filament\Resources\PurchaseReceiptHeaders\Pages\ViewPurchaseReceiptHeader;
use App\Filament\Resources\PurchaseReceiptHeaders\Schemas\PurchaseReceiptHeaderForm;
use App\Filament\Resources\PurchaseReceiptHeaders\Schemas\PurchaseReceiptHeaderInfolist;
use App\Filament\Resources\PurchaseReceiptHeaders\Tables\PurchaseReceiptHeadersTable;
use App\Models\PurchaseReceiptHeader;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class PurchaseReceiptHeaderResource extends Resource
{
    protected static ?string $model = PurchaseReceiptHeader::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Purchase Receipt';

    protected static string|UnitEnum|null $navigationGroup = 'Transaction';

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationLabel = 'Purchase Receipt';

    protected static ?string $modelLabel = 'Purchase Receipt';

    protected static ?string $pluralLabel = 'List of Purcase Receipts';

    public static function form(Schema $schema): Schema
    {
        return PurchaseReceiptHeaderForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return PurchaseReceiptHeaderInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PurchaseReceiptHeadersTable::configure($table);
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
            'index' => ListPurchaseReceiptHeaders::route('/'),
            'create' => CreatePurchaseReceiptHeader::route('/create'),
            'view' => ViewPurchaseReceiptHeader::route('/{record}'),
            'edit' => EditPurchaseReceiptHeader::route('/{record}/edit'),
        ];
    }
}
