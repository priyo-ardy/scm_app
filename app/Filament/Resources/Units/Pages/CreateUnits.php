<?php

namespace App\Filament\Resources\Units\Pages;

use App\Filament\Resources\Units\UnitsResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;

class CreateUnits extends CreateRecord
{
    protected static string $resource = UnitsResource::class;

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
