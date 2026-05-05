<?php

namespace App\Filament\Resources\ApprovalLogs\Pages;

use App\Filament\Resources\ApprovalLogs\ApprovalLogResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewApprovalLog extends ViewRecord
{
    protected static string $resource = ApprovalLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
