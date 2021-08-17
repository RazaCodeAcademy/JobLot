<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CandidateController extends Controller
{
    public function list()
    {
        $candidates = DB::table('users')
                    ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                    ->select('users.name','model_has_roles.model_id')
                    ->where('model_has_roles.role_id', '=', 3)
                    ->orderBy('users.id', 'desc')
                    ->get();

        $date = \Carbon\Carbon::today()->subDays(5);
        $activeUsers = DB::table('active_users')->where('date','>=',$date)->count();

        return view('backend.pages.candidate.list', compact('candidates','activeUsers'));

    }
}
