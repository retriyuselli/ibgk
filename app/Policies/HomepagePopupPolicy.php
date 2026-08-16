<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\HomepagePopup;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as AuthUser;

class HomepagePopupPolicy
{
    use HandlesAuthorization;

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:HomepagePopup');
    }

    public function view(AuthUser $authUser, HomepagePopup $homepagePopup): bool
    {
        return $authUser->can('View:HomepagePopup');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:HomepagePopup');
    }

    public function update(AuthUser $authUser, HomepagePopup $homepagePopup): bool
    {
        return $authUser->can('Update:HomepagePopup');
    }

    public function delete(AuthUser $authUser, HomepagePopup $homepagePopup): bool
    {
        return $authUser->can('Delete:HomepagePopup');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:HomepagePopup');
    }

    public function restore(AuthUser $authUser, HomepagePopup $homepagePopup): bool
    {
        return $authUser->can('Restore:HomepagePopup');
    }

    public function forceDelete(AuthUser $authUser, HomepagePopup $homepagePopup): bool
    {
        return $authUser->can('ForceDelete:HomepagePopup');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:HomepagePopup');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:HomepagePopup');
    }

    public function replicate(AuthUser $authUser, HomepagePopup $homepagePopup): bool
    {
        return $authUser->can('Replicate:HomepagePopup');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:HomepagePopup');
    }
}
