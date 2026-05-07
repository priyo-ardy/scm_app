<?php

namespace App\Filament\Resources\PurchaseRequisitions\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class PurchaseRequisitionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('company.slug')
                    ->label('Company')
                    ->wrap()
                    ->sortable()
                    ->toggleable()
                    ->searchable(),
                TextColumn::make('code')
                    ->label('Code')
                    ->toggleable(),
                TextColumn::make('doc_date')
                    ->label('Date')
                    ->date('Y-m-d')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('department.name')
                    ->label('Requested Department')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('requestor.name')
                    ->label('Requestor')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('doc_status')
                    ->label('Document Status')
                    ->formatStateUsing(fn($state) => ucwords(strtolower(str_replace('_', '', $state))))
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('priority')
                    ->label('Priority')
                    ->formatStateUsing(fn($state) => ucwords(strtolower(str_replace('_', ' ', $state))))
                    ->badge()
                    ->sortable()
                    ->color(fn($record) => match ($record->priority) {
                        'low' => 'gray',
                        'normal' => 'success',
                        'high' => 'warning',
                        'urgent' => 'danger',
                        default => 'secondary',
                    })
                    ->toggleable(),
                TextColumn::make('reason')
                    ->label('Reason')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('details.material.code')
                    ->label('Material Code')
                    ->listWithLineBreaks()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('details.material.name')
                    ->label('Material Name')
                    ->listWithLineBreaks()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('details.material.specification')
                    ->label('Material Specification')
                    ->listWithLineBreaks()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('details.units.code')
                    ->label('UoM')
                    ->listWithLineBreaks()
                    ->sortable()
                    ->toggleable()
                    ->alignCenter(),
                TextColumn::make('details.qty')
                    ->label('UoM')
                    ->formatStateUsing(fn($state) => number_format($state, 4, ',', '.'))
                    ->listWithLineBreaks()
                    ->sortable()
                    ->toggleable()
                    ->alignRight(),
                TextColumn::make('details.arrival_date')
                    ->label('Arrival Date')
                    ->date('Y-m-d')
                    ->listWithLineBreaks()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('details.supplier.name')
                    ->label('Suggested Supplier')
                    ->listWithLineBreaks()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('details.remark')
                    ->label('Remark')
                    ->sortable()
                    ->toggleable()
                    ->listWithLineBreaks()
            ])
            ->filters([
                TrashedFilter::make(),
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
            ]);
    }
}
