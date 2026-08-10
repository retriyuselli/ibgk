<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\OrganizationProfile;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrganizationProfilePolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:OrganizationProfile');
    }

    public function view(AuthUser $authUser, OrganizationProfile $organizationProfile): bool
    {
        return $authUser->can('View:OrganizationProfile');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:OrganizationProfile');
    }

    public function update(AuthUser $authUser, OrganizationProfile $organizationProfile): bool
    {
        return $authUser->can('Update:OrganizationProfile');
    }

    public function delete(AuthUser $authUser, OrganizationProfile $organizationProfile): bool
    {
        return $authUser->can('Delete:OrganizationProfile');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:OrganizationProfile');
    }

    public function restore(AuthUser $authUser, OrganizationProfile $organizationProfile): bool
    {
        return $authUser->can('Restore:OrganizationProfile');
    }

    public function forceDelete(AuthUser $authUser, OrganizationProfile $organizationProfile): bool
    {
        return $authUser->can('ForceDelete:OrganizationProfile');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:OrganizationProfile');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:OrganizationProfile');
    }

    public function replicate(AuthUser $authUser, OrganizationProfile $organizationProfile): bool
    {
        return $authUser->can('Replicate:OrganizationProfile');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:OrganizationProfile');
    }

}