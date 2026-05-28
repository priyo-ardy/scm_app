<?php

namespace App\Filament\Resources\PurchaseReceiptHeaders\Pages;

use App\Filament\Resources\PurchaseOrders\PurchaseOrderResource;
use App\Filament\Resources\PurchaseReceiptHeaders\PurchaseReceiptHeaderResource;
use App\Models\PurchaseOrderHeader;
use App\Models\PurchaseReceiptDetail;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Filament\Support\Icons\Heroicon;

class ViewPurchaseReceiptHeader extends ViewRecord
{
    protected static string $resource = PurchaseReceiptHeaderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('back')
                ->label('Back to list')
                ->color('gray')
                ->tooltip('Back to list')
                ->icon(Heroicon::OutlinedArrowLeft)
                ->url(static::getResource()::getUrl('index')),
            Action::make('new')
                ->label('New')
                ->icon(Heroicon::OutlinedPlusCircle)
                ->tooltip('New')
                ->color('success')
                ->url(static::getResource()::getUrl('create')),
            EditAction::make()
                ->label('Edit')
                ->tooltip('Edit')
                ->icon(Heroicon::OutlinedPencilSquare)
                ->visible(fn($record) => $record->doc_status == 'draft'),
            Action::make('approve')
                ->label('Approve')
                ->tooltip('Approve')
                ->icon(Heroicon::OutlinedCheck)
                ->color('success')
                ->action(function ($record) {
                    $record->update(['doc_status' => 'approved']);

                    Notification::make()
                        ->title('Approve Success')
                        ->body('This document successfully approved')
                        ->success()
                        ->send();
                })
                ->visible(fn($record) => $record->doc_status == 'draft'),
            Action::make('de-approve')
                ->label('De-Approve')
                ->tooltip('De-Approve')
                ->icon(Heroicon::OutlinedXMark)
                ->color('warning')
                ->action(function ($record) {
                    $record->update(['doc_status' => 'draft']);

                    Notification::make()
                        ->title('De-Approve Success')
                        ->success()
                        ->send();
                })
                ->visible(fn($record) => $record->doc_status == 'approved'),
            Action::make('print')
                ->label('Print')
                ->tooltip('Print')
                ->color('primary')
                ->visible(fn($record) => $record->doc_status == 'approved')
                ->icon(Heroicon::OutlinedPrinter)
                ->url(fn($record) => route('print.receipt', $record))
                ->openUrlInNewTab(),
            ActionGroup::make([
                ActionGroup::make([
                    Action::make('source')
                        ->label('Source Document')
                        ->icon(Heroicon::OutlinedDocument)
                        ->tooltip('Source document')
                        ->action(function ($record) {
                            $poId = PurchaseReceiptDetail::where('receipt_id', $record->id)->first();
                            // $sourceDocument = PurchaseOrderHeader::find($poId);

                            Notification::make()
                                ->title('ID PO')
                                ->body($poId)
                                ->success()
                                ->send();
                            // return $sourceDocument
                            //     ? PurchaseOrderResource::getUrl('view', ['record' => $sourceDocument])
                            //     : null;
                        })
                ])->dropdown(false),
                ActionGroup::make([
                    DeleteAction::make()
                        ->label('Delete')
                        ->icon(Heroicon::OutlinedTrash)
                        ->color('danger')
                        ->tooltip('Delete')
                        ->requiresConfirmation()
                ])
                    ->dropdown(false),
                ActionGroup::make([
                    Action::make('first')
                        ->label('First')
                        ->tooltip('Go to first data')
                        ->icon(Heroicon::OutlinedChevronDoubleLeft),
                    Action::make('prev')
                        ->label('Previous')
                        ->tooltip('Previous data')
                        ->icon(Heroicon::OutlinedChevronLeft),
                    Action::make('next')
                        ->label('Next')
                        ->tooltip('Next data')
                        ->icon(Heroicon::OutlinedChevronRight),
                    Action::make('last')
                        ->label('Last')
                        ->tooltip('Go to last data')
                        ->icon(Heroicon::OutlinedChevronDoubleRight),
                ])->dropdown(false)
            ])
                ->label('More Action')
                ->icon(Heroicon::OutlinedEllipsisVertical)
                ->color('gray')
                ->button()
                ->hiddenLabel()
        ];
    }
}
