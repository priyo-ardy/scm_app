<?php

namespace App\Filament\Resources\ApprovalLogs\Pages;

use App\Filament\Resources\ApprovalLogs\ApprovalLogResource;
use Filament\Resources\Pages\CreateRecord;

class CreateApprovalLog extends CreateRecord
{
    protected static string $resource = ApprovalLogResource::class;
}
