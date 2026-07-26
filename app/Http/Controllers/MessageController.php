<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Storage;
use Validator;

class MessageController extends Controller
{
    public function fetch_contacts()
    {
        $admin = auth()->user();
        $search = request()->search ?? "";

        $new_messages = DB::table("notifications")
            ->where("user_id", "=", $admin->id)
            ->where("is_read", "=", 0)
            ->where("type", "=", "new_message")
            ->get();

        $messages = DB::table("messages")
            ->where("sender_id", "=", $admin->id)
            ->orWhere("receiver_id", "=", $admin->id)
            ->get();

        $user_ids = [];
        $last_message = [];
        $last_message_date = [];
        $user_notifications = [];

        foreach ($messages as $message)
        {
            if ($message->sender_id == $admin->id)
            {
                $last_message[$message->receiver_id] = $message->message ?? "";
                $last_message_date[$message->receiver_id] = date("d M", strtotime($message->created_at)) ?? "";
                array_push($user_ids, $message->receiver_id);
            }
            else
            {
                $last_message[$message->sender_id] = $message->message ?? "";
                $last_message_date[$message->sender_id] = date("d M", strtotime($message->created_at)) ?? "";
                array_push($user_ids, $message->sender_id);
            }

            $user_notifications[$message->sender_id] = 0;
            foreach ($new_messages as $new_message)
            {
                if ($new_message->table_id == $message->id)
                {
                    $user_notifications[$message->sender_id]++;
                    break;
                }
            }
        }
        $user_ids = array_unique($user_ids);

        $users = DB::table("users")
            ->whereIn("id", $user_ids);

        if (!empty($search))
        {
            $users = $users->where(function ($query) use ($search) {
                $query->where("name", "LIKE", "%" . $search . "%")
                    ->orWhere("email", "LIKE", "%" . $search . "%")
                    ->orWhere("type", "=", $search);
            });
        }
        $users = $users->get();

        $users_arr = [];
        foreach ($users as $user)
        {
            $user_obj = [
                "id" => $user->id,
                "name" => $user->name,
                "email" => $user->email,
                "profile_image" => ($user->profile_image && Storage::exists("public/" . $user->profile_image)) ? url("/storage/" . $user->profile_image) : "",
                "last_message" => "",
                "last_message_date" => "",
                "user_notifications" => 0
            ];

            if (isset($last_message[$user->id]))
            {
                $user_obj["last_message"] = $last_message[$user->id];
            }

            if (isset($last_message_date[$user->id]))
            {
                $user_obj["last_message_date"] = $last_message_date[$user->id];
            }

            if (isset($user_notifications[$user->id]))
            {
                $user_obj["user_notifications"] = $user_notifications[$user->id];
            }

            array_push($users_arr, $user_obj);
        }

        return response()->json([
            "status" => "success",
            "message" => "Data has been fetched.",
            "users" => $users_arr
        ]);
    }

    public function buffer_attachment()
    {
        $user = auth()->user();
        $id = request()->id ?? 0;
        $token = request()->token ?? "";

        // Check token in the personal access tokens table (Sanctum example)
        // $token_record = DB::table("personal_access_tokens")
        //     ->where('token', hash('sha256', $token))
        //     ->first();

        try
        {
            // Parse the token using Sanctum's PersonalAccessToken model
            /*$token_record = PersonalAccessToken::findToken($token);

            if (!$token_record)
            {
                return response()->json([
                    "status" => "error",
                    "message" => "Invalid token"
                ], 401);
            }

            // Optionally check for token expiration
            if ($token_record->expires_at && $token_record->expires_at->isPast())
            {
                return response()->json([
                    "status" => "error",
                    "message" => "Token has expired"
                ], 401);
            }

            // Retrieve the associated user
            $user = $token_record->tokenable;*/

            $message_attachment = DB::table("message_attachments")
                ->join("messages", "messages.id", "=", "message_attachments.message_id")
                ->where("message_attachments.id", "=", $id)
                ->where(function ($query) use ($user) {
                    $query->where("sender_id", "=", $user->id)
                        ->orWhere("receiver_id", "=", $user->id);
                })
                ->first();

            if ($message_attachment == null)
            {
                return response()->json([
                    "status" => "error",
                    "message" => "Message not found."
                ], 404);
            }

            // Get the file's content
            $file_content = Storage::get("private/" . $message_attachment->path);

            // Render the file in the browser
            return response($file_content, 200, [
                "Content-Type" => $message_attachment->type
            ]);
        }
        catch (\Exception $e)
        {
            return response()->json([
                "status" => "error",
                "message" => $e->getMessage()
            ]);
        }
    }

    public function fetch_admin()
    {
        $validator = Validator::make(request()->all(), [
            "id" => "required"
        ]);

        if ($validator->fails())
        {
            return response()->json([
                "status" => "error",
                "message" => $validator->errors()->first()
            ]);
        }

        $admin = auth()->user();
        $id = request()->id ?? 0;
        $time_zone = request()->time_zone ?? "";
        if (!empty($time_zone))
        {
            $date_time_zone = new \DateTimeZone($time_zone);
        }

        $messages = DB::table("messages")
            ->select("messages.*", "sender.name AS sender_name",
                "message_attachments.id AS attachment_id", "message_attachments.path",
                "message_attachments.type", "message_attachments.name")
            ->leftJoin("message_attachments", "message_attachments.message_id", "=", "messages.id")
            ->join("users AS sender", "sender.id", "=", "messages.sender_id")
            ->where("sender_id", "=", $id)
            ->orWhere("receiver_id", "=", $id)
            ->orderBy("messages.id", "desc")
            ->get();

        $messages_arr = [];
        $message_ids = [];
        foreach ($messages as $message)
        {
            if (!empty($time_zone))
            {
                $date_time = new \DateTime($message->created_at);
                $date_time->setTimezone($date_time_zone);
                $message->created_at = $date_time->format("d M, Y h:i:s a");
            }

            $message_obj = [
                "id" => $message->id,
                "sender_id" => $message->sender_id,
                "sender_name" => $message->sender_name,
                "message" => $message->message ?? "",
                "attachments" => [],
                "created_at" => $message->created_at
            ];

            $index = -1;
            for ($a = 0; $a < count($messages_arr); $a++)
            {
                if ($messages_arr[$a]["id"] == $message->id)
                {
                    $index = $a;
                    break;
                }
            }

            $has_file = ($message->path && Storage::exists("/private/" . $message->path));
            $file_content = "";

            if ($has_file)
            {
                // $file_content = "data:" . $message->type . ";base64," . base64_encode(file_get_contents(storage_path("app/private/" . $message->path)));
                array_push($message_obj["attachments"], [
                    // "path" => $file_content,
                    "id" => $message->attachment_id ?? 0,
                    "name" => $message->name ?? "",
                    "type" => $message->type ?? ""
                ]);
            }

            if ($index > -1)
            {
                if ($has_file)
                {
                    array_push($messages_arr[$index]["attachments"], [
                        // "path" => $file_content,
                        "id" => $message->attachment_id ?? 0,
                        "name" => $message->name ?? "",
                        "type" => $message->type ?? ""
                    ]);
                }
            }
            else
            {
                array_push($messages_arr, (array) $message_obj);
                array_push($message_ids, $message->id);
            }
        }

        $notifications_count = 0;
        $notifications = DB::table("notifications")
            ->where("user_id", "=", $admin->id)
            ->where("type", "=", "new_message")
            ->whereIn("table_id", $message_ids)
            ->where("is_read", "=", 0);

        $notifications_count = $notifications->count();

        $notifications->update([
            "is_read" => 1,
            "updated_at" => now()
        ]);

        return response()->json([
            "status" => "success",
            "message" => "Data has been fetched.",
            "messages" => $messages_arr,
            "notifications_count" => $notifications_count
        ]);
    }

    public function fetch()
    {
        $user = auth()->user();
        $time_zone = request()->time_zone ?? "";
        if (!empty($time_zone))
        {
            $date_time_zone = new \DateTimeZone($time_zone);
        }

        $messages = DB::table("messages")
            ->select("messages.*", "message_attachments.id AS attachment_id",
                "message_attachments.path", "message_attachments.type",
                "message_attachments.name")
            ->leftJoin("message_attachments", "message_attachments.message_id", "=", "messages.id")
            ->where("messages.sender_id", "=", $user->id)
            ->orWhere("messages.receiver_id", "=", $user->id)
            ->orderBy("messages.id", "desc")
            ->paginate();

        $messages_arr = [];
        $message_ids = [];
        foreach ($messages as $message)
        {
            if (!empty($time_zone))
            {
                $date_time = new \DateTime($message->created_at);
                $date_time->setTimezone($date_time_zone);
                $message->created_at = $date_time->format("d M, Y h:i:s a");
            }

            $message_obj = [
                "id" => $message->id,
                "message" => $message->message ?? "",
                "sender_id" => $message->sender_id,
                "receiver_id" => $message->receiver_id,
                "attachments" => [],
                "created_at" => $message->created_at
            ];

            $index = -1;
            for ($a = 0; $a < count($messages_arr); $a++)
            {
                if ($messages_arr[$a]["id"] == $message->id)
                {
                    $index = $a;
                    break;
                }
            }

            $has_file = ($message->path && Storage::exists("/private/" . $message->path));
            $file_content = "";

            if ($has_file)
            {
                // $file_content = "data:" . $message->type . ";base64," . base64_encode(file_get_contents(storage_path("app/private/" . $message->path)));
                array_push($message_obj["attachments"], [
                    // "path" => $file_content,
                    "id" => $message->attachment_id ?? 0,
                    "name" => $message->name ?? "",
                    "type" => $message->type ?? ""
                ]);
            }

            if ($index > -1)
            {
                if ($has_file)
                {
                    array_push($messages_arr[$index]["attachments"], [
                        // "path" => $file_content,
                        "id" => $message->attachment_id ?? 0,
                        "name" => $message->name ?? "",
                        "type" => $message->type ?? ""
                    ]);
                }
            }
            else
            {
                array_push($messages_arr, (array) $message_obj);
                array_push($message_ids, $message->id);
            }
        }

        $notifications_count = DB::table("notifications")
            ->where("user_id", "=", $user->id)
            ->where("type", "=", "new_message")
            ->whereIn("table_id", $message_ids)
            ->where("is_read", "=", 0)
            ->count();

        return response()->json([
            "status" => "success",
            "message" => "Data has been fetched.",
            "messages" => $messages_arr,
            "notifications_count" => $notifications_count
        ]);
    }

    public function mark_as_read()
    {
        $user = auth()->user();

        $notifications = DB::table("notifications")
            ->where("user_id", "=", $user->id)
            ->where("type", "=", "new_message")
            ->where("is_read", "=", 0)
            ->update([
                "is_read" => 1,
                "updated_at" => now()->utc()
            ]);

        return response()->json([
            "status" => "success"
        ]);
    }

    public function send_admin()
    {
        $validator = Validator::make(request()->all(), [
            "id" => "required"
        ]);

        if ($validator->fails())
        {
            return response()->json([
                "status" => "error",
                "message" => $validator->errors()->first()
            ]);
        }

        $admin = auth()->user();

        $id = request()->id ?? 0;
        $message = request()->message ?? "";
        $time_zone = request()->time_zone ?? "";
        if (!empty($time_zone))
        {
            $date_time_zone = new \DateTimeZone($time_zone);
        }

        $user = DB::table("users")
            ->where("id", "=", $id)
            ->first();

        if ($user == null)
        {
            return response()->json([
                "status" => "error",
                "message" => "User not found."
            ]);
        }

        $message_arr = [
            "message" => $message,
            "sender_id" => $admin->id,
            "receiver_id" => $user->id,
            "created_at" => now()->utc(),
            "updated_at" => now()->utc()
        ];
        
        $message_arr["id"] = DB::table("messages")
            ->insertGetId($message_arr);

        if (!empty($time_zone))
        {
            $date_time = new \DateTime($message_arr["created_at"]);
            $date_time->setTimezone($date_time_zone);
            $message_arr["created_at"] = $date_time->format("d M, Y h:i:s a");
        }

        $message_arr["attachments"] = [];
        if (request()->file("attachments"))
        {
            foreach (request()->file("attachments") as $attachment)
            {
                $file_path = "messages/" . $message_arr["id"] . "/" . uniqid() . "." . $attachment->getClientOriginalExtension();
                $attachment->storeAs("/private", $file_path);

                // Get the full path to the folder
                $full_path = storage_path('app/private/messages');

                // Set permissions using PHP's chmod function
                chmod($full_path, 0775);

                // Get the full path to the folder
                $full_path = storage_path('app/private/messages/' . $message_arr["id"]);

                // Set permissions using PHP's chmod function
                chmod($full_path, 0775);

                $obj = [
                    "message_id" => $message_arr["id"],
                    "name" => $attachment->getClientOriginalName(),
                    "type" => $attachment->getClientMimeType(),
                    "path" => $file_path,
                    "size" => $attachment->getSize(),
                    "created_at" => now(),
                    "updated_at" => now()
                ];

                DB::table("message_attachments")
                    ->insertGetId($obj);

                // $file_content = "data:" . $obj["type"] . ";base64," . base64_encode(file_get_contents(storage_path("app/private/" . $file_path)));

                array_push($message_arr["attachments"], [
                    // "path" => $file_content,
                    "name" => $obj["name"],
                    "type" => $obj["type"]
                ]);
            }
        }

        DB::table("notifications")
            ->insertGetId([
                "user_id" => $user->id,
                "title" => "New message",
                "content" => "A new message has been received.",
                "type" => "new_message",
                "table_id" => $message_arr["id"],
                "is_read" => 0,
                "created_at" => now()->utc(),
                "updated_at" => now()->utc()
            ]);

        return response()->json([
            "status" => "success",
            "message" => "Message has been sent.",
            "message_obj" => (object) $message_arr
        ]);
    }

    public function send()
    {
        $user = auth()->user();
        $message = request()->message ?? "";
        $time_zone = request()->time_zone ?? "";
        if (!empty($time_zone))
        {
            $date_time_zone = new \DateTimeZone($time_zone);
        }

        $admin = DB::table("users")
            ->where("type", "=", "super_admin")
            ->first();

        if ($admin == null)
        {
            return response()->json([
                "status" => "error",
                "message" => "Admin not available."
            ]);
        }

        $message_arr = [
            "message" => $message,
            "sender_id" => $user->id,
            "receiver_id" => $admin->id,
            "created_at" => now()->utc(),
            "updated_at" => now()->utc()
        ];
        
        $message_arr["id"] = DB::table("messages")
            ->insertGetId($message_arr);

        if (!empty($time_zone))
        {
            $date_time = new \DateTime($message_arr["created_at"]);
            $date_time->setTimezone($date_time_zone);
            $message_arr["created_at"] = $date_time->format("d M, Y h:i:s a");
        }

        $message_arr["attachments"] = [];
        if (request()->file("attachments"))
        {
            foreach (request()->file("attachments") as $attachment)
            {
                $file_path = "messages/" . $message_arr["id"] . "/" . uniqid() . "." . $attachment->getClientOriginalExtension();
                $attachment->storeAs("/private", $file_path);

                // Get the full path to the folder
                $full_path = storage_path('app/private/messages');

                // Set permissions using PHP's chmod function
                chmod($full_path, 0775);

                // Get the full path to the folder
                $full_path = storage_path('app/private/messages/' . $message_arr["id"]);

                // Set permissions using PHP's chmod function
                chmod($full_path, 0775);

                $obj = [
                    "message_id" => $message_arr["id"],
                    "name" => $attachment->getClientOriginalName(),
                    "type" => $attachment->getClientMimeType(),
                    "path" => $file_path,
                    "size" => $attachment->getSize(),
                    "created_at" => now(),
                    "updated_at" => now()
                ];

                DB::table("message_attachments")
                    ->insertGetId($obj);

                // $file_content = "data:" . $obj["type"] . ";base64," . base64_encode(file_get_contents(storage_path("app/private/" . $file_path)));

                array_push($message_arr["attachments"], [
                    // "path" => $file_content,
                    "name" => $obj["name"],
                    "type" => $obj["type"]
                ]);
            }
        }

        DB::table("notifications")
            ->insertGetId([
                "user_id" => $admin->id,
                "title" => "New message",
                "content" => "You have received a new message from: " . $user->name,
                "type" => "new_message",
                "table_id" => $message_arr["id"],
                "is_read" => 0,
                "created_at" => now()->utc(),
                "updated_at" => now()->utc()
            ]);

        return response()->json([
            "status" => "success",
            "message" => "Message has been sent.",
            "message_obj" => (object) $message_arr
        ]);
    }

    public function index()
    {
        return view("admin/messages");
    }
}
