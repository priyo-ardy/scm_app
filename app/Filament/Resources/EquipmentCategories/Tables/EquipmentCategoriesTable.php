<?php

namespace App\Filament\Resources\EquipmentCategories\Tables;

use App\Filament\Exports\EquipmentCategoryExporter;
use Filament\Actions\Action;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ExportAction;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;

class EquipmentCategoriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')
                    ->label('Code')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('prefix')
                    ->searchable()
                    ->sortable(),
                IconColumn::make('is_active')
                    ->label('Status')
                    ->boolean(),
                TextColumn::make('description')
                    ->label('remark')
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                // EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
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
                    ->action(fn () => null),
                ExportAction::make()
                    ->label('Export')
                    ->icon(Heroicon::OutlinedArrowDownTray)
                    ->exporter(EquipmentCategoryExporter::class),
            ]);
    }
}
