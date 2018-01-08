<?php

namespace App\Http\Controllers;

use App\User;

class UserNotificationsController extends Controller
{
    public function index(User $user)
    {
        return auth()->user()->unreadNotifications;
    }

    public function destroy(User $user, $notificationId)
    {
        auth()->user()->notifications()->findOrFail($notificationId)->markAsread();
    }
}
