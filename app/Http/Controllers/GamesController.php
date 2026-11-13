<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GamesController extends Controller
{
    public function index()
    {
        return view("games/index");
    }
    
    public function play($slug)
    {
        $games = get_games();
        
        foreach ($games as $game) {
            if ($game->slug === $slug) {
                return view("games/" . $slug);
            }
        }
    }
    
    // public function pp3d()
    // {
    //     return view("games/pp3d");
    // }
}
