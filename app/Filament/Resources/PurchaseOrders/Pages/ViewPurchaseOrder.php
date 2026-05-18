<?php

namespace App\Filament\Resources\PurchaseOrders\Pages;

use App\Filament\Resources\PurchaseOrders\PurchaseOrderResource;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
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
                ->tooltip('Edit'),
            Action::make('add')
                ->label('New')
                ->icon(Heroicon::OutlinedPlusCircle)
                ->tooltip('New')
                ->color('success')
                ->url(static::getResource()::getUrl('create')),
            Action::make('print')
                ->label('Print')
                ->icon(Heroicon::OutlinedPrinter)
                ->tooltip('Print')
                ->color('primary')
                ->url(fn($record) => route('print.po', $record))
                ->openUrlInNewTab(),
            Action::make('generate')
                ->label('Generate')
                ->tooltip('Generate')
                ->icon(Heroicon::OutlinedCog8Tooth)
                ->color('primary'),
            ActionGroup::make([
                Action::make('source')
                    ->label('Source Document')
                    ->tooltip('Source document'),
                Action::make('target')
                    ->label('Target Document')
                    ->tooltip('Target document')
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
                    ->tooltip('Previous page'),
                Action::make('next')
                    ->label('Next Page')
                    ->icon(Heroicon::OutlinedChevronRight)
                    ->tooltip('Next page'),
                DeleteAction::make('Delete')
                    ->icon(Heroicon::OutlinedTrash)
                    ->tooltip('Delete')
                    ->color('danger')
                    ->requiresConfirmation(),
            ])
                ->label('More')
                ->icon(Heroicon::OutlinedEllipsisVertical)
                ->tooltip('More action')
                ->button()
                ->color('gray')
        ];
    }
}
