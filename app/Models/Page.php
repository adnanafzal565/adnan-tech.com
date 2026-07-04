<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    public static function map($page)
    {
        if ($page == null)
        {
            return null;
        }

        $page->title = $page->title ?? "";
        $page->excerpt = $page->excerpt ?? "";
        $page->content = $page->content ?? "";
        $page->keywords = $page->keywords ?? "";
        $page->url = url("/" . ($page->slug ?? ""));

        return $page;
    }
}
