<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Validator;

class NotificationController extends Controller
{
    public function mark_as_unread(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "id" => "required"
        ]);

        if ($validator->fails())
        {
            return response()->json([
                "status" => "error",
                "message" => $validator->errors()->first()
            ]);
        }

        auth()->user()
            ->notifications()
            ->where("id", $request->id)
            ->where("is_read", 1)
            ->update([
                "is_read" => 0
            ]);

        return response()->json([
            "status" => "success",
            "message" => "Notification has been marked as unread."
        ]);
    }

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
