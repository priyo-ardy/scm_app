<?php

namespace App\Filament\Resources\PurchaseRequisitions;

use App\Filament\Resources\PurchaseRequisitions\Pages\CreatePurchaseRequisition;
use App\Filament\Resources\PurchaseRequisitions\Pages\EditPurchaseRequisition;
use App\Filament\Resources\PurchaseRequisitions\Pages\ListPurchaseRequisitions;
use App\Filament\Resources\PurchaseRequisitions\Pages\ViewPurchaseRequisition;
use App\Filament\Resources\PurchaseRequisitions\Schemas\PurchaseRequisitionForm;
use App\Filament\Resources\PurchaseRequisitions\Schemas\PurchaseRequisitionInfolist;
use App\Filament\Resources\PurchaseRequisitions\Tables\PurchaseRequisitionsTable;
use App\Models\PurchaseRequisitionHeader;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use UnitEnum;

class PurchaseRequisitionResource extends Resource
{
    protected static ?string $model = PurchaseRequisitionHeader::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;
    protected static ?string $recordTitleAttribute = 'PurchaseRequisition';
    protected static ?string $modelLabel = 'Purchase Requisition';
    protected static ?string $pluralLabel = 'List of Purchase Requisition';
    protected static string|UnitEnum|null $navigationGroup = 'Transaction';

    public static function form(Schema $schema): Schema
    {
        return PurchaseRequisitionForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return PurchaseRequisitionInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PurchaseRequisitionsTable::configure($table);
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
            'index' => ListPurchaseRequisitions::route('/'),
            'create' => CreatePurchaseRequisition::route('/create'),
            'view' => ViewPurchaseRequisition::route('/{record}'),
            'edit' => EditPurchaseRequisition::route('/{record}/edit'),
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
