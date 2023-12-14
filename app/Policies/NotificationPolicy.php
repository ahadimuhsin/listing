<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Notifications\DatabaseNotification;

class NotificationPolicy
{
    use HandlesAuthorization;
    /**
     * Create a new policy instance.
     */
    //hanya yg id usernya sama yg bisa melakukan update
    public function update(User $user, DatabaseNotification $databaseNotification)
    {
        return $user->id === $databaseNotification->notifiable_id;
    }
}
