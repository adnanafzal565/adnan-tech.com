<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use File;
use Storage;
use Validator;

class ThemeController extends Controller
{
    public function update()
    {
        $theme = request()->theme ?? "";
        set_setting('active_theme', $theme);
        return redirect()->back();
    }

    public function index()
    {
        $themes = resource_path("views/themes");
        $themes = File::directories($themes);

        foreach ($themes as $key => $value)
        {
            $themes[$key] = basename($value);
        }

        $active_theme = active_theme();

        return view("admin/themes/index", [
            "themes" => $themes,
            "active_theme" => $active_theme
        ]);
    }
}
