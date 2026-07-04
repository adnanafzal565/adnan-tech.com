<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Storage;
use Validator;

class SettingsController extends Controller
{
    public function save()
    {
        $admin = auth()->user();

        $host = request()->host ?? "";
        $port = request()->port ?? "";
        $encryption = request()->encryption ?? "";
        $username = request()->username ?? "";
        $password = request()->password ?? "";
        $from = request()->from ?? "";
        $from_name = request()->from_name ?? "";
        $verify_email = request()->verify_email ?? "";
        $title = request()->title ?? "";
        $logo = request()->file("logo");

        if ($logo)
        {
            if (!str_starts_with($logo->getClientMimeType(), 'image/'))
            {
                return response()->json([
                    "status" => "error",
                    "message" => "Logo must be an image."
                ]);
            }

            $file_path = "logo-" . str_replace_all($title, " ", "-") . "." . $logo->getClientOriginalExtension();
            $logo->storeAs("public", $file_path);

            $this->set_setting("logo", $file_path);
        }

        set_setting("verify_email", $verify_email);
        set_setting("smtp_host", $host);
        set_setting("smtp_port", $port);
        set_setting("smtp_encryption", $encryption);
        set_setting("smtp_username", $username);
        set_setting("smtp_password", $password);
        set_setting("smtp_from", $from);
        set_setting("smtp_from_name", $from_name);
        set_setting("title", $title);

        return response()->json([
            "status" => "success",
            "message" => "Settings has been saved."
        ]);
    }

    public function index()
    {
        $settings = DB::table("settings")->get();

        $settings_arr = [];
        foreach ($settings as $setting)
        {
            $settings_arr[$setting->key ?? ""] = $setting->value ?? "";
        }

        return view("admin/settings", [
            "settings" => $settings_arr
        ]);
    }
}
