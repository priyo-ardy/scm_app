<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\PurchaseReceiptHeader;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as AuthUser;

class PurchaseReceiptHeaderPolicy
{
    use HandlesAuthorization;

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:PurchaseReceiptHeader');
    }

    public function view(AuthUser $authUser, PurchaseReceiptHeader $purchaseReceiptHeader): bool
    {
        return $authUser->can('View:PurchaseReceiptHeader');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:PurchaseReceiptHeader');
    }

    public function update(AuthUser $authUser, PurchaseReceiptHeader $purchaseReceiptHeader): bool
    {
        return $authUser->can('Update:PurchaseReceiptHeader');
    }

    public function delete(AuthUser $authUser, PurchaseReceiptHeader $purchaseReceiptHeader): bool
    {
        return $authUser->can('Delete:PurchaseReceiptHeader');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:PurchaseReceiptHeader');
    }

    public function restore(AuthUser $authUser, PurchaseReceiptHeader $purchaseReceiptHeader): bool
    {
        return $authUser->can('Restore:PurchaseReceiptHeader');
    }

    public function forceDelete(AuthUser $authUser, PurchaseReceiptHeader $purchaseReceiptHeader): bool
    {
        return $authUser->can('ForceDelete:PurchaseReceiptHeader');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:PurchaseReceiptHeader');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:PurchaseReceiptHeader');
    }

    public function replicate(AuthUser $authUser, PurchaseReceiptHeader $purchaseReceiptHeader): bool
    {
        return $authUser->can('Replicate:PurchaseReceiptHeader');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:PurchaseReceiptHeader');
    }
}
