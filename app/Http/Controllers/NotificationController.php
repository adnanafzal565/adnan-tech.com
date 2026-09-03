<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function admin_index()
    {
        $notifications = auth()->user()
            ->notifications()
            ->orderBy("is_read", "asc")
            ->paginate(config("config.PER_PAGE"));

        auth()->user()
            ->notifications()
            ->where("is_read", 0)
            ->update([
                "is_read" => 1
            ]);

        return view("admin/notifications/index", [
            "notifications" => $notifications
        ]);
    }
}
