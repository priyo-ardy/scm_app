<?php

namespace App\Filament\Resources\Units\Pages;

use App\Filament\Resources\Units\UnitsResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditUnits extends EditRecord
{
    protected static string $resource = UnitsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
