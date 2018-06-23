<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RedirectController extends Controller
{
    public function discordRedirect(){
        return redirect()->away('https://discordapp.com/invite/dM5gUst');
    }

    public function steamRedirect(){
        return redirect()->away('https://steamcommunity.com/groups/KingsgamingRP');
    }

    public function serverRedirect(){
        return redirect()->away('steam://connect/198.27.80.155:27752');
    }
}
