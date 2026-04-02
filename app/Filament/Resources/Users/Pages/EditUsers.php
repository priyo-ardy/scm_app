<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UsersResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Contracts\Support\Htmlable;

class EditUsers extends EditRecord
{
    protected static string $resource = UsersResource::class;

    public function getHeading(): string|Htmlable|null
    {
        return 'Edit User';
    }
    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
