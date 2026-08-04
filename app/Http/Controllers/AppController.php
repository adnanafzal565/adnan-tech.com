<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\App;

class AppController extends Controller
{
    public function detail(Request $request)
    {
        $app = App::where("id", $request->id)
            ->orWhere("identifier", $request->identifier)
            ->firstOrFail();

        $data = collect();

        if ($app->identifier === "email_renderer") {
            if (is_module_exists("EmailRenderer")) {
                $data = (new \App\Modules\EmailRenderer\Services\EmailRendererService())
                    ->fetch_templates();
            }
        }

        if ($request->expectsJson()) {
            return response()->json([
                "status" => "success",
                "app" => $app,
                "data" => $data
            ]);
        }

        return view("theme::apps/detail", [
            "app" => $app,
            "data" => $data
        ]);
    }

    public function admin_detail(Request $request)
    {
        $app = App::findOrFail($request->id);

        $data = collect();

        if ($app->identifier === "email_renderer" && is_module_exists("EmailRenderer")) {
            $data = (new \App\Modules\EmailRenderer\Services\EmailRendererService())
                ->fetch_templates();
        }

        return view("admin/apps/detail", [
            "app" => $app,
            "data" => $data
        ]);
    }

    public function admin_index()
    {
        $apps = App::orderBy("name", "ASC")->get();

        return view("admin/apps/index", [
            "apps" => $apps
        ]);
    }
}
