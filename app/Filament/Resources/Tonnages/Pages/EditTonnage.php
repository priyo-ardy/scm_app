<?php

namespace App\Filament\Resources\Tonnages\Pages;

use App\Filament\Resources\Tonnages\TonnageResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTonnage extends EditRecord
{
    protected static string $resource = TonnageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
