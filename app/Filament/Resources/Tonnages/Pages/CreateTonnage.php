<?php

namespace App\Filament\Resources\Tonnages\Pages;

use App\Filament\Resources\Tonnages\TonnageResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;

class CreateTonnage extends CreateRecord
{
    protected static string $resource = TonnageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('back')
                ->label('Back to List')
                ->icon('heroicon-m-arrow-left')
                ->color('gray')
                ->url(static::getResource()::getUrl('index')),
        ];
    }
}
