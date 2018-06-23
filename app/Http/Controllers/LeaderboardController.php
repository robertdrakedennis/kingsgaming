<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\DB;
use App\Leaderboards;

class LeaderboardController extends Controller
{
    public function index(){
        $leaderboards = new Leaderboards();
        $leaderboards->setConnection('mysql_gmod');
        $leaderboards = DB::connection()->table('darkrp_player')->whereRaw('CHAR_LENGTH(uid) = 17')->orderBy('wallet', 'desc')->simplePaginate(15);
        return view('front.leaderboards')->with([
            'players' => $leaderboards
        ]);
    }
}
