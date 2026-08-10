<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\PartnershipInquiry;
use Illuminate\Auth\Access\HandlesAuthorization;

class PartnershipInquiryPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:PartnershipInquiry');
    }

    public function view(AuthUser $authUser, PartnershipInquiry $partnershipInquiry): bool
    {
        return $authUser->can('View:PartnershipInquiry');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:PartnershipInquiry');
    }

    public function update(AuthUser $authUser, PartnershipInquiry $partnershipInquiry): bool
    {
        return $authUser->can('Update:PartnershipInquiry');
    }

    public function delete(AuthUser $authUser, PartnershipInquiry $partnershipInquiry): bool
    {
        return $authUser->can('Delete:PartnershipInquiry');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:PartnershipInquiry');
    }

    public function restore(AuthUser $authUser, PartnershipInquiry $partnershipInquiry): bool
    {
        return $authUser->can('Restore:PartnershipInquiry');
    }

    public function forceDelete(AuthUser $authUser, PartnershipInquiry $partnershipInquiry): bool
    {
        return $authUser->can('ForceDelete:PartnershipInquiry');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:PartnershipInquiry');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:PartnershipInquiry');
    }

    public function replicate(AuthUser $authUser, PartnershipInquiry $partnershipInquiry): bool
    {
        return $authUser->can('Replicate:PartnershipInquiry');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:PartnershipInquiry');
    }

}