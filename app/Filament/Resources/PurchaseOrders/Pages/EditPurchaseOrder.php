<?php

namespace App\Filament\Resources\PurchaseOrders\Pages;

use App\Filament\Resources\PurchaseOrders\PurchaseOrderResource;
use App\Models\PurchaseOrderHeader;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Icons\Heroicon;

class EditPurchaseOrder extends EditRecord
{
    protected static string $resource = PurchaseOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('back')
                ->label('Back to List')
                ->icon(Heroicon::OutlinedArrowLeft)
                ->tooltip('Back to List')
                ->url(static::getResource()::getUrl('index'))
                ->color('gray'),
            ViewAction::make()
                ->label('Cancel')
                ->icon(Heroicon::OutlinedArrowUturnLeft),
            Action::make('approve')
                ->label('Approve')
                ->tooltip('Approve')
                ->visible(fn ($record) => $record->doc_status == 'saved')
                ->color('gray')
                ->icon(Heroicon::OutlinedCheck)
                ->action(function ($record) {
                    $record->update(['doc_status' => 'approved']);

                    Notification::make()
                        ->title('Approve Success')
                        ->body('This document successfully approve')
                        ->success()
                        ->send();
                })->visible(fn ($record) => $record->doc_status == 'saved'),
            DeleteAction::make()
                ->icon(Heroicon::OutlinedTrash),
            ActionGroup::make([
                Action::make('prev')
                    ->label('Previous Page')
                    ->icon(Heroicon::OutlinedChevronLeft)
                    ->tooltip('Previous page')
                    ->action(function () {
                        $prevRecord = PurchaseOrderHeader::where('code', '<', $this->record->code, 'and')->orderBy('code', 'desc')->first();

                        return $prevRecord
                            ? PurchaseOrderResource::getUrl('edit', ['record' => $prevRecord]) : null;
                    })
                    ->hidden(fn () => ! PurchaseOrderHeader::where('code', '<', $this->record->code, 'and')->exists()),
                Action::make('next')
                    ->label('Next Page')
                    ->icon(Heroicon::OutlinedChevronRight)
                    ->tooltip('Next page')
                    ->url(function () {
                        $nextRecord = PurchaseOrderHeader::where('code', '>', $this->record->code, 'and')->orderBy('code', 'asc')->first();

                        return $nextRecord
                            ? PurchaseOrderResource::getUrl('edit', ['record' => $nextRecord])
                            : null;
                    })
                    ->hidden(fn () => ! PurchaseOrderHeader::where('code', '>', $this->record->code, 'and')->exists()),
            ])
                ->label('More')
                ->icon(Heroicon::OutlinedEllipsisVertical)
                ->tooltip('More action')
                ->button()
                ->color('gray'),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['doc_status'] = 'approved';

        $totalAmount = 0;
        $totalTax = 0;

        if (isset($data['details'])) {
            foreach ($data['details'] as $detail) {
                $amount = (float) str_replace(',', '', $detail['total_amount'] ?? 0);
                $tax = (float) str_replace(',', '', $detail['tax_amount'] ?? 0);

                $totalAmount += $amount;
                $totalTax += $tax;
            }
        }

        $data['total_amount'] = $totalAmount;
        $data['tax_amount'] = $totalTax;

        return $data;
    }
}
