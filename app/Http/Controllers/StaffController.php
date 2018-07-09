<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Staff;

class StaffController extends Controller
{
    public function index(){

//        $staff = new Staff();
//        $staff = DB::connection('mysql5')
//            ->table('serverguard_users')
//            ->whereIn('rank', ['founder', 'developer', 'community_manager', 'superadmin', 'senior_administrator', 'admin', 'senior_moderator', 'moderator', 'trial_moderator'])
//            ->orderByRaw('(CASE rank WHEN \'founder\' THEN 1 WHEN \'developer\' THEN 2 WHEN \'community_manager\' THEN 3 WHEN \'superadmin\' THEN 4 WHEN \'senior_administrator\' THEN 5 WHEN \'admin\' THEN 6 WHEN \'senior_moderator\' THEN 7 WHEN \'moderator\' THEN 8 WHEN \'trial_moderator\' THEN 9 ELSE 100 END) ASC, rank ASC')
//            ->simplePaginate(15);
//        return view('front.staff')->with(['staff' => $staff]);
        return view('errors.503');
    }
}







