<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\PurchasePriceHeader;
use Illuminate\Auth\Access\HandlesAuthorization;

class PurchasePriceHeaderPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:PurchasePriceHeader');
    }

    public function view(AuthUser $authUser, PurchasePriceHeader $purchasePriceHeader): bool
    {
        return $authUser->can('View:PurchasePriceHeader');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:PurchasePriceHeader');
    }

    public function update(AuthUser $authUser, PurchasePriceHeader $purchasePriceHeader): bool
    {
        return $authUser->can('Update:PurchasePriceHeader');
    }

    public function delete(AuthUser $authUser, PurchasePriceHeader $purchasePriceHeader): bool
    {
        return $authUser->can('Delete:PurchasePriceHeader');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:PurchasePriceHeader');
    }

    public function restore(AuthUser $authUser, PurchasePriceHeader $purchasePriceHeader): bool
    {
        return $authUser->can('Restore:PurchasePriceHeader');
    }

    public function forceDelete(AuthUser $authUser, PurchasePriceHeader $purchasePriceHeader): bool
    {
        return $authUser->can('ForceDelete:PurchasePriceHeader');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:PurchasePriceHeader');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:PurchasePriceHeader');
    }

    public function replicate(AuthUser $authUser, PurchasePriceHeader $purchasePriceHeader): bool
    {
        return $authUser->can('Replicate:PurchasePriceHeader');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:PurchasePriceHeader');
    }

}