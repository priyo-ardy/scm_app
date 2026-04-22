<?php

namespace App\Filament\Resources\PaymentTerms\Tables;

use App\Filament\Exports\PaymentTermExporter;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ExportAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\QueryBuilder\Constraints\SelectConstraint;
use Filament\QueryBuilder\Constraints\TextConstraint;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\QueryBuilder;
use Filament\Tables\Table;

class PaymentTermsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')
                    ->label('Code')
                    ->searchable(),
                TextColumn::make('bill_period_basis')
                    ->label('Bill Period Basis')
                    ->formatStateUsing(fn (string $state): string => ucwords(str_replace('_', ' ', $state))),
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('is_active')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (bool $state): string => $state ? 'Active' : 'Not Active')
                    ->color(fn (bool $state): string => $state ? 'success' : 'danger')
                    ->alignCenter(),
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
            ])
            ->filters([
                QueryBuilder::make()
                    ->constraints([
                        SelectConstraint::make('bill_period_basis')
                            ->label('Bill Period Basis')
                            ->options([
                                'business_date' => 'Business date',
                                'order_date' => 'Order date',
                                'material_receipt' => 'Material receipt',
                                'warehouse_receipt' => 'Warehouse receipt',
                            ])
                            ->searchable(),
                        TextConstraint::make('name')->label('Name'),
                        SelectConstraint::make('is_active')
                            ->label('Status')
                            ->options([
                                '0' => 'Not Active',
                                '1' => 'Active',
                            ]),
                    ]),
            ], layout: FiltersLayout::Modal)
            ->filtersFormColumns(1)
            ->filtersFormWidth('4xl')
            ->persistFiltersInSession()
            ->filtersTriggerAction(
                fn ($action) => $action
                    ->button()
                    ->label('Filter')
                    ->icon(Heroicon::OutlinedFunnel)
            )
            ->recordActions([
                EditAction::make(),
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
                    ->action(fn () => null),
                ExportAction::make('export')
                    ->label('Export')
                    ->icon(Heroicon::OutlinedArrowDownTray)
                    ->exporter(PaymentTermExporter::class),
            ]);
    }
}
