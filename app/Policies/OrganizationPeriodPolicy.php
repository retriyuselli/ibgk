<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\OrganizationPeriod;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrganizationPeriodPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:OrganizationPeriod');
    }

    public function view(AuthUser $authUser, OrganizationPeriod $organizationPeriod): bool
    {
        return $authUser->can('View:OrganizationPeriod');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:OrganizationPeriod');
    }

    public function update(AuthUser $authUser, OrganizationPeriod $organizationPeriod): bool
    {
        return $authUser->can('Update:OrganizationPeriod');
    }

    public function delete(AuthUser $authUser, OrganizationPeriod $organizationPeriod): bool
    {
        return $authUser->can('Delete:OrganizationPeriod');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:OrganizationPeriod');
    }

    public function restore(AuthUser $authUser, OrganizationPeriod $organizationPeriod): bool
    {
        return $authUser->can('Restore:OrganizationPeriod');
    }

    public function forceDelete(AuthUser $authUser, OrganizationPeriod $organizationPeriod): bool
    {
        return $authUser->can('ForceDelete:OrganizationPeriod');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:OrganizationPeriod');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:OrganizationPeriod');
    }

    public function replicate(AuthUser $authUser, OrganizationPeriod $organizationPeriod): bool
    {
        return $authUser->can('Replicate:OrganizationPeriod');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:OrganizationPeriod');
    }

}