<?php

namespace App\Filament\Resources\Materials\Pages;

use App\Filament\Resources\Materials\MaterialResource;
use App\Models\Material;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Icons\Heroicon;

class EditMaterial extends EditRecord
{
    protected static string $resource = MaterialResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('back')
                ->label('Back to List')
                ->icon('heroicon-m-arrow-left')
                ->color('gray')
                ->url(static::getResource()::getUrl('index')),
            Action::make('add')
                ->label('New')
                ->icon(Heroicon::OutlinedPlusCircle)
                ->color('success')
                ->url(fn() => $this->getResource()::getUrl('create')),
            Action::make('copy')
                ->label('Copy')
                ->icon(Heroicon::OutlinedDocumentDuplicate)
                ->color('warning')
                ->action(function ($record) {
                    $data = $record->toArray();
                    unset($data['id'], $data['created_at'], $data['updated_at']);
                    $data['code'] = $record->code . '-COPY-' . uniqid();
                    $newRecord = \App\Models\Material::create($data);

                    if ($newRecord) {
                        Notification::make()
                            ->title('Material Copied Successfully')
                            ->success()
                            ->send();

                        return redirect(static::getResource()::getUrl('edit', ['record' => $newRecord]));
                    }
                })
                ->requiresConfirmation()
                ->modalHeading('Duplicate data')
                ->modalDescription('Are you sure want to duplicate this data? Code will be suffixed with "-copy".'),
            DeleteAction::make()->icon(Heroicon::OutlinedTrash),
            Action::make('first')
                ->label('First')
                ->color('gray')
                ->tooltip('Go to first data')
                ->icon(Heroicon::OutlinedChevronDoubleLeft)
                ->url(function () {
                    $firstRecord = Material::orderBy('code', 'asc')->first();

                    return ($firstRecord && $firstRecord->id !== $this->record->id)
                        ? MaterialResource::getUrl('edit', ['record' => $firstRecord])
                        : null;
                })
                ->disabled(fn() => !Material::where('code', '<', $this->record->code)->exists()),
            Action::make('prev')
                ->label('Prev')
                ->color('gray')
                ->tooltip('Previous')
                ->icon(Heroicon::OutlinedChevronLeft)
                ->url(function () {
                    $prevRecord = Material::where('code', '<', $this->record->code)->orderBy('code', 'desc')->first();

                    return $prevRecord
                        ? MaterialResource::getUrl('edit', ['record' => $prevRecord]) : null;
                })
                ->hidden(fn() => !Material::where('code', '<', $this->record->code)->exists()),
            Action::make('next')
                ->label('Next')
                ->color('gray')
                ->tooltip('Next')
                ->icon(Heroicon::OutlinedChevronRight)
                ->iconPosition('after')
                ->url(function () {
                    $nextRecord = Material::where('code', '>', $this->record->code)->orderBy('code', 'asc')->first();

                    return $nextRecord
                        ? MaterialResource::getUrl('edit', ['record' => $nextRecord])
                        : null;
                })
                ->hidden(fn() => !Material::where('code', '>', $this->record->code)->exists()),
            Action::make('last')
                ->label('Last')
                ->color('gray')
                ->tooltip('Go to last data')
                ->icon(Heroicon::OutlinedChevronDoubleRight)
                ->iconPosition('after')
                ->url(function () {
                    $lastRecord = Material::orderBy('code', 'desc')->first();

                    // Jangan redirect kalau kita sudah di record terakhir
                    return ($lastRecord && $lastRecord->id !== $this->record->id)
                        ? MaterialResource::getUrl('edit', ['record' => $lastRecord])
                        : null;
                })
                ->disabled(fn() => !Material::where('code', '>', $this->record->code)->exists())
        ];
    }
}
