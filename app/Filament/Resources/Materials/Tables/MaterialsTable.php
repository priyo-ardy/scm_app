<?php

namespace App\Filament\Resources\Materials\Tables;

use App\Filament\Exports\MaterialExporter;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ExportAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MaterialsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('company_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('category_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('code')
                    ->searchable(),
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('unit_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('purchase_unit_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('unit_conversion_rate')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('spq')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('qty_bag')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('net_weight')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('gross_weight')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('sprue')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('cycle_time')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('shift_capacity')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('properties')
                    ->badge(),
                TextColumn::make('color')
                    ->searchable(),
                TextColumn::make('cavity')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('workshop_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('cust_part_no')
                    ->searchable(),
                TextColumn::make('cust_part_name')
                    ->searchable(),
                TextColumn::make('avatar')
                    ->searchable(),
                IconColumn::make('enable_min_stock')
                    ->boolean(),
                TextColumn::make('min_stock')
                    ->numeric()
                    ->sortable(),
                IconColumn::make('enable_safety_stock')
                    ->boolean(),
                TextColumn::make('safety_stock')
                    ->numeric()
                    ->sortable(),
                IconColumn::make('enabl_max_stock')
                    ->boolean(),
                TextColumn::make('max_stock')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('reorder_point')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('supplier_id')
                    ->numeric()
                    ->sortable(),
                IconColumn::make('is_hazardous')
                    ->boolean(),
                TextColumn::make('storage_location_id')
                    ->searchable(),
                IconColumn::make('enable_expired')
                    ->boolean(),
                TextColumn::make('expiry_days')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('lead_time_days')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('status')
                    ->badge(),
                TextColumn::make('revision_no')
                    ->searchable(),
                TextColumn::make('hs_code')
                    ->searchable(),
                TextColumn::make('regrind_method')
                    ->badge(),
                TextColumn::make('carton_length')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('carton_width')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('carton_height')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('dimension_unit_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('stacking_limit')
                    ->numeric()
                    ->sortable(),
                IconColumn::make('is_inspection_required')
                    ->boolean(),
                TextColumn::make('last_purchase_price')
                    ->money()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_by')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('updated_by')
                    ->numeric()
                    ->sortable(),
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
                ExportAction::make('export')
                    ->label('Export')
                    ->icon(Heroicon::OutlinedArrowDownTray)
                    ->exporter(MaterialExporter::class)
            ]);
    }
}
