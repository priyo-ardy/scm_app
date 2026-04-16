<?php

namespace App\Filament\Resources\PaymentTerms\Pages;

use App\Filament\Resources\PaymentTerms\PaymentTermResource;
use App\Models\PaymentTerm;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Icons\Heroicon;

class EditPaymentTerm extends EditRecord
{
    protected static string $resource = PaymentTermResource::class;

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

                    if (!$currentRecord instanceof PaymentTerm) return null;

                    $firstRecord = PaymentTerm::orderBy('code', 'asc')->first();
                    return ($firstRecord && $firstRecord->id !== $currentRecord->id)
                        ? PaymentTermResource::getUrl('edit', ['record' => $firstRecord])
                        : null;
                })
                ->disabled(function () {
                    $currentRecord = $this->record;
                    if (!$currentRecord instanceof PaymentTerm) return true;

                    return ! PaymentTerm::where('code', '<', $currentRecord->code)->exists();
                }),
            Action::make('prev')
                ->label('Prev')
                ->color('gray')
                ->tooltip('Previous')
                ->icon(Heroicon::OutlinedChevronLeft)
                ->url(function () {
                    $currentRecord = $this->record;
                    if (!$currentRecord instanceof PaymentTerm) return null;

                    $prevRecord = PaymentTerm::where('code', '<', $currentRecord->code)
                        ->orderBy('code', 'desc')
                        ->first();

                    return $prevRecord
                        ? PaymentTermResource::getUrl('edit', ['record' => $prevRecord])
                        : null;
                })
                ->hidden(function () {
                    $currentRecord = $this->record;
                    if (!$currentRecord instanceof PaymentTerm) return true;

                    return ! PaymentTerm::where('code', '<', $currentRecord->code)->exists();
                }),
            Action::make('next')
                ->label('Next')
                ->color('gray')
                ->tooltip('Next')
                ->icon(Heroicon::OutlinedChevronRight)
                ->iconPosition('after')
                ->url(function () {
                    $currentRecord = $this->record;
                    if (!$currentRecord instanceof PaymentTerm) return null;

                    $nextRecord = PaymentTerm::where('code', '>', $currentRecord->code)
                        ->orderBy('code', 'asc')
                        ->first();

                    return $nextRecord
                        ? PaymentTermResource::getUrl('edit', ['record' => $nextRecord])
                        : null;
                })
                ->hidden(function () {
                    $currentRecord = $this->record;
                    if (!$currentRecord instanceof PaymentTerm) return true;

                    return ! PaymentTerm::where('code', '>', $currentRecord->code)->exists();
                }),
            Action::make('last')
                ->label('Last')
                ->color('gray')
                ->tooltip('Go to last data')
                ->icon(Heroicon::OutlinedChevronDoubleRight)
                ->iconPosition('after')
                ->url(function () {
                    $currentRecord = $this->record;
                    if (!$currentRecord instanceof PaymentTerm) return null;

                    $lastRecord = PaymentTerm::orderBy('code', 'desc')->first();

                    return ($lastRecord && $lastRecord->id !== $currentRecord->id)
                        ? PaymentTermResource::getUrl('edit', ['record' => $lastRecord])
                        : null;
                })
                ->disabled(function () {
                    $currentRecord = $this->record;
                    if (!$currentRecord instanceof PaymentTerm) return true;

                    return ! PaymentTerm::where('code', '>', $currentRecord->code)->exists();
                }),
        ];
    }
}
