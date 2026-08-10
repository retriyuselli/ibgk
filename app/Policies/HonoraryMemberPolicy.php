<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\HonoraryMember;
use Illuminate\Auth\Access\HandlesAuthorization;

class HonoraryMemberPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:HonoraryMember');
    }

    public function view(AuthUser $authUser, HonoraryMember $honoraryMember): bool
    {
        return $authUser->can('View:HonoraryMember');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:HonoraryMember');
    }

    public function update(AuthUser $authUser, HonoraryMember $honoraryMember): bool
    {
        return $authUser->can('Update:HonoraryMember');
    }

    public function delete(AuthUser $authUser, HonoraryMember $honoraryMember): bool
    {
        return $authUser->can('Delete:HonoraryMember');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:HonoraryMember');
    }

    public function restore(AuthUser $authUser, HonoraryMember $honoraryMember): bool
    {
        return $authUser->can('Restore:HonoraryMember');
    }

    public function forceDelete(AuthUser $authUser, HonoraryMember $honoraryMember): bool
    {
        return $authUser->can('ForceDelete:HonoraryMember');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:HonoraryMember');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:HonoraryMember');
    }

    public function replicate(AuthUser $authUser, HonoraryMember $honoraryMember): bool
    {
        return $authUser->can('Replicate:HonoraryMember');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:HonoraryMember');
    }

}