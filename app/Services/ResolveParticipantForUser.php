<?php

namespace App\Services;

use App\Models\Participant;
use App\Models\User;

class ResolveParticipantForUser
{
    public function handle(User $user): ?Participant
    {
        $participant = Participant::query()
            ->with(['election.stages', 'currentStage'])
            ->where('user_id', $user->id)
            ->latest('id')
            ->first();

        if ($participant) {
            return $participant;
        }

        $participant = Participant::query()
            ->with(['election.stages', 'currentStage'])
            ->whereNull('user_id')
            ->where('email', $user->email)
            ->latest('id')
            ->first();

        if ($participant) {
            $participant->forceFill(['user_id' => $user->id])->save();
        }

        return $participant;
    }
}
