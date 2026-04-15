<?php

namespace App\Filament\Resources\Equipments\Pages;

use App\Filament\Resources\Equipments\EquipmentsResource;
use App\Models\Equipment;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Icons\Heroicon;

class EditEquipments extends EditRecord
{
    protected static string $resource = EquipmentsResource::class;

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

                    if (!$currentRecord instanceof Equipment) return null;

                    $firstRecord = Equipment::orderBy('code', 'asc')->first();

                    return ($firstRecord && $firstRecord->id !== $currentRecord->id)
                        ? EquipmentsResource::getUrl('edit', ['record' => $firstRecord])
                        : null;
                })
                ->disabled(function () {
                    $currentRecord = $this->record;

                    if (!$currentRecord instanceof Equipment) return true;

                    return ! Equipment::where('code', '<', $currentRecord)->exists();
                }),
            Action::make('prev')
                ->label('Prev')
                ->color('gray')
                ->tooltip('Previous')
                ->icon(Heroicon::OutlinedChevronLeft)
                ->url(function () {
                    $currentRecord = $this->record;

                    if (!$currentRecord instanceof Equipment) return null;

                    $prevRecord = Equipment::where('code', '<', $currentRecord->code)
                        ->orderBy('code', 'desc')
                        ->first();

                    return $prevRecord
                        ? EquipmentsResource::getUrl('edit', ['record' => $prevRecord])
                        : null;
                })
                ->hidden(function () {
                    $currentRecord = $this->record;

                    if (!$currentRecord instanceof Equipment) return true;

                    return ! Equipment::where('code', '<', $currentRecord->code)->exists();
                }),
            Action::make('next')
                ->label('Next')
                ->color('gray')
                ->tooltip('Next')
                ->icon(Heroicon::OutlinedChevronRight)
                ->iconPosition('after')
                ->url(function () {
                    $currentRecord = $this->record;

                    if (!$currentRecord instanceof Equipment) return null;

                    $nextRecord = Equipment::where('code', '>', $currentRecord->code)
                        ->orderBy('code', 'asc')
                        ->first();

                    return $nextRecord
                        ? EquipmentsResource::getUrl('edit', ['record' => $nextRecord])
                        : null;
                })
                ->hidden(function () {
                    $currentRecord = $this->record;
                    if (!$currentRecord instanceof Equipment) return true;

                    return ! Equipment::where('code', '>', $currentRecord->code)
                        ->exists();
                }),
            Action::make('last')
                ->label('Last')
                ->color('gray')
                ->tooltip('Go to last data')
                ->icon(Heroicon::OutlinedChevronDoubleRight)
                ->iconPosition('after')
                ->url(function () {
                    $currentRecord = $this->record;

                    if (!$currentRecord instanceof Equipment) return null;

                    $lastRecord = Equipment::orderBy('code', 'desc')->first();

                    // Jangan redirect kalau kita sudah di record terakhir
                    return ($lastRecord && $lastRecord->id !== $currentRecord->id)
                        ? EquipmentsResource::getUrl('edit', ['record' => $lastRecord])
                        : null;
                })
                ->disabled(function () {
                    $currentRecord = $this->record;
                    if (!$currentRecord instanceof Equipment) return true;

                    return ! Equipment::where('code', '>', $currentRecord->code)->exists();
                }),
        ];
    }
}
