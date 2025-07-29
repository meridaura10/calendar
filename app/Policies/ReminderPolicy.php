<?php

namespace App\Policies;

use App\Models\Reminder;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ReminderPolicy
{
    public function checkAuthor(User $user, Reminder $reminder): bool
    {
        return $user->id === $reminder->user->id;
    }

    public function update(User $user, Reminder $reminder): bool
    {
        return $this->checkAuthor($user,$reminder);
    }

    public function destroy(User $user, Reminder $reminder): bool
    {
        return $this->checkAuthor($user,$reminder);
    }
}
