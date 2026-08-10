<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\AlumniBatch;
use Illuminate\Auth\Access\HandlesAuthorization;

class AlumniBatchPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:AlumniBatch');
    }

    public function view(AuthUser $authUser, AlumniBatch $alumniBatch): bool
    {
        return $authUser->can('View:AlumniBatch');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:AlumniBatch');
    }

    public function update(AuthUser $authUser, AlumniBatch $alumniBatch): bool
    {
        return $authUser->can('Update:AlumniBatch');
    }

    public function delete(AuthUser $authUser, AlumniBatch $alumniBatch): bool
    {
        return $authUser->can('Delete:AlumniBatch');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:AlumniBatch');
    }

    public function restore(AuthUser $authUser, AlumniBatch $alumniBatch): bool
    {
        return $authUser->can('Restore:AlumniBatch');
    }

    public function forceDelete(AuthUser $authUser, AlumniBatch $alumniBatch): bool
    {
        return $authUser->can('ForceDelete:AlumniBatch');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:AlumniBatch');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:AlumniBatch');
    }

    public function replicate(AuthUser $authUser, AlumniBatch $alumniBatch): bool
    {
        return $authUser->can('Replicate:AlumniBatch');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:AlumniBatch');
    }

}