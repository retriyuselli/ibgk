<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\PartnerCategory;
use Illuminate\Auth\Access\HandlesAuthorization;

class PartnerCategoryPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:PartnerCategory');
    }

    public function view(AuthUser $authUser, PartnerCategory $partnerCategory): bool
    {
        return $authUser->can('View:PartnerCategory');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:PartnerCategory');
    }

    public function update(AuthUser $authUser, PartnerCategory $partnerCategory): bool
    {
        return $authUser->can('Update:PartnerCategory');
    }

    public function delete(AuthUser $authUser, PartnerCategory $partnerCategory): bool
    {
        return $authUser->can('Delete:PartnerCategory');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:PartnerCategory');
    }

    public function restore(AuthUser $authUser, PartnerCategory $partnerCategory): bool
    {
        return $authUser->can('Restore:PartnerCategory');
    }

    public function forceDelete(AuthUser $authUser, PartnerCategory $partnerCategory): bool
    {
        return $authUser->can('ForceDelete:PartnerCategory');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:PartnerCategory');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:PartnerCategory');
    }

    public function replicate(AuthUser $authUser, PartnerCategory $partnerCategory): bool
    {
        return $authUser->can('Replicate:PartnerCategory');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:PartnerCategory');
    }

}