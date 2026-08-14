<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\OrganizationDivision;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrganizationDivisionPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:OrganizationDivision');
    }

    public function view(AuthUser $authUser, OrganizationDivision $organizationDivision): bool
    {
        return $authUser->can('View:OrganizationDivision');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:OrganizationDivision');
    }

    public function update(AuthUser $authUser, OrganizationDivision $organizationDivision): bool
    {
        return $authUser->can('Update:OrganizationDivision');
    }

    public function delete(AuthUser $authUser, OrganizationDivision $organizationDivision): bool
    {
        return $authUser->can('Delete:OrganizationDivision');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:OrganizationDivision');
    }

    public function restore(AuthUser $authUser, OrganizationDivision $organizationDivision): bool
    {
        return $authUser->can('Restore:OrganizationDivision');
    }

    public function forceDelete(AuthUser $authUser, OrganizationDivision $organizationDivision): bool
    {
        return $authUser->can('ForceDelete:OrganizationDivision');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:OrganizationDivision');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:OrganizationDivision');
    }

    public function replicate(AuthUser $authUser, OrganizationDivision $organizationDivision): bool
    {
        return $authUser->can('Replicate:OrganizationDivision');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:OrganizationDivision');
    }

}