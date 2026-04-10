<?php

namespace App\Filament\Resources\Equipments\Pages;

use App\Filament\Resources\Equipments\EquipmentsResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditEquipments extends EditRecord
{
    protected static string $resource = EquipmentsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
