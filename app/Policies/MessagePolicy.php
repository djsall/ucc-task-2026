<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\Message;
use App\Models\User;

class MessagePolicy
{
    public function view(User $user, Message $message): bool
    {
        if ($user->role === UserRole::Helpdesk) {
            return true;
        }

        return $user->id === $message->user_id;
    }
}
