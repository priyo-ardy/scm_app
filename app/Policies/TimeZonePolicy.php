<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\TimeZone;
use Illuminate\Auth\Access\HandlesAuthorization;

class TimeZonePolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:TimeZone');
    }

    public function view(AuthUser $authUser, TimeZone $timeZone): bool
    {
        return $authUser->can('View:TimeZone');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:TimeZone');
    }

    public function update(AuthUser $authUser, TimeZone $timeZone): bool
    {
        return $authUser->can('Update:TimeZone');
    }

    public function delete(AuthUser $authUser, TimeZone $timeZone): bool
    {
        return $authUser->can('Delete:TimeZone');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:TimeZone');
    }

    public function restore(AuthUser $authUser, TimeZone $timeZone): bool
    {
        return $authUser->can('Restore:TimeZone');
    }

    public function forceDelete(AuthUser $authUser, TimeZone $timeZone): bool
    {
        return $authUser->can('ForceDelete:TimeZone');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:TimeZone');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:TimeZone');
    }

    public function replicate(AuthUser $authUser, TimeZone $timeZone): bool
    {
        return $authUser->can('Replicate:TimeZone');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:TimeZone');
    }

}