<?php

namespace App\Filament\Resources\PurchasePriceHeaders\Pages;

use App\Filament\Resources\PurchasePriceHeaders\PurchasePriceHeaderResource;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Icons\Heroicon;
use Psy\Readline\Interactive\Actions\PreviousHistoryAction;

class EditPurchasePriceHeader extends EditRecord
{
    protected static string $resource = PurchasePriceHeaderResource::class;
    public bool $isEditingEnabled = false;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('back')
                ->label('Back to list')
                ->icon(Heroicon::OutlinedArrowLeft)
                ->tooltip('Back to list')
                ->color('gray')
                ->url(fn() => $this->getResource()::getUrl('index')),
            Action::make('new')
                ->label('New')
                ->icon(Heroicon::OutlinedPlusCircle)
                ->tooltip('New')
                ->color('success')
                ->url(fn() => $this->getResource()::getUrl('create')),
            Action::make('enableEdit')
                ->label('Edit')
                ->icon(Heroicon::OutlinedPencilSquare)
                ->tooltip('Edit')
                ->action(fn() => $this->isEditingEnabled = true)
                ->hidden(fn() => $this->isEditingEnabled),
            Action::make('undoEdit')
                ->label('Undo')
                ->icon(Heroicon::OutlinedArrowUturnLeft)
                ->color('gray')
                ->action(function () {
                    $this->fillForm();
                    $this->isEditingEnabled = false;
                })
                ->visible(fn() => $this->isEditingEnabled)
                ->tooltip('Undo'),
            Action::make('approve')
                ->label('Approve')
                ->color('warning')
                ->tooltip('Approve')
                ->icon(Heroicon::OutlinedCheck)
                ->visible(fn() => $this->record->doc_status == 'saved' && !$this->isEditingEnabled)
                ->action(function () {
                    $this->record->update(
                        ['doc_status' => 'approved']
                    );

                    Notification::make()
                        ->title('Approval Notification')
                        ->body('Approval purchase price successfully')
                        ->success()
                        ->send();
                })
                ->requiresConfirmation()
                ->modalHeading('Approval Confirmation')
                ->modalDescription('Are you sure you want to approve this transaction?')
                ->modalSubmitActionLabel('Approve')
                ->modalIcon(Heroicon::OutlinedCheck),
            DeleteAction::make()
                ->label('Delete')
                ->icon(Heroicon::OutlinedTrash)
                ->tooltip('Delete')
                ->visible(fn() => in_array($this->record->doc_status, ['draft', 'saved']) && !$this->isEditingEnabled),
            ActionGroup::make([
                Action::make('first')
                    ->label('First Data')
                    ->icon(Heroicon::OutlinedChevronDoubleLeft),
                Action::make('Prev')
                    ->label('Previous Data')
                    ->icon(Heroicon::OutlinedChevronLeft),
                Action::make('next')
                    ->label('Next Data')
                    ->icon(Heroicon::OutlinedChevronRight),
                Action::make('last')
                    ->label('Last Data')
                    ->icon(Heroicon::OutlinedChevronDoubleRight),
                Action::make('print')
                    ->label('Print')
                    ->icon(Heroicon::OutlinedPrinter),
                Action::make('flow')
                    ->label('Show Current Flow')
                    ->icon(Heroicon::OutlinedPuzzlePiece),
            ])
                // ->label('More Action')
                ->label('')
                ->icon(Heroicon::OutlinedEllipsisVertical)
                ->tooltip('More Action')
                ->color('gray')
                ->button()
            // ->visible(fn() => !$this->isEditingEnabled),
        ];
    }

    public function isFormDisabled(): bool
    {
        return !$this->isEditingEnabled;
    }

    protected function getFormActions(): array
    {
        // Jika sedang tidak dalam mode edit, sembunyikan semua tombol form (Save & Cancel)
        if (! $this->isEditingEnabled) {
            return [];
        }

        // Jika sedang dalam mode edit, tampilkan tombol bawaan Filament
        return parent::getFormActions();
    }
}
