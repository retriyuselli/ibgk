<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\ActivityCategory;
use Illuminate\Auth\Access\HandlesAuthorization;

class ActivityCategoryPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:ActivityCategory');
    }

    public function view(AuthUser $authUser, ActivityCategory $activityCategory): bool
    {
        return $authUser->can('View:ActivityCategory');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:ActivityCategory');
    }

    public function update(AuthUser $authUser, ActivityCategory $activityCategory): bool
    {
        return $authUser->can('Update:ActivityCategory');
    }

    public function delete(AuthUser $authUser, ActivityCategory $activityCategory): bool
    {
        return $authUser->can('Delete:ActivityCategory');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:ActivityCategory');
    }

    public function restore(AuthUser $authUser, ActivityCategory $activityCategory): bool
    {
        return $authUser->can('Restore:ActivityCategory');
    }

    public function forceDelete(AuthUser $authUser, ActivityCategory $activityCategory): bool
    {
        return $authUser->can('ForceDelete:ActivityCategory');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:ActivityCategory');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:ActivityCategory');
    }

    public function replicate(AuthUser $authUser, ActivityCategory $activityCategory): bool
    {
        return $authUser->can('Replicate:ActivityCategory');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:ActivityCategory');
    }

}