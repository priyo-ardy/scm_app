<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Tonnage;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as AuthUser;

class TonnagePolicy
{
    use HandlesAuthorization;

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Tonnage');
    }

    public function view(AuthUser $authUser, Tonnage $tonnage): bool
    {
        return $authUser->can('View:Tonnage');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Tonnage');
    }

    public function update(AuthUser $authUser, Tonnage $tonnage): bool
    {
        return $authUser->can('Update:Tonnage');
    }

    public function delete(AuthUser $authUser, Tonnage $tonnage): bool
    {
        return $authUser->can('Delete:Tonnage');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:Tonnage');
    }

    public function restore(AuthUser $authUser, Tonnage $tonnage): bool
    {
        return $authUser->can('Restore:Tonnage');
    }

    public function forceDelete(AuthUser $authUser, Tonnage $tonnage): bool
    {
        return $authUser->can('ForceDelete:Tonnage');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Tonnage');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Tonnage');
    }

    public function replicate(AuthUser $authUser, Tonnage $tonnage): bool
    {
        return $authUser->can('Replicate:Tonnage');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Tonnage');
    }
}
