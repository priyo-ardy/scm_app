<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UsersResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Icons\Heroicon;
use Illuminate\Contracts\Support\Htmlable;

class CreateUsers extends CreateRecord
{
    protected static string $resource = UsersResource::class;

    public function getHeading(): string|Htmlable|null
    {
        return 'Create New User';
    }

    public function getHeaderActions(): array
    {
        return [
            Action::make('back')
                ->label('Back to List')
                ->icon(Heroicon::OutlinedArrowLeft)
                ->color('gray')
                ->url(static::getResource()::getUrl('index')),
        ];
    }
}
