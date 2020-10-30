<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Employee;
use App\User;
use App\EmployeeApprovalRequest;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\View;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
  
        $total_employees = Employee::all(); // get total employees
        $employees = Employee::orderBy('id','desc')->get()->take(9);
        $birthdays = Employee::whereRaw('DAYOFYEAR(curdate()) <= DAYOFYEAR(birthdate) AND DAYOFYEAR(curdate()) + 7 >=  dayofyear(birthdate)')
                        ->orderByRaw('DAYOFYEAR(birthdate)')
                        ->get()->take(9);


        $remarks = Employee::orderBy('updated_at','desc')
                            ->where('job_remarks','!=','')
                            ->orWhere('id_remarks','!=','')
                            ->take(8)
                            ->get();

        $remarks_total = Employee::orderBy('updated_at','desc')
                            ->where('job_remarks','!=','')
                            ->orWhere('id_remarks','!=','')
                            ->get();



        $total_birthdays = Employee::whereMonth('birthdate', Carbon::now()->month);
        $total_update = Employee::whereMonth('updated_at', Carbon::now()->month);
        $tota_inactive = Employee::where('status', 'Inactive');
        $new_hire = Employee::whereMonth('created_at', Carbon::now()->month);

        if(Auth::user()->hasRole('User')){
            $notifications =  EmployeeApprovalRequest::with('employee')
                       ->where('status','Pending')
                       ->whereHas('employee', function($q){
                            $q->where('user_id', '=', Auth::user()->id);
                        })
                       ->orderBy('created_at','desc')->count();
        }else{
            $notifications = EmployeeApprovalRequest::where('status','Pending')
                       ->orderBy('created_at','desc')
                       ->count();
        }

        session(['notifications' => $notifications]);

        if(Auth::user()->hasRole('Administrator') || Auth::user()->hasRole('HR Staff')){
            return view('dashboard', compact('employees',
         'birthdays',
         'remarks',
         'remarks_total',
         'new_hire',
         'total_update',
         'tota_inactive',
         'total_birthdays',
         'total_employees'
        ));
        }else{
        return view('home', compact('employees',
         'birthdays',
         'new_hire',
         'total_update',
         'tota_inactive',
         'remarks',
         'remarks_total',
         'total_birthdays',
         'total_employees'
        ));
        }




    }

    public function remarks(){

            $remarks = Employee::orderBy('updated_at','desc')
                ->where('job_remarks','!=','')
                ->orWhere('id_remarks','!=','')
                ->get();

    return view('remarks', compact('remarks'));

    }

        public function totalUpdate(){

          $total_update = Employee::whereMonth('updated_at', Carbon::now()->month)->get();
      
        return view('totalUpdate', compact('total_update'));
    }
}
