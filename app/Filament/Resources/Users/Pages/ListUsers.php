<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Exports\UsersExporter;
use App\Filament\Resources\Users\UsersResource;
use Filament\Actions\CreateAction;
use Filament\Actions\ExportAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

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

    public function getTabs(): array
    {
        $tabs = [];

        $tabs['all'] = Tab::make('All Users');

        $roles = Role::all();

        foreach ($roles as $role) {
            $label = Str::title(ucwords(str_replace('_', ' ', $role->name)));

            $tabs[$role->name] = Tab::make($label)
                ->modifyQueryUsing(fn (Builder $query) => $query->where('role', $role->id));
            // ->badge(fn() => \App\Models\User::where('role', $role->id)->count());
        }

        return $tabs;
    }
}
