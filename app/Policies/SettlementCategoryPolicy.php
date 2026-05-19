<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\SettlementCategory;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as AuthUser;

class SettlementCategoryPolicy
{
    use HandlesAuthorization;

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:SettlementCategory');
    }

    public function view(AuthUser $authUser, SettlementCategory $settlementCategory): bool
    {
        return $authUser->can('View:SettlementCategory');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:SettlementCategory');
    }

    public function update(AuthUser $authUser, SettlementCategory $settlementCategory): bool
    {
        return $authUser->can('Update:SettlementCategory');
    }

    public function delete(AuthUser $authUser, SettlementCategory $settlementCategory): bool
    {
        return $authUser->can('Delete:SettlementCategory');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:SettlementCategory');
    }

    public function restore(AuthUser $authUser, SettlementCategory $settlementCategory): bool
    {
        return $authUser->can('Restore:SettlementCategory');
    }

    public function forceDelete(AuthUser $authUser, SettlementCategory $settlementCategory): bool
    {
        return $authUser->can('ForceDelete:SettlementCategory');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:SettlementCategory');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:SettlementCategory');
    }

    public function replicate(AuthUser $authUser, SettlementCategory $settlementCategory): bool
    {
        return $authUser->can('Replicate:SettlementCategory');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:SettlementCategory');
    }
}
