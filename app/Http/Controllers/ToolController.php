<?php

namespace App\Http\Controllers;

class ToolController extends Controller
{
    public function index()
    {
        return view("theme::tools/index", [
            "tools" => tools()
        ]);
    }

    public function show($slug)
    {
        // Lookup is against the helper list, so only known slugs ever reach view()
        $tool = tool_by_slug($slug);

        if ($tool == null)
        {
            abort(404);
        }

        $tool_view = "theme::tools/" . $tool->slug;

        // The tool is listed but its blade file hasn't been created yet
        if (!view()->exists($tool_view))
        {
            abort(404);
        }

        return view("theme::tools/tool", [
            "tool" => $tool,
            "tool_view" => $tool_view
        ]);
    }
}