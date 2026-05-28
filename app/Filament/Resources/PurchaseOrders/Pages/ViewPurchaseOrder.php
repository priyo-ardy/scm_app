<?php

namespace App\Filament\Resources\PurchaseOrders\Pages;

use App\Filament\Resources\PurchaseOrders\PurchaseOrderResource;
use App\Filament\Resources\PurchaseReceiptHeaders\PurchaseReceiptHeaderResource;
use App\Filament\Resources\PurchaseRequisitions\PurchaseRequisitionResource;
use App\Models\PurchaseOrderHeader;
use App\Models\PurchaseReceiptDetail;
use App\Models\PurchaseRequisitionHeader;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Filament\Support\Icons\Heroicon;

class ViewPurchaseOrder extends ViewRecord
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
            EditAction::make()
                ->icon(Heroicon::OutlinedPencilSquare)
                ->tooltip('Edit')
                ->visible(fn($record) => $record->doc_status !== 'approved'),
            Action::make('add')
                ->label('New')
                ->icon(Heroicon::OutlinedPlusCircle)
                ->tooltip('New')
                ->color('success')
                ->url(static::getResource()::getUrl('create')),
            DeleteAction::make()
                ->icon(Heroicon::OutlinedTrash)
                ->tooltip('Delete')
                ->label('Delete')
                ->color('danger')
                ->requiresConfirmation()
                ->modalHeading('Delete Confirmation')
                ->modalDescription('Are you sure you want to delete this record? This action cannot be undone.')
                ->modalSubmitActionLabel('Delete')
                ->visible(fn($record) => $record->doc_status !== 'approved'),
            Action::make('print')
                ->label('Print')
                ->icon(Heroicon::OutlinedPrinter)
                ->tooltip('Print')
                ->color('primary')
                ->url(fn($record) => route('print.po', $record))
                ->openUrlInNewTab()
                ->visible(fn($record) => $record->doc_status == 'approved'),
            // Action::make('generate')
            //     ->label('Generate')
            //     ->tooltip('Generate')
            //     ->icon(Heroicon::OutlinedCog8Tooth)
            //     ->color('primary')
            //     ->visible(fn($record) => $record->doc_status == 'approved'),
            Action::make('de-approve')
                ->label('De-Approve')
                ->tooltip('De-Approve')
                ->visible(fn($record) => $record->doc_status == 'approved')
                ->color('gray')
                ->icon(Heroicon::OutlinedArrowUturnDown)
                ->requiresConfirmation()
                ->action(function ($record) {
                    $record->update(['doc_status' => 'saved']);

                    Notification::make()
                        ->title('De-Approve Success')
                        ->body('This document successfully de-approve')
                        ->success()
                        ->send();
                }),
            Action::make('approve')
                ->label('Approve')
                ->tooltip('Approve')
                ->visible(fn($record) => $record->doc_status == 'saved')
                ->color('gray')
                ->icon(Heroicon::OutlinedCheck)
                ->action(function ($record) {
                    $record->update(['doc_status' => 'approved']);

                    Notification::make()
                        ->title('Approve Success')
                        ->body('This document successfully approve')
                        ->success()
                        ->send();
                }),
            ActionGroup::make([
                Action::make('source')
                    ->label('Source Document')
                    ->tooltip('Source document')
                    ->url(function () {
                        $sourceDocument = PurchaseRequisitionHeader::where('id', $this->record->purchase_requisition_id)->first();

                        return $sourceDocument
                            ? PurchaseRequisitionResource::getUrl('view', ['record' => $sourceDocument])
                            : null;
                    }),
                // Action::make('target')
                //     ->label('Target Document')
                //     ->tooltip('Target document')
                //     ->url(function () {
                //         $targetDocument = PurchaseReceiptDetail::where('po_id', $this->record->id)->first();

                //         return $targetDocument
                //             ? PurchaseReceiptHeaderResource::getUrl('list', ['record' => $targetDocument])
                //             : null;
                //     }),
            ])
                ->label('Associated Query')
                ->tooltip('Associated query')
                ->icon(Heroicon::OutlinedEllipsisVertical)
                ->button()
                ->color('gray'),
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
                    ->hidden(fn() => ! PurchaseOrderHeader::where('code', '<', $this->record->code, 'and')->exists()),
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
                    ->hidden(fn() => ! PurchaseOrderHeader::where('code', '>', $this->record->code, 'and')->exists()),
            ])
                ->label('More')
                ->icon(Heroicon::OutlinedEllipsisVertical)
                ->tooltip('More action')
                ->button()
                ->color('gray'),
        ];
    }
}
