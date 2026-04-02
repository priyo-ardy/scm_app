<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Exports\UsersExporter;
use App\Filament\Resources\Users\UsersResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions\ExportAction;
use Illuminate\Contracts\Support\Htmlable;

class ListUsers extends ListRecords
{
    protected static string $resource = UsersResource::class;

    public function getHeading(): string|Htmlable|null
    {
        return 'List of Users';
    }
    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->icon('heroicon-o-plus-circle'),
            ExportAction::make()
                ->exporter(UsersExporter::class)
                ->icon('heroicon-o-arrow-down-tray'),
        ];
    }
}
