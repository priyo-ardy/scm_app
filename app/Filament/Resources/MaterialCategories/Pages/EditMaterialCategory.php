<?php

namespace App\Filament\Resources\MaterialCategories\Pages;

use App\Filament\Resources\MaterialCategories\MaterialCategoryResource;
use App\Models\MaterialCategory;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Icons\Heroicon;

class EditMaterialCategory extends EditRecord
{
    protected static string $resource = MaterialCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()->icon(Heroicon::OutlinedTrash)->tooltip('Delete this records'),
            Action::make('first')
                ->label('First')
                ->color('gray')
                ->tooltip('Go to first data')
                ->icon(Heroicon::OutlinedChevronDoubleLeft)
                ->url(function () {
                    $firstRecord = MaterialCategory::orderBy('code', 'asc')->first();

                    return ($firstRecord && $firstRecord->id !== $this->record->id)
                        ? MaterialCategoryResource::getUrl('edit', ['record' => $firstRecord])
                        : null;
                })
                ->disabled(fn () => ! MaterialCategory::where('code', '<', $this->record->code)->exists()),
            Action::make('prev')
                ->label('Prev')
                ->color('gray')
                ->tooltip('Previous')
                ->icon(Heroicon::OutlinedChevronLeft)
                ->url(function () {
                    $prevRecord = MaterialCategory::where('code', '<', $this->record->code)->orderBy('code', 'desc')->first();

                    return $prevRecord
                        ? MaterialCategoryResource::getUrl('edit', ['record' => $prevRecord]) : null;
                })
                ->hidden(fn () => ! MaterialCategory::where('code', '<', $this->record->code)->exists()),
            Action::make('next')
                ->label('Next')
                ->color('gray')
                ->tooltip('Next')
                ->icon(Heroicon::OutlinedChevronRight)
                ->iconPosition('after')
                ->url(function () {
                    $nextRecord = MaterialCategory::where('code', '>', $this->record->code)->orderBy('code', 'asc')->first();

                    return $nextRecord
                        ? MaterialCategoryResource::getUrl('edit', ['record' => $nextRecord])
                        : null;
                })
                ->hidden(fn () => ! MaterialCategory::where('code', '>', $this->record->code)->exists()),
            Action::make('last')
                ->label('Last')
                ->color('gray')
                ->tooltip('Go to last data')
                ->icon(Heroicon::OutlinedChevronDoubleRight)
                ->iconPosition('after')
                ->url(function () {
                    $lastRecord = MaterialCategory::orderBy('code', 'desc')->first();

                    // Jangan redirect kalau kita sudah di record terakhir
                    return ($lastRecord && $lastRecord->id !== $this->record->id)
                        ? MaterialCategoryResource::getUrl('edit', ['record' => $lastRecord])
                        : null;
                })
                ->disabled(fn () => ! MaterialCategory::where('code', '>', $this->record->code)->exists()),
        ];
    }
}
