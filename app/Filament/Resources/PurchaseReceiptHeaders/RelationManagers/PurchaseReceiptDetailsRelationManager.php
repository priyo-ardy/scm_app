<?php

namespace App\Filament\Resources\PurchaseReceiptHeaders\RelationManagers;

use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;

class PurchaseReceiptDetailsRelationManager extends RelationManager
{
    protected static string $relationship = 'PurchaseReceiptDetails';

    public function table(Table $table): Table
    {
        return $table
            ->headerActions([
                CreateAction::make(),
            ]);
    }
}
