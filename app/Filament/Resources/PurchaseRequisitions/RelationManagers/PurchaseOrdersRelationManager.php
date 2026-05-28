<?php

namespace App\Filament\Resources\PurchaseRequisitions\RelationManagers;

use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PurchaseOrdersRelationManager extends RelationManager
{
    protected static string $relationship = 'purchaseOrderDetails';
    protected static ?string $title = 'Associated Document';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('qty')
                    ->required()
                    ->numeric(),
            ]);
    }

    public function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                // 1. Ubah purchaseOrders menjadi purchaseOrder (Singular)
                TextEntry::make('detail.code')->label('Purchase Order No.'),
                TextEntry::make('detail.doc_date')->label('PO. Date')->date('d/M/Y'),
                TextEntry::make('detail.supplier.name')->label('Supplier'),

                // 2. Pastikan huruf kecil semua
                TextEntry::make('material.code')->label('Material Code'),
                TextEntry::make('material.name')->label('Material Name'),
                TextEntry::make('material.specification')->label('Specification'), // Sesuaikan jika spec ada di tabel material
                TextEntry::make('qty')->label('Qty Order')->numeric(),
                TextEntry::make('qty')->label('Qty Receive')->numeric()
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                // 1. Perbaikan ke Singular (Tanpa akhiran 's')
                TextColumn::make('detail.code')
                    ->label('PO Number'),
                TextColumn::make('detail.doc_date')
                    ->label('PO Date')
                    ->date('d/M/Y')
                    ->searchable(),
                TextColumn::make('detail.supplier.name')
                    ->label('Supplier'),
                TextColumn::make('material.code')
                    ->label('Material Code'),
                TextColumn::make('material.name')
                    ->label('Material Name'),
                TextColumn::make('material.specification')
                    ->label('Specification'),
                TextColumn::make('units.code')
                    ->label('UoM')
                    ->alignCenter(),
                TextColumn::make('qty')
                    ->label('Qty Order')
                    ->numeric()
                    ->alignRight()
                    ->formatStateUsing(fn($state) => number_format($state, 4)),
                TextColumn::make('qty_recieve')
                    ->label('Received Qty')
                    ->numeric()
                    ->getStateUsing(function ($record) {
                        return $record->qty - $record->qty_remaining;
                    })
                    ->formatStateUsing(fn($state) => number_format($state, 4))
                    ->alignRight(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                // CreateAction::make(),
                // AssociateAction::make(),
            ])
            ->recordActions([])
            ->toolbarActions([]);
    }
}
