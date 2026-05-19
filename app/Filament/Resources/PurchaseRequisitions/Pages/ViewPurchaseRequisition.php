<?php

namespace App\Filament\Resources\PurchaseRequisitions\Pages;

use App\Filament\Resources\PurchaseOrders\PurchaseOrderResource;
use App\Filament\Resources\PurchaseRequisitions\PurchaseRequisitionResource;
use App\Models\PurchaseOrderHeader;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Auth;

class ViewPurchaseRequisition extends ViewRecord
{
    protected static string $resource = PurchaseRequisitionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('back')
                ->label('Back to list')
                ->icon(Heroicon::OutlinedArrowLeft)
                ->tooltip('Back to list')
                ->color('gray')
                ->url(static::getResource()::getUrl('index')),
            Action::make('add')
                ->label('New')
                ->tooltip('New')
                ->icon(Heroicon::OutlinedPlusCircle)
                ->color('success')
                ->url(fn () => $this->getResource()::getUrl('create')),
            EditAction::make()
                ->label('Edit')
                ->icon(Heroicon::OutlinedPencilSquare)
                ->tooltip('Edit')
                ->visible(fn ($record) => in_array($record->doc_status, ['draft', 'saved'])),
            Action::make('approve')
                ->label('Approve')
                ->icon(Heroicon::OutlinedCheck)
                ->tooltip('Approve')
                ->action(function ($record) {
                    $record->update([
                        'doc_status' => 'approved',
                        'approved_by' => Auth::id(),
                        'approved_at' => now(),
                    ]);

                    Notification::make()
                        ->title('Approval Success')
                        ->success()
                        ->send();
                })
                ->button()
                ->visible(fn ($record) => in_array($record->doc_status, ['saved'])),
            Action::make('reject')
                ->label('Reject')
                ->icon(Heroicon::OutlinedXMark)
                ->color('danger')
                ->tooltip('Reject')
                ->schema([
                    Textarea::make('reject_reason')
                        ->label('Reject Reason')
                        ->placeholder('Write description here')
                        ->required(), // Wajib diisi agar alasan reject jelas
                ])
                ->modalHeading('Reject Purchase Requisition')
                ->modalSubmitActionLabel('Reject')
                ->action(function (array $data, $record): void {
                    $record->update([
                        'doc_status' => 'rejected',
                        'reject_date' => now(),
                        'reject_reason' => $data['reject_reason'],
                        'rejected_by' => Auth::id(),
                    ]);

                    Notification::make()
                        ->title('Document Rejected Successfully')
                        ->success()
                        ->send();
                })
                ->visible(fn ($record) => $record->doc_status === 'saved'),
            Action::make('generate')
                ->label('Generate PO')
                ->icon(Heroicon::OutlinedCog6Tooth)
                ->color('primary')
                ->tooltip('Generate Purchase Order')
                ->requiresConfirmation()
                ->modalHeading('Generate Purchase Order')
                ->modalDescription('Are you sure you want to create a purchase order from this document?')
                ->modalSubmitActionLabel('Generate')
                ->url(fn ($record): string => PurchaseOrderResource::getUrl('create', [
                    'source_id' => $record->id,
                ]))
                ->visible(fn ($record) => $record->doc_status === 'approved'),
            Action::make('deApprove')
                ->label('De-Approve')
                ->icon(Heroicon::OutlinedArrowUturnDown)
                ->tooltip('De-Approve')
                ->color('warning')
                ->action(function ($record) {
                    $record->update([
                        'doc_status' => 'saved',
                        'approved_by' => null,
                        'approved_at' => null,
                    ]);
                })
                ->visible(fn ($record) => $record->doc_status === 'approved'),
            ActionGroup::make([
                Action::make('target')
                    ->label('Target Document')
                    ->tooltip('Target document')
                    ->url(function () {
                        $targetDocument = PurchaseOrderHeader::where('purchase_requisition_id', $this->record->id)->first();

                        return $targetDocument
                            ? PurchaseOrderResource::getUrl('view', ['record' => $targetDocument])
                            : null;
                    }),
            ])
                ->label('Associated Query')
                ->color('gray')
                ->tooltip('Associated query')
                ->icon(Heroicon::OutlinedEllipsisVertical)
                ->button(),
            ActionGroup::make([
                Action::make('print')
                    ->label('Print')
                    ->tooltip('Print')
                    ->icon(Heroicon::OutlinedPrinter)
                    ->url(fn ($record) => route('print.pr', $record))
                    ->openUrlInNewTab()
                    ->color('gray')
                    ->visible(fn ($record) => $record->doc_status === 'approved'),
                DeleteAction::make()->label('Delete')->tooltip('Delete')->icon(Heroicon::OutlinedTrash)->visible(fn ($record) => in_array($record->doc_status, ['draft', 'saved'])),
                Action::make('prev')
                    ->label('Previous')
                    ->icon(Heroicon::OutlinedChevronLeft)
                    ->tooltip('Prevoius Data')
                    ->color('gray'),
                Action::make('next')
                    ->label('Next')
                    ->icon(Heroicon::OutlinedChevronRight)
                    ->tooltip('Next Data')
                    ->color('gray'),
            ])
                ->label('More actions')
                ->color('gray')
                ->button(),
        ];
    }
}
