<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OwenIt\Auditing\Auditable;
use Carbon\Carbon;
use App\User;
use App\Audit;
use DB;

class ActivityController extends Controller
{

    public function getAdminUser()
    {
        $admin_users = User::whereHas('roles', function($q) {
            $q->where('name','Administrator');
        })->get();

        return $admin_users;
    }

    public function index()
    {
        $audits = Audit::whereDate('created_at', DB::raw('CURDATE()'))->get();
        $users = $this->getAdminUser();

        return view('activities.index', compact('audits','users'));
    }

    public function findUser($username)
    {
        $user = User::where('id',$username)->first();
        return $user->name;
    }

    public function generateActivities(Request $request) 
    {
        $this->validate($request,[
            'start_date' => 'required',
            'end_date' => 'required'
        ]);

        $start_date = $request->get('start_date');
        $end_date = $request->get('end_date');

         $audits = Audit::whereDate('created_at', '>=', Carbon::parse($start_date))
        ->whereDate('created_at', '<=', Carbon::parse($end_date))
        ->orderBy('id','DESC')
        ->get();

         $users = $this->getAdminUser();

        return view('activities.index',compact('audits','start_date','end_date','users'));
    }


}
