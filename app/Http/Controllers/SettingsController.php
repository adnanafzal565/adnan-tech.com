<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Storage;
use Validator;

use App\Models\Settings;

class SettingsController extends Controller
{
    public function save()
    {
        $admin = auth()->user();

        // $smtp_host = request()->smtp_host ?? "";
        // $smtp_port = request()->smtp_port ?? "";
        // $smtp_encryption = request()->smtp_encryption ?? "";
        // $smtp_username = request()->smtp_username ?? "";
        // $smtp_password = request()->smtp_password ?? "";
        // $smtp_from = request()->smtp_from ?? "";
        // $smtp_from_name = request()->smtp_from_name ?? "";
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
        // set_setting("smtp_host", $smtp_host);
        // set_setting("smtp_port", $smtp_port);
        // set_setting("smtp_encryption", $smtp_encryption);
        // set_setting("smtp_username", $smtp_username);
        // set_setting("smtp_password", $smtp_password);
        // set_setting("smtp_from", $smtp_from);
        // set_setting("smtp_from_name", $smtp_from_name);
        set_setting("title", $title);

        set_setting("facebook", request()->facebook ?? "");
        set_setting("instagram", request()->instagram ?? "");
        set_setting("youtube", request()->youtube ?? "");
        set_setting("github", request()->github ?? "");
        set_setting("linkedin", request()->linkedin ?? "");

        set_setting("email", request()->email ?? "");
        set_setting("whatsapp", request()->whatsapp ?? "");

        return response()->json([
            "status" => "success",
            "message" => "Settings has been saved."
        ]);
    }

    public function index()
    {
        $settings = Settings::get();

        $settings_arr = [];
        foreach ($settings as $setting)
            $settings_arr[$setting->key ?? ""] = $setting->value ?? "";

        return view("admin/settings", [
            "settings" => $settings_arr
        ]);
    }
}
