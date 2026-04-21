<?php

namespace App\Filament\Resources\MaterialCategories\Tables;

use App\Filament\Exports\MaterialCategoryExporter;
use App\Models\Company;
use App\Models\MaterialCategory;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ExportAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\QueryBuilder\Constraints\SelectConstraint;
use Filament\QueryBuilder\Constraints\TextConstraint;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\QueryBuilder;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class MaterialCategoriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('companyList.slug')
                    ->label('Company')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('code')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('is_active')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn(bool $state): string => $state ? 'Enable' : 'Disable')
                    ->color(fn(bool $state): string => $state ? 'success' : 'gray')
                    ->alignCenter()
                    ->toggleable(),
            ])
            ->defaultSort('code', 'asc')
            ->filters([
                QueryBuilder::make()
                    ->constraints([
                        SelectConstraint::make('company_id')
                            ->label('Company')
                            ->options(fn() => Company::pluck('name', 'id'))
                            ->searchable(),
                        SelectConstraint::make('parent_id')
                            ->label('Parent Group')
                            ->options(
                                fn() => MaterialCategory::whereNull('parent_id')
                                    ->orderBy('code', 'asc')
                                    ->get()
                                    ->mapWithKeys(function ($item) {
                                        // Menggabungkan code dan name: "CODE - NAME"
                                        return [$item->id => "{$item->code} - {$item->name}"];
                                    })
                            )
                            ->searchable(),
                        SelectConstraint::make('is_active')
                            ->label('Status')
                            ->options([
                                '0' => 'Disable',
                                '1' => 'Enable'
                            ])
                            ->searchable(),
                        TextConstraint::make('name')
                            ->label('Name'),
                        TextConstraint::make('remark')
                            ->label('Remark')
                    ])
                    ->constraintPickerColumns(1)
            ], layout: FiltersLayout::Modal)
            ->filtersFormWidth('3xl')
            ->filtersTriggerAction(
                fn($action) => $action
                    ->button()
                    ->label('Filter')
                    ->icon(Heroicon::Funnel)
            )
            ->recordActions([
                // ViewAction::make(),
                // EditAction::make(),
                // DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make()
                ]),
                Action::make('refresh')
                    ->label('Refresh')
                    ->icon(Heroicon::OutlinedArrowPath)
                    ->action(fn() => null),
                ExportAction::make('export')
                    ->label('Export')
                    ->icon(Heroicon::OutlinedArrowDownTray)
                    ->exporter(MaterialCategoryExporter::class),
            ]);
    }
}
