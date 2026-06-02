<?php

namespace App\Filament\Resources\PurchaseRequisitions\Tables;

use App\Filament\Exports\PurchaseRequisitionExporter;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ExportAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class PurchaseRequisitionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('header.code')
                    ->label('Document Code')
                    ->searchable()
                    ->toggleable()
                    ->sortable(),
                TextColumn::make('header.doc_date')
                    ->label('Date')
                    ->date('d/M/Y')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('header.department.name')
                    ->label('Requested Department')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('header.requestor.name')
                    ->label('Requestor')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('header.priority')
                    ->badge()
                    ->label('Priority')
                    ->searchable()
                    ->sortable()
                    ->formatStateUsing(fn($state) => ucwords(strtolower(str_replace('_', ' ', $state))))
                    ->color(fn($record) => match ($record->header?->priority) {
                        'draft' => 'gray',
                        'normal' => 'success',
                        'high' => 'warning',
                        'urgent' => 'danger'
                    })
                    ->alignCenter()
                    ->toggleable(),
                TextColumn::make('header.doc_status')
                    ->label('Document Status')
                    ->searchable()
                    ->sortable()
                    ->toggleable()
                    ->formatStateUsing(fn($record) => ucwords(strtolower(str_replace('_', ' ', $record->header?->doc_status))))
                    ->alignCenter(),
                TextColumn::make('header.is_closed')
                    ->label('Closing Status')
                    ->searchable()
                    ->sortable()
                    ->toggleable()
                    ->formatStateUsing(fn($record) => $record->header?->is_closed ? 'Closed' : 'Unclosed')
                    ->alignCenter(),
                TextColumn::make('reason')
                    ->label('Reason')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('material.code')
                    ->label('Material Code')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('material.name')
                    ->label('Material name')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('material.specification')
                    ->label('Material Specification')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('units.code')
                    ->label('UoM')
                    ->searchable()
                    ->sortable()
                    ->toggleable()
                    ->alignCenter(),
                TextColumn::make('qty')
                    ->label('Qty')
                    ->numeric(4)
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('qty_remaining')
                    ->label('Outstanding Qty')
                    ->numeric(4)
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('supplier.name')
                    ->label('Suggested Supplier')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('arrival_date')
                    ->label('Requested Arrival Date')
                    ->date('d/M/Y')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('is_closed')
                    ->label('Closed By Row')
                    ->searchable()
                    ->sortable()
                    ->toggleable()
                    ->formatStateUsing(fn($state) => $state ? 'Yes' : 'No')
                    ->alignCenter(),
                TextColumn::make('remark')
                    ->label('Remark')
                    ->searchable()
                    ->sortable()
                    ->toggleable()
            ])
            ->recordUrl(function ($record) {
                return route('filament.admin.resources.purchase-requisitions.view', [
                    'record' => $record->purchase_requisition_header_id,
                ]);
            })
            ->filters([
                // TrashedFilter::make(),
            ])
            ->recordActions([
                // ViewAction::make(),
                // EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
                Action::make('refresh')
                    ->label('Refresh')
                    ->icon(Heroicon::OutlinedArrowPath)
                    ->action(fn() => null),
                ExportAction::make('export')
                    ->label('Export')
                    ->icon(Heroicon::OutlinedArrowDownTray)
                    ->exporter(PurchaseRequisitionExporter::class)
                    ->modifyQueryUsing(function (Builder $query) {
                        return $query
                            ->join('vw_purchase_requisition', 'purchase_requisition_details.id', '=', 'vw_purchase_requisition.id')
                            ->select('vw_purchase_requisition.*');
                    }),
            ]);
    }
}
