<?php

namespace App\Filament\Resources\EquipmentCategories\Tables;

use App\Filament\Exports\EquipmentCategoryExporter;
use App\Models\Company;
use Filament\Actions\Action;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ExportAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\QueryBuilder\Constraints\SelectConstraint;
use Filament\QueryBuilder\Constraints\TextConstraint;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\QueryBuilder;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;

class EquipmentCategoriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('companyList.slug')
                    ->label('Company')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('code')
                    ->label('Code')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('prefix')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('is_active')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn($state) => $state ? 'Enable' : 'Disable')
                    ->color(fn($state) => $state ? 'success' : 'gray')
                    ->toggleable(),
                TextColumn::make('description')
                    ->label('Remark')
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                QueryBuilder::make()
                    ->constraints([
                        TextConstraint::make('code')
                            ->label('Code'),
                        TextConstraint::make('name')
                            ->label('Name'),
                        TextConstraint::make('prefix')
                            ->label('Prefix'),
                        SelectConstraint::make('company_id')
                            ->label('Company')
                            ->options(fn() => Company::pluck('name', 'id'))
                            ->searchable(),
                        SelectConstraint::make('is_active')
                            ->label('Status')
                            ->options([
                                '0' => 'Disable',
                                '1' => 'Enable'
                            ])
                            ->searchable()
                    ])
            ], layout: FiltersLayout::Modal)
            ->filtersFormWidth('3xl')
            ->persistFiltersInSession()
            ->filtersTriggerAction(
                fn($action) => $action
                    ->button()
                    ->label('Filter')
                    ->icon(Heroicon::Funnel)
            )
            ->recordActions([
                // EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                    BulkAction::make('bulkEdit')
                        ->label('Mass edit')
                        ->icon(Heroicon::OutlinedPencilSquare)
                        ->color('warning')
                        ->modalWidth('md')
                        ->modalHeading('Mass Edit')
                        ->schema([
                            Select::make('is_active')
                                ->label('Status')
                                ->options([
                                    '0' => 'Deactive',
                                    '1' => 'Active',
                                ])
                                ->searchable()
                                ->native(false),
                        ])->action(function (Collection $records, array $data) {
                            foreach ($records as $record) {
                                $record->update([
                                    'is_active' => $data['is_active'],
                                ]);
                            }

                            $count = $records->count();

                            Notification::make()
                                ->title('Success')
                                ->body("Equipment categories updated successfully, with total {$count} data updated.")
                                ->success()
                                ->send();
                        })
                        ->deselectRecordsAfterCompletion()
                        ->modalSubmitActionLabel('Update'),
                ]),
                Action::make('refresh')
                    ->label('Refresh')
                    ->icon(Heroicon::OutlinedArrowPath)
                    ->action(fn() => null),
                ExportAction::make()
                    ->label('Export')
                    ->icon(Heroicon::OutlinedArrowDownTray)
                    ->exporter(EquipmentCategoryExporter::class),
            ]);
    }
}
