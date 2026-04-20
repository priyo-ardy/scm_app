<?php

namespace App\Filament\Resources\PaymentMethods\Pages;

use App\Filament\Resources\PaymentMethods\PaymentMethodResource;
use App\Models\PaymentMethod;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Icons\Heroicon;

class EditPaymentMethod extends EditRecord
{
    protected static string $resource = PaymentMethodResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // DeleteAction::make(),
            // ForceDeleteAction::make(),
            // RestoreAction::make(),
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
            DeleteAction::make()->icon(Heroicon::OutlinedTrash),
            ForceDeleteAction::make(),
            RestoreAction::make(),
            Action::make('first')
                ->label('First')
                ->color('gray')
                ->tooltip('Go to first data')
                ->icon(Heroicon::OutlinedChevronDoubleLeft)
                ->url(function () {
                    $firstRecord = PaymentMethod::orderBy('code', 'asc')->first();

                    return ($firstRecord && $firstRecord->id !== $this->record->id)
                        ? PaymentMethodResource::getUrl('edit', ['record' => $firstRecord])
                        : null;
                })
                ->disabled(fn() => ! PaymentMethod::where('code', '<', $this->record->code)->exists()),
            Action::make('prev')
                ->label('Prev')
                ->color('gray')
                ->tooltip('Previous')
                ->icon(Heroicon::OutlinedChevronLeft)
                ->url(function () {
                    $prevRecord = PaymentMethod::where('code', '<', $this->record->code)->orderBy('code', 'desc')->first();

                    return $prevRecord
                        ? PaymentMethodResource::getUrl('edit', ['record' => $prevRecord]) : null;
                })
                ->hidden(fn() => ! PaymentMethod::where('code', '<', $this->record->code)->exists()),
            Action::make('next')
                ->label('Next')
                ->color('gray')
                ->tooltip('Next')
                ->icon(Heroicon::OutlinedChevronRight)
                ->iconPosition('after')
                ->url(function () {
                    $nextRecord = PaymentMethod::where('code', '>', $this->record->code)->orderBy('code', 'asc')->first();

                    return $nextRecord
                        ? PaymentMethodResource::getUrl('edit', ['record' => $nextRecord])
                        : null;
                })
                ->hidden(fn() => ! PaymentMethod::where('code', '>', $this->record->code)->exists()),
            Action::make('last')
                ->label('Last')
                ->color('gray')
                ->tooltip('Go to last data')
                ->icon(Heroicon::OutlinedChevronDoubleRight)
                ->iconPosition('after')
                ->url(function () {
                    $lastRecord = PaymentMethod::orderBy('code', 'desc')->first();

                    // Jangan redirect kalau kita sudah di record terakhir
                    return ($lastRecord && $lastRecord->id !== $this->record->id)
                        ? PaymentMethodResource::getUrl('edit', ['record' => $lastRecord])
                        : null;
                })
                ->disabled(fn() => ! PaymentMethod::where('code', '>', $this->record->code)->exists()),
        ];
    }
}
