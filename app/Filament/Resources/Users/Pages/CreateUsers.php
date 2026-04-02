<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UsersResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Contracts\Support\Htmlable;

class CreateUsers extends CreateRecord
{
    protected static string $resource = UsersResource::class;

    public function getHeading(): string|Htmlable|null
    {
        return 'Create New User';
    }
}
