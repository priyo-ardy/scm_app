<?php

namespace App\Filament\Resources\ApprovalLogs\Pages;

use App\Filament\Resources\ApprovalLogs\ApprovalLogResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListApprovalLogs extends ListRecords
{
    protected static string $resource = ApprovalLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
