<?php

namespace App\Filament\Resources\SetllementCategories\Pages;

use App\Filament\Resources\SetllementCategories\SetllementCategoryResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;

class CreateSetllementCategory extends CreateRecord
{
    protected static string $resource = SetllementCategoryResource::class;

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
