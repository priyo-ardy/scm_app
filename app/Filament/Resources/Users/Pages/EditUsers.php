<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UsersResource;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Icons\Heroicon;
use Illuminate\Contracts\Support\Htmlable;

class EditUsers extends EditRecord
{
    protected static string $resource = UsersResource::class;

    public function getHeading(): string|Htmlable|null
    {
        return 'Edit User';
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('back')
                ->label('back to List')
                ->icon(Heroicon::OutlinedArrowLeft)
                ->color('gray')
                ->url(static::getResource()::getUrl('index')),
            Action::make('add')
                ->label('New')
                ->icon(Heroicon::OutlinedPlusCircle)
                ->color('success')
                ->url(static::getResource()::getUrl('create')),
            DeleteAction::make()->icon(Heroicon::OutlinedTrash),
            ForceDeleteAction::make()->icon(Heroicon::OutlinedXMark),
            RestoreAction::make(),
            Action::make('first')
                ->label('First')
                ->color('gray')
                ->icon(Heroicon::OutlinedChevronDoubleLeft)
                ->url(function () {
                    $currentRecord = $this->record;

                    if (! $currentRecord instanceof User) {
                        return null;
                    }

                    $firstRecord = User::orderBy('id', 'asc')->first();

                    return ($firstRecord && $firstRecord->id !== $currentRecord->id)
                        ? UsersResource::getUrl('edit', ['record' => $firstRecord->id])
                        : null;
                })
                ->disabled(function () {
                    $currentRecord = $this->record;
                    if (! $currentRecord instanceof User) {
                        return true;
                    }

                    return ! User::where('id', '<', $currentRecord->id)->exists();
                }),
            Action::make('prev')
                ->label('Prev')
                ->color('gray')
                ->icon(Heroicon::OutlinedChevronLeft)
                ->url(function () {
                    $currentRecord = $this->record;

                    if (! $currentRecord instanceof User) {
                        return null;
                    }

                    $prevRecord = User::where('id', '<', $currentRecord->id)
                        ->orderBy('id', 'desc')
                        ->first();

                    return $prevRecord
                        ? UsersResource::getUrl('edit', ['record' => $prevRecord->id])
                        : null;
                })
                ->hidden(function () {
                    $currentRecord = $this->record;
                    if (! $currentRecord instanceof User) {
                        return true;
                    }

                    return ! User::where('id', '<', $currentRecord->id)->exists();
                }),
            Action::make('next')
                ->label('Next')
                ->icon(Heroicon::OutlinedChevronRight)
                ->color('gray')
                ->url(function () {
                    $currentRecord = $this->record;

                    if (! $currentRecord instanceof User) {
                        return null;
                    }

                    $prevRecord = User::where('id', '>', $currentRecord->id)
                        ->orderBy('id', 'asc')
                        ->first();

                    return $prevRecord
                        ? UsersResource::getUrl('edit', ['record' => $prevRecord->id])
                        : null;
                })
                ->hidden(function () {
                    $currentRecord = $this->record;
                    if (! $currentRecord instanceof User) {
                        return true;
                    }

                    return ! User::where('id', '>', $currentRecord->id)->exists();
                }),
            Action::make('last')
                ->label('Last')
                ->color('gray')
                ->icon(Heroicon::OutlinedChevronDoubleRight)
                ->url(function () {
                    $currentRecord = $this->record;

                    // PERBAIKAN: Tambah tanda ! (Jika BUKAN User)
                    if (! $currentRecord instanceof User) {
                        return null;
                    }

                    $lastRecord = User::orderBy('id', 'desc')->first();

                    // PERBAIKAN: Gunakan $currentRecord->id, jangan $this->record->id
                    return ($lastRecord && $lastRecord->id !== $currentRecord->id)
                        ? UsersResource::getUrl('edit', ['record' => $lastRecord])
                        : null;
                })
                ->disabled(function () {
                    $currentRecord = $this->record;

                    if (! $currentRecord instanceof User) {
                        return true;
                    }

                    // Cek apakah ada record dengan ID yang lebih besar dari sekarang
                    return ! User::where('id', '>', $currentRecord->id)->exists();
                }),
        ];
    }
}
