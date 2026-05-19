<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\PurchaseRequisitionHeader;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as AuthUser;

class PurchaseRequisitionHeaderPolicy
{
    use HandlesAuthorization;

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:PurchaseRequisitionHeader');
    }

    public function view(AuthUser $authUser, PurchaseRequisitionHeader $purchaseRequisitionHeader): bool
    {
        return $authUser->can('View:PurchaseRequisitionHeader');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:PurchaseRequisitionHeader');
    }

    public function update(AuthUser $authUser, PurchaseRequisitionHeader $purchaseRequisitionHeader): bool
    {
        return $authUser->can('Update:PurchaseRequisitionHeader');
    }

    public function delete(AuthUser $authUser, PurchaseRequisitionHeader $purchaseRequisitionHeader): bool
    {
        return $authUser->can('Delete:PurchaseRequisitionHeader');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:PurchaseRequisitionHeader');
    }

    public function restore(AuthUser $authUser, PurchaseRequisitionHeader $purchaseRequisitionHeader): bool
    {
        return $authUser->can('Restore:PurchaseRequisitionHeader');
    }

    public function forceDelete(AuthUser $authUser, PurchaseRequisitionHeader $purchaseRequisitionHeader): bool
    {
        return $authUser->can('ForceDelete:PurchaseRequisitionHeader');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:PurchaseRequisitionHeader');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:PurchaseRequisitionHeader');
    }

    public function replicate(AuthUser $authUser, PurchaseRequisitionHeader $purchaseRequisitionHeader): bool
    {
        return $authUser->can('Replicate:PurchaseRequisitionHeader');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:PurchaseRequisitionHeader');
    }
}
