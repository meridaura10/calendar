<?php

namespace App\Policies;

use App\Models\Event;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class EventPolicy
{
    public function checkAuthor(User $user, Event $event): bool
    {
        return $user->id === $event->user->id;
    }

    public function update(User $user, Event $event): bool
    {
        return $this->checkAuthor($user,$event);
    }

    public function destroy(User $user, Event $event): bool
    {
        return $this->checkAuthor($user,$event);
    }
}
