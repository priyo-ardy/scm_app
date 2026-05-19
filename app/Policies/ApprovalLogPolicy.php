<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\ApprovalLog;
use Illuminate\Auth\Access\HandlesAuthorization;

class ApprovalLogPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:ApprovalLog');
    }

    public function view(AuthUser $authUser, ApprovalLog $approvalLog): bool
    {
        return $authUser->can('View:ApprovalLog');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:ApprovalLog');
    }

    public function update(AuthUser $authUser, ApprovalLog $approvalLog): bool
    {
        return $authUser->can('Update:ApprovalLog');
    }

    public function delete(AuthUser $authUser, ApprovalLog $approvalLog): bool
    {
        return $authUser->can('Delete:ApprovalLog');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:ApprovalLog');
    }

    public function restore(AuthUser $authUser, ApprovalLog $approvalLog): bool
    {
        return $authUser->can('Restore:ApprovalLog');
    }

    public function forceDelete(AuthUser $authUser, ApprovalLog $approvalLog): bool
    {
        return $authUser->can('ForceDelete:ApprovalLog');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:ApprovalLog');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:ApprovalLog');
    }

    public function replicate(AuthUser $authUser, ApprovalLog $approvalLog): bool
    {
        return $authUser->can('Replicate:ApprovalLog');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:ApprovalLog');
    }

}