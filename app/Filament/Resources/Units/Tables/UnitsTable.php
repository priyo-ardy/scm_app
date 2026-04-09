<?php

namespace App\Filament\Resources\Units\Tables;

use App\Filament\Exports\UnitExporter;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ExportAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class UnitsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')
                    ->label('Symbol')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('name')
                    ->label('Unit Name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('category')
                    ->label('Unit Category')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('baseUnit.name')
                    ->label('Base Unit')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('conversion_factor')
                    ->label('Coversion Rate')
                    ->numeric()
                    ->sortable()
                    ->searchable()
                    ->alignRight(),
                TextColumn::make('is_active')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn(bool $state): string => $state ? 'Active' : 'Disable')
                    ->color(fn(bool $state): string => $state ? 'danger' : 'success')
                    ->alignCenter()
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
                Action::make('refresh')
                    ->label('Refresh')
                    ->icon(Heroicon::OutlinedArrowPath)
                    ->action(fn() => null),
                ExportAction::make()
                    ->exporter(UnitExporter::class)
                    ->label('Export')
                    ->icon(Heroicon::OutlinedArrowDownTray)
            ]);
    }
}
