<?php

namespace App\Filament\Resources\EquipmentCategories\Pages;

use App\Filament\Resources\EquipmentCategories\EquipmentCategoryResource;
use App\Models\EquipmentCategory;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Icons\Heroicon;

class EditEquipmentCategory extends EditRecord
{
    protected static string $resource = EquipmentCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('back')
                ->label('Back to List')
                ->icon('heroicon-m-arrow-left')
                ->color('gray')
                ->url(static::getResource()::getUrl('index')),
            DeleteAction::make()->icon(Heroicon::OutlinedTrash),
            Action::make('first')
                ->label('First')
                ->color('gray')
                ->tooltip('Go to first data')
                ->icon(Heroicon::OutlinedChevronDoubleLeft)
                ->url(function () {
                    $currentRecord = $this->record;

                    if (!$currentRecord instanceof EquipmentCategory) return null;

                    $firstRecord = EquipmentCategory::orderBy('code', 'asc')->first();
                    return ($firstRecord && $firstRecord->id !== $currentRecord->id)
                        ? EquipmentCategoryResource::getUrl('edit', ['record' => $firstRecord])
                        : null;
                })
                ->disabled(function () {
                    $currentRecord = $this->record;
                    if (!$currentRecord instanceof EquipmentCategory) return true;

                    return ! EquipmentCategory::where('code', '<', $currentRecord->code)->exists();
                }),
            Action::make('prev')
                ->label('Prev')
                ->color('gray')
                ->tooltip('Previous')
                ->icon(Heroicon::OutlinedChevronLeft)
                ->url(function () {
                    $currentRecord = $this->record;
                    if (!$currentRecord instanceof EquipmentCategory) return null;

                    $prevRecord = EquipmentCategory::where('code', '<', $currentRecord->code)
                        ->orderBy('code', 'desc')
                        ->first();

                    return $prevRecord
                        ? EquipmentCategoryResource::getUrl('edit', ['record' => $prevRecord])
                        : null;
                })
                ->hidden(function () {
                    $currentRecord = $this->record;
                    if (!$currentRecord instanceof EquipmentCategory) return true;

                    return ! EquipmentCategory::where('code', '<', $currentRecord->code)->exists();
                }),
            Action::make('next')
                ->label('Next')
                ->color('gray')
                ->tooltip('Next')
                ->icon(Heroicon::OutlinedChevronRight)
                ->iconPosition('after')
                ->url(function () {
                    $currentRecord = $this->record;
                    if (!$currentRecord instanceof EquipmentCategory) return null;

                    $nextRecord = EquipmentCategory::where('code', '>', $currentRecord->code)
                        ->orderBy('code', 'asc')
                        ->first();

                    return $nextRecord
                        ? EquipmentCategoryResource::getUrl('edit', ['record' => $nextRecord])
                        : null;
                })
                ->hidden(function () {
                    $currentRecord = $this->record;
                    if (!$currentRecord instanceof EquipmentCategory) return true;

                    return ! EquipmentCategory::where('code', '>', $currentRecord->code)->exists();
                }),
            Action::make('last')
                ->label('Last')
                ->color('gray')
                ->tooltip('Go to last data')
                ->icon(Heroicon::OutlinedChevronDoubleRight)
                ->iconPosition('after')
                ->url(function () {
                    $currentRecord = $this->record;
                    if (!$currentRecord instanceof EquipmentCategory) return null;

                    $lastRecord = EquipmentCategory::orderBy('code', 'desc')->first();

                    return ($lastRecord && $lastRecord->id !== $currentRecord->id)
                        ? EquipmentCategoryResource::getUrl('edit', ['record' => $lastRecord])
                        : null;
                })
                ->disabled(function () {
                    $currentRecord = $this->record;
                    if (!$currentRecord instanceof EquipmentCategory) return true;

                    return ! EquipmentCategory::where('code', '>', $currentRecord->code)->exists();
                }),
        ];
    }
}
