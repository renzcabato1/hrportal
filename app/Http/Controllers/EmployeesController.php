<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\EmployeeRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use App\Http\Requests;
use App\Employee;
use App\User;
use App\Department;
use App\Dependent;
use App\Company;
use App\Location;
use App\PrintIdLog;
use App\Address;
use App\Tag;
use App\Api;
use App\Head;
use App\AssignHead;
use App\Level;
use App\MaritalStatus;
use App\EmployeeApprovalRequest;
use App\Division;
use Carbon\Carbon;
use Flashy;
use Entrust;
use Hash;
use Alert;
use Fpdf;
use File;
use Image;
use Artisan;
// use Codedge\Fpdf\Fpdf\Fpdf $fpdf;
use Html;

use Illuminate\Support\Facades\Input;

class EmployeesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $user = User::all();
        $companies = Company::pluck('name','id');
        $locations = Location::pluck('name','id');
        $search = $request->input('search');    
        $company = $request->input('company_list');    
        $location = $request->input('location_list');    
          
        if(!empty($search)){
            $employees = Employee::with('user','companies','locations','departments','tag') 
                        ->where(function($q) use($search) {
                            $q->where('employee_number', 'like', '%'.$search.'%');
                            $q->orWhere('first_name', 'like', '%'.$search.'%');
                            $q->orWhere('last_name', 'like', '%'.$search.'%');
                            $q->orWhereRaw("CONCAT(`first_name`, ' ', `last_name`) LIKE ?", ["%{$search}%"]);
                        })
                        ->when(Entrust::hasRole('HR Staff') , function($q) {
                            return $q->doesnthave('print_id_logs');
                        })
                        ->orderBy('employee_number', 'ASC')
                        ->paginate(20);
        }
        elseif(!empty($location) && !empty($company)){
            $employees = Employee::with('user','companies','locations','departments','tag') 
                        ->whereHas('companies', function($q) use($company){
                            $q->where('company_id', $company);
                        })
                        ->whereHas('locations', function($q) use($location){
                            $q->where('location_id', $location);
                        })
                        ->when(Entrust::hasRole('HR Staff') , function($q) {
                            return $q->doesnthave('print_id_logs');
                        }) 
                        ->orderBy('employee_number', 'ASC')
                        ->paginate(20);
        }
        elseif(!empty($company)){
            $employees = Employee::with('user','companies','locations','departments','tag') 
                        ->whereHas('companies', function($q) use($company){
                            $q->where('company_id', $company);
                        })
                        ->when(Entrust::hasRole('HR Staff') , function($q) {
                            return $q->doesnthave('print_id_logs');
                        }) 
                        ->orderBy('employee_number', 'ASC')
                        ->paginate(20);
        }
        elseif(!empty($location)){
            $employees = Employee::with('user','companies','locations','departments','tag') 
                        ->whereHas('locations', function($q) use($location){
                            $q->where('location_id', $location);
                        })
                        ->when(Entrust::hasRole('HR Staff') , function($q) {
                            return $q->doesnthave('print_id_logs');
                        }) 
                        ->orderBy('employee_number', 'ASC')
                        ->paginate(20);
        }
        
        else{
            $employees = Employee::with('user','companies','locations','departments','tag')
                                    ->when(Entrust::hasRole('HR Staff') , function($q) {
                                        return $q->doesnthave('print_id_logs');
                                    })
                                    ->orderBy('employee_number', 'ASC')
                                    ->paginate(20);
        }

        if(Entrust::hasRole('Administrator') || Entrust::hasRole('HR Staff')  || Entrust::hasRole('Administrator Printer')){
            return view('employees.index',compact('employees','user','companies','locations'));
        }
        else{
            return redirect('home');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $companies = Company::pluck('name','id');
        $departments = Department::pluck('name','id');
        $locations = Location::pluck('name','id');
        $user = User::all();
        $employees = Employee::where('status','Active')->orderBy('id','ASC')->get()->pluck('full_name', 'id');
        $head_positions = Head::orderBy('id','ASC')->get()->pluck('name', 'id');
        $levels = Level::orderBy('id','ASC')->get()->pluck('name', 'name');
        $levels->prepend('--Select Level--');
        $marital_statuses = MaritalStatus::orderBy('id','ASC')->get()->pluck('name', 'name');
        $marital_statuses->prepend('--Select Marital Status--');
       

        return view('employees.create', compact('user',
            'employees',
            'head_positions',
            'locations',
            'departments',
            'companies',
            'levels',
            'marital_statuses'
            ));
    }

    public function tag($employee_id){
        $tag = Tag::firstOrNew(['employee_id'=>$employee_id]); 
        $tag->tag_status = 1;
        $tag->save();
        flashy()->success('Employee Successfully Tagged');
        return back();
    }
    public function untag($id){
        $tag = Tag::where('id',$id)->update(['tag_status'=>0]);
        flashy()->success('Employee Successfully Untagged');
        return back();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmployeeRequest $request)
    {

        // $input = $request->all();
        // $input['password'] = Hash::make($input['password']);
        // $input['name'] = $request->input('first_name') . " " . $request->input('last_name');
        // $input['email']  $request->input('first_name').$request->input('last_name')."@"
        // $user = User::create($input);

        $this->validate($request, [
            'company_list' => 'required',
            'department_list' => 'required',
            'location_list' => 'required',
            'tax_status' => 'required',
         ], [
             'company_list.required' => 'This field is required',
             'department_list.required' => 'This field is required',
             'location_list.required' => 'This field is required',
             'tax_status.required' => 'This field is required',
         ]);


        $employee_last = Employee::orderBy('created_at','DESC')->pluck('employee_number')->first();

        $user = new User;
        $user->password = Hash::make($request->input('first_name').".".$request->input('last_name'));
        $user->name =  $request->input('first_name') . " " . $request->input('last_name');
        $user->email = $request->input('first_name').".".$request->input('last_name')."@lafilgroup.com";
        $user->save();

        $employee = $user->employees()->create($request->all());
        $employee->employee_number = $employee_last + 1;
        $employee->save();

        $employee->companies()->attach($request->input('company_list'));
        $employee->departments()->attach($request->input('department_list'));
        $employee->locations()->attach($request->input('location_list'));

        
        /**
         * Assign Heads
         */
        
        if(!empty($request->assign_head)){
            foreach($request->assign_head as $assign_head){
                $data = [
                    'employee_id'=>$employee->id,
                    'employee_head_id'=>$assign_head['head_name'],
                    'head_id'=>$assign_head['head_position']
                ];
                if($assign_head['head_name'] != '--Select Name--' && $assign_head['head_position'] != '--Select Position--'){
                    if(isset($assign_head['id'])){
                        if(isset($assign_head['delete'])){
                            if($assign_head['delete'] == 'on'){
                                $employee->assign_heads()->where('id',$assign_head['id'])->delete();
                            }
                        }else{
                            $employee->assign_heads()->where('id',$assign_head['id'])->update($data); 
                        }
                    }else{
                        $employee->assign_heads()->create($data);
                    }     
                }
                
            }
        }

        if(!empty($request->dependent)){
            foreach($request->dependent as $dependent){
                $data = [
                    'employee_id'=>$employee->id,
                    'dependent_name'=> isset($dependent['dependent_name']) ? $dependent['dependent_name'] : '',
                    'relation'=> isset($dependent['relation']) ? $dependent['relation'] : '',
                    'bdate'=>isset($dependent['bdate']) ? $dependent['bdate'] : null,
                    'dependent_gender' => isset($dependent['dependent_gender']) ? $dependent['dependent_gender'] : '' 
                ];
                
                if(!empty($data['dependent_name'])){
                    if(isset($dependent['id'])){
                        if(isset($dependent['delete'])){
                            if($dependent['delete'] == 'on'){
                                $employee->dependents()->where('id',$dependent['id'])->delete();
                            }
                        }else{
                            $employee->dependents()->where('id',$dependent['id'])->update($data); 
                        }
                    }else{
                        $employee->dependents()->create($data);
                    }     
                }     
                
                
            }
        }    


        alert()->success('Employee Successfully Added!','Successfully Added');

        if(Entrust::hasRole('Administrator')){
            return redirect('employees');
        }
        else {
            return redirect('home');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        return view('employees.show',compact('employee'))
        ->with('success','You successfully update your info');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        Artisan::call('cache:clear');
        $users = User::all();
        $companies = Company::pluck('name','id');
        $departments = Department::pluck('name','id');
        $locations = Location::pluck('name','id');
        $employees = Employee::where('id', '!=',$employee->id)->where('status','Active')->orderBy('id','ASC')->get()->pluck('full_name', 'id');
        $head_positions = Head::orderBy('id','ASC')->get()->pluck('name', 'id');
        $levels = Level::orderBy('id','ASC')->get()->pluck('name', 'name');
        $levels->prepend('--Select Level--');
        $marital_statuses = MaritalStatus::orderBy('id','ASC')->get()->pluck('name', 'name');
        $marital_statuses->prepend('--Select Marital Status--');

        $company_id =  $employee->companies->first()->id;
        $divisions = [];
        if($company_id){
            $divisions = Division::where('company_id', '=', $company_id)->pluck('name','name');
        }
        
        if(Entrust::hasRole('Administrator') || Entrust::hasRole('HR Staff')){
            return view('employees.edit',compact(
            'employee',
            'locations',
            'companies',
            'departments',
            'employees',
            'head_positions',
            'levels',
            'marital_statuses',
            'divisions',
            'users'));   
        }
        else{
            if($employee->id == Auth::user()->employees->id)
                return view('employees.edit',compact('employee',
                'locations',
                'companies',
                'departments',
                'levels',
                'marital_statuses',
                'divisions',
                'users'));  
            else return back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employee $employee)
    {
        $employee_data = [];
        $employee_approval_data = [];
        if(Entrust::hasRole('User'))
        {
            $date_time = Carbon::now()->format('M_d_Y_h_m_s');

            if ($request->hasFile('marital_status_attachment')) {
                $marital_status_attachment =  $employee->id . '_' . $date_time  . '.' . $request->marital_status_attachment->getClientOriginalExtension();   
                $request->marital_status_attachment->move(public_path('files/marital_status_attachments/temps'), $marital_status_attachment);
                $employee_data['marital_status_attachment'] = $marital_status_attachment;
            }

            $employee_data['first_name'] = $request->first_name ? $request->first_name : $employee->first_name;
            $employee_data['middle_name'] = $request->middle_name ? $request->middle_name : $employee->middle_name;
            $employee_data['last_name'] = $request->last_name ? $request->last_name : $employee->last_name;
            $employee_data['marital_status'] = $request->marital_status;

            $employee_data['current_address'] = $request->current_address;
            $employee_data['permanent_address'] = $request->permanent_address;
            $employee_data['phone_number'] = $request->phone_number;
            $employee_data['mobile_number'] = $request->mobile_number;
            $employee_data['contact_person'] = $request->contact_person;
            $employee_data['contact_relation'] = $request->contact_relation;
            $employee_data['contact_number'] = $request->contact_number;

            $employee_data['dependent'] = $request->dependent;

             //Orginal Employee Data
            $original_employee_data = [];
            $original_employee_data['first_name'] = $employee->first_name;
            $original_employee_data['middle_name'] = $employee->middle_name;
            $original_employee_data['last_name'] = $employee->last_name;
            $original_employee_data['marital_status'] = $employee->marital_status;
            $original_employee_data['marital_status_attachment'] = $employee->marital_status_attachment;
            $original_employee_data['current_address'] = $employee->current_address;
            $original_employee_data['permanent_address'] = $employee->permanent_address;
            $original_employee_data['phone_number'] = $employee->phone_number;
            $original_employee_data['mobile_number'] = $employee->mobile_number;
            $original_employee_data['contact_person'] = $employee->contact_person;
            $original_employee_data['contact_relation'] = $employee->contact_relation;
            $original_employee_data['contact_number'] = $employee->contact_number;
          
            $check_request = EmployeeApprovalRequest::where('employee_id', '=', $employee->id)
                                    ->where('status' , '=', 'Pending')
                                    ->first();
                            
            // Employee Approval Data
            $employee_approval_data['employee_id'] = $employee->id;
            $employee_approval_data['employee_data'] = json_encode($employee_data);
            $employee_approval_data['original_employee_data'] = json_encode($original_employee_data);
           
            if(isset($check_request->id)){
                $check_request->update($employee_approval_data);
            }else{
                EmployeeApprovalRequest::create($employee_approval_data);
            }

            alert()->success('Update Succesfully','Successfully Changed');
            return redirect('employee_approval_request');
        }
        elseif(Entrust::hasRole('Administrator') || Entrust::hasRole('HR Staff')){

                $this->validate($request, [
                   'company_list' => 'required',
                   'department_list' => 'required',
                   'location_list' => 'required',
                   'location_list' => 'required',
                ], [
                    'company_list.required' => 'This field is required',
                    'department_list.required' => 'This field is required',
                    'location_list.required' => 'This field is required',
                ]);
                
                $data = $request->all();
                if ($request->hasFile('signature')) {
                    $signature =  $employee->id . '.' . $request->signature->getClientOriginalExtension();   
                    $request->signature->move(public_path('id_image/employee_signature'), $signature);
                   
                }
 
                if ($request->hasFile('avatar')) {
                    $avatar =  $employee->id . '.' . $request->avatar->getClientOriginalExtension();   
                    $request->avatar->move(public_path('id_image/employee_image'), $avatar);
                    
                }

                if ($request->hasFile('marital_status_attachment')) {
                    $marital_status_attachment =  $employee->id . '.' . $request->marital_status_attachment->getClientOriginalExtension();   
                    $request->marital_status_attachment->move(public_path('files/marital_status_attachments'), $marital_status_attachment);
                   
                    $data['marital_status_attachment'] = $marital_status_attachment;
                }
                
                // dd( $data );
                $employee->update($data);
                
                $employee->companies()->sync( (array) $request->input('company_list'));
                $employee->departments()->sync( (array) $request->input('department_list'));
                $employee->locations()->sync( (array) $request->input('location_list'));

               

                /**
                 * Assign Heads
                 */
              
                if(!empty($request->assign_head)){
                    foreach($request->assign_head as $assign_head){
                        $data = [
                            'employee_id'=>$employee->id,
                            'employee_head_id'=>$assign_head['head_name'],
                            'head_id'=>$assign_head['head_position']
                        ];
                        if($assign_head['head_name'] != '--Select Name--' && $assign_head['head_position'] != '--Select Position--'){
                            if(isset($assign_head['id'])){
                                if(isset($assign_head['delete'])){
                                    if($assign_head['delete'] == 'on'){
                                        $employee->assign_heads()->where('id',$assign_head['id'])->delete();
                                    }
                                }else{
                                    $employee->assign_heads()->where('id',$assign_head['id'])->update($data); 
                                }
                            }else{
                                $employee->assign_heads()->create($data);
                            }     
                        }
                        
                    }
                }

                if(!empty($request->dependent)){
                    foreach($request->dependent as $dependent){
                        $data = [
                            'employee_id'=>$employee->id,
                            'dependent_name'=> !empty($dependent['dependent_name']) ? $dependent['dependent_name'] : '',
                            'relation'=> isset($dependent['relation']) ? $dependent['relation'] : '',
                            'bdate'=>isset($dependent['bdate']) ? $dependent['bdate'] : null,
                            'dependent_gender' => isset($dependent['dependent_gender']) ? $dependent['dependent_gender'] : '' 
                        ];
                        
                        if(!empty($data['dependent_name'])){
                            if(isset($dependent['id'])){
                                if(isset($dependent['delete'])){
                                    if($dependent['delete'] == 'on'){
                                        $employee->dependents()->where('id',$dependent['id'])->delete();
                                    }
                                }else{
                                    $employee->dependents()->where('id',$dependent['id'])->update($data); 
                                }
                            }else{
                                $employee->dependents()->create($data);
                            }     
                        }     
                        
                        
                    }
                }
                
                alert()->success('Update Succesfully','Successfully Changed');
                return redirect('employees');
        }
    }

    public function verify_account_number(Request $request, Employee $employee)
    {
        $employee->bank_account_verified = $request->bank_account_verified;
        $employee->save();
    }

    public function get_id_remarks($employee_id){
        $id_remarks = PrintIdLog::select('remarks','created_at')
                                ->groupBy('remarks')
                                ->where('employee_id',$employee_id)
                                ->where('remarks', '!=', '')
                                ->orderBy('created_at', 'desc')
                                ->get();
        return json_encode($id_remarks);
    }

    public function print_id($employee)
    {
        Artisan::call('cache:clear');
        
        $employee = Employee::with('departments','locations','companies')
                        ->where('id',$employee)->first();
        
        if($employee->locations->first()->id){
            $location = Location::with('addresses')->where('id',$employee->locations->first()->id)->first();
            $address = isset($location->addresses->first()->name) ? $location->addresses->first()->name : '';
        }

        $data['employee_id'] = $employee->id;
        $data['remarks'] = "Already Printed";

        PrintIdLog::create($data);

        // return redirect('employees/new_print_id/' . $employee->id);
        return redirect('employees/old_print_id/' . $employee->id);
    }

    public function add_print_log(Request $request){
        $employee = Employee::with('locations','departments','companies')
                    ->where('id',$request->employee_id)
                    ->first();
        $address = "";            
        if($employee->locations->first()->id){
            $location = Location::with('addresses')->where('id',$employee->locations->first()->id)->first();
            $address = isset($location->addresses->first()->name) ? $location->addresses->first()->name : '';
        }
        
        PrintIdLog::create(request([
            'employee_id',
            'remarks',
        ]));
        
        // return redirect('employees/new_print_id/' . $employee->id);
        return redirect('employees/old_print_id/' . $employee->id);
    }

    public function old_print_id(Employee $employee){
        $employee =  Employee::with('departments','locations')->where('id',$employee->id)->first();

        $address = "";            
        if($employee->locations->first()->id){
            $location = Location::with('addresses')->where('id',$employee->locations->first()->id)->first();
            $address = isset($location->addresses->first()->name) ? $location->addresses->first()->name : '';
        }

        Fpdf::AddPage("P", [53.98,85.60]);
        Fpdf::SetMargins(0,0,0,0);
        Fpdf::SetAutoPageBreak(false);
        
        Fpdf::SetFont('Courier', 'B', 18);
        
        if (file_exists( public_path() . '/id_image/employee_image/' . $employee->id . '.png')){
            
            $image = public_path() . '/id_image/employee_image/' . $employee->id . '.png';
            $destinationPath = public_path('/id_image/temp_employee_image/');

            if(!File::isDirectory($destinationPath)){
                File::makeDirectory($destinationPath, 0777, true, true);
            }
            
            $img = Image::make(file_get_contents($image));

            $img->resize(500, 500, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath.'/'. $employee->id . '.png');

            if (file_exists( public_path() . '/id_image/temp_employee_image/' . $employee->id . '.png')){
                Fpdf::Image(url("/id_image/temp_employee_image/") .'/'. $employee->id.'.png', 12.5, 20, 29, 29,'PNG');
            }
        }
    ;
        if (file_exists( public_path() . '/id_image/department_color/FRONT/' . $employee['departments'][0]->color.'.png')){
            Fpdf::Image(url("/id_image/department_color/FRONT/") .'/'.  $employee['departments'][0]->color.'.png', 0, 0, 53.98, 85.60,'PNG');
        }

        if (file_exists( public_path() . '/id_image/company/' . $employee['companies'][0]->id.'.png')){
            Fpdf::Image(url("/id_image/company/") .'/'. $employee['companies'][0]->id.'.png', 0, 0, 53.98, 85.60,'PNG');
        }

        $fullname_font = 12;
        $fname_mname = utf8_decode($employee->first_name) .' '. $employee->middle_initial .'.';
        $fullname_height = Fpdf::GetMultiCellHeight(53.98, 5,  $fname_mname, 0);

        Fpdf::SetFont('Arial', 'B', $fullname_font);
        if($fullname_height <= 9){
            Fpdf::SetXY(0,50);
            Fpdf::MultiCell(53.98,5, $fname_mname ,0,'C');
            Fpdf::SetXY(0,55);
            Fpdf::MultiCell(53.98,5,utf8_decode($employee->last_name),0,'C');
        }
        else if($fullname_height >= 10 && $fullname_height <= 15){ 
            $fullname_font = $fullname_font - 2;
            Fpdf::SetFont('Arial', 'B', $fullname_font);
            Fpdf::SetXY(0,50);
            Fpdf::MultiCell(53.98,5,$fname_mname ,0,'C');
            Fpdf::SetXY(0,55);
            Fpdf::MultiCell(53.98,5,utf8_decode($employee->last_name),0,'C');
        }
        else{
            $fullname_font = $fullname_font - 7;
            Fpdf::SetFont('Arial', 'B', $fullname_font);
            Fpdf::SetXY(0,50);
            Fpdf::MultiCell(53.98,3,$fname_mname ,0,'C');
            $gety =  Fpdf::GetY();
            Fpdf::SetXY(0, $gety);
            Fpdf::MultiCell(53.98,3,utf8_decode($employee->last_name),0,'C');
        }

        Fpdf::SetFont('Arial', '', 7);
        Fpdf::SetXY(0, 60);
        Fpdf::MultiCell(53.98,4,"ID Number: " . $employee->employee_number ,0,'C');

        if (file_exists( public_path() . '/id_image/employee_signature/' . $employee->id.'.png')){

            $signature = public_path() . '/id_image/employee_signature/' . $employee->id . '.png';
            $destinationPath = public_path('/id_image/temp_employee_signature/');

            if(!File::isDirectory($destinationPath)){
                File::makeDirectory($destinationPath, 0777, true, true);
            }

            $img = Image::make($signature);

            $img->resize(500, 300, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath.'/'. $employee->id . '.png');

            if (file_exists( public_path() . '/id_image/temp_employee_signature/' . $employee->id.'.png')){
                Fpdf::Image(url("/id_image/temp_employee_signature/") . '/' . $employee->id.'.png', 17, 65, 22, 11,'PNG');
            }
        }

        Fpdf::SetFont('Arial', 'B', 10);
        Fpdf::SetXY(0,77);

        $department = $employee['departments'][0]->name;
        $count_string_department = strlen($department);
        if($count_string_department > 23){
            $height_department  = 4.5;
        }else{
            $height_department  = 8.5;
        }

        Fpdf::SetTextColor(255,255,255);
        Fpdf::MultiCell(53.98,$height_department,$department,0,'C');

        Fpdf::AddPage("P", [85.60, 53.98]);
        Fpdf::SetMargins(0,0,0,0);
        Fpdf::SetAutoPageBreak(false);

        if (file_exists( public_path() . '/id_image/department_color/BACK/' . $employee['departments'][0]->color.'.jpg')){
            Fpdf::Image(url("/id_image/department_color/BACK/") . '/' . $employee['departments'][0]->color.'.jpg', 0, 0, 53.98, 85.60);
        }

        Fpdf::SetTextColor(0,0,0);
        Fpdf::SetFont('Arial', '', 6);
            
        Fpdf::SetXY(15, 10);
        Fpdf::MultiCell(35,3,utf8_decode($employee->contact_person),0,'L');

        if(isset($employee->contact_number)){ 
            Fpdf::SetXY(15, 13);
            Fpdf::MultiCell(35,3, $employee->contact_number ,0,'L');
            // Fpdf::MultiCell(35,3,"(". substr($employee->contact_number, 0, 3) .") " .  substr($employee->contact_number, -10) ,0,'L');
        }

        Fpdf::SetXY(15, 23);
        $current_address_font = 6;
        if(isset($employee->current_address)){
            $current_address_height = Fpdf::GetMultiCellHeight(37, 2,  $employee->current_address, 0);

            if($current_address_height <= 2){
                Fpdf::MultiCell(37,2,$employee->current_address,0,'L');
            }
            else if($current_address_height > 2 && $current_address_height <= 6){ 
                Fpdf::MultiCell(37,2,$employee->current_address,0,'L');
            }
            else{
                $current_address_font = $current_address_font - 1;
                Fpdf::SetFont('Arial', '', $current_address_font);
                Fpdf::MultiCell(37,2,$employee->current_address,0,'L');
            }
        }
    

        if(isset($employee->sss_number)){
            Fpdf::SetXY(15, 34);
            Fpdf::MultiCell(10,2.5,"SSS",0,'L');
            Fpdf::SetXY(25, 34);
            Fpdf::MultiCell(25,2.5,": " . $employee->sss_number,0,'L');
        }

        if(isset($employee->tax_number)){
            Fpdf::SetXY(15, 36.5);
            Fpdf::MultiCell(10,2.5,"TIN",0,'L');

            Fpdf::SetXY(25, 36.5);
            Fpdf::MultiCell(25,2.5,": " . $employee->tax_number,0,'L');
        }

        if(isset($employee->phil_number)){
            Fpdf::SetXY(15, 39);
            Fpdf::MultiCell(10,2.5,"PHIC",0,'L');

            Fpdf::SetXY(25, 39);
            Fpdf::MultiCell(25,2.5,": " . $employee->phil_number,0,'L');
        }

        if(isset($employee->hdmf)){
            Fpdf::SetXY(15, 41.5);
            Fpdf::MultiCell(10,2.5,"HDMF",0,'L');
            Fpdf::SetXY(25, 41.5);
            Fpdf::MultiCell(25,2.5,": " . $employee->hdmf,0,'L');
        }
    

        Fpdf::SetTextColor(255,255,255);
        Fpdf::SetFont('Arial', '', 5);
        Fpdf::SetXY(0, 79);
        if(isset($address)){
            Fpdf::MultiCell(53.98,2.5,$address,0,'C');
        }
        Fpdf::Output(utf8_decode($employee->last_name) .'_' . utf8_decode($employee->first_name) . '_' . $employee->employee_number  . ".pdf", 'I');
        exit();

    }
    public function new_print_id(Employee $employee)
    {

        
        $employee =  Employee::with('departments','locations')->where('id',$employee->id)->first();

        $address = "";            
        if($employee->locations->first()->id){
            $location = Location::with('addresses')->where('id',$employee->locations->first()->id)->first();
            $address = isset($location->addresses->first()->name) ? $location->addresses->first()->name : '';
        }

        function RotatedImage($file,$x,$y,$w,$h,$angle)
        {
            //Image rotated around its upper-left corner
            Fpdf::Rotate($angle,$x,$y);
            Fpdf::Image($file,$x,$y,$w,$h);
            Fpdf::Rotate(0);
        }

        function departmentColor($color){
            
            $color_arr = [];
            if($color == 'grey'){
                $color_arr['r'] = 128;
                $color_arr['g'] = 128;
                $color_arr['b'] = 128;
            }
            elseif($color == 'green'){
                $color_arr['r'] = 0;
                $color_arr['g'] = 128;
                $color_arr['b'] = 0;
            }
            elseif($color == 'orange'){
                $color_arr['r'] = 255;
                $color_arr['g'] = 165;
                $color_arr['b'] = 0;
            }
            elseif($color == 'red'){
                $color_arr['r'] = 255;
                $color_arr['g'] = 0;
                $color_arr['b'] = 0;
            }
            elseif($color == 'violet'){
                $color_arr['r'] = 238;
                $color_arr['g'] = 130;
                $color_arr['b'] = 238;
            }
            elseif($color == 'yellow'){
                $color_arr['r'] = 255;
                $color_arr['g'] = 255;
                $color_arr['b'] = 0;
            }else{
                $color_arr['r'] = 255;
                $color_arr['g'] = 255;
                $color_arr['b'] = 255;
            }
            return $color_arr;
        }
        // return $employee;
        Fpdf::AddPage("P", [53.98,85.60]);

        Fpdf::AddFont('Avenir-Bold','','AvenirNextCondensed-Bold.php');
        Fpdf::AddFont('Avenir-Regular','','AvenirNextCondensed-Regular.php');

        Fpdf::SetMargins(0,0,0,0);
        Fpdf::SetAutoPageBreak(false);
        
        Fpdf::SetFont('Courier', 'B', 18);

        //Employee Image
        if (file_exists( public_path() . '/id_image/employee_image/' . $employee->id . '.png')){
        
            $image = public_path() . '/id_image/employee_image/' . $employee->id . '.png';
            $destinationPath = public_path('/id_image/temp_employee_image/');
    
            if(!File::isDirectory($destinationPath)){
                File::makeDirectory($destinationPath, 0777, true, true);
            }
            
            $img = Image::make(file_get_contents($image));
    
            $img->resize(500, 500, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath.'/'. $employee->id . '.png');
    
            if (file_exists( public_path() . '/id_image/temp_employee_image/' . $employee->id . '.png')){
                Fpdf::Image(url("/id_image/temp_employee_image/") .'/'. $employee->id.'.png', 11.5, 25, 30, 30,'PNG');
            }
        }
        
        //Front BG
        if (file_exists( public_path() . '/id_image/new_id_image/front.png')){
            Fpdf::Image(url("/id_image/new_id_image/front.png"), 0, 0, 53.98, 85.60,'PNG');
        }
    
      
        Fpdf::Image(url("/id_image/new_id_image/lfuggoc_logo.png"), 0, 0, 53.98, 25,'PNG');
        

        $fullname_font = 9;
        $middle_name = $employee->middle_initial ? $employee->middle_initial .'. ' : '';
        $suffix = $employee->name_suffix ? $employee->name_suffix : '';
        $full_name = ucfirst($employee->first_name) .' ' .  $middle_name . $employee->last_name . ' ' .$suffix;

        
        
        Fpdf::SetFont('Avenir-Bold','',$fullname_font);
        Fpdf::SetXY(0,63);
        Fpdf::SetTextColor(3,119, 57);
        Fpdf::MultiCell(40,3, ucwords($full_name) ,0,'L');

        $current_y = Fpdf::gety();
        Fpdf::SetXY(0,$current_y + 0.5);
        Fpdf::SetTextColor(0,0,0);
        Fpdf::SetFont('Avenir-Regular', '', 7);
        Fpdf::MultiCell(35,2.5, $employee->position ,0,'L');

        $current_y = Fpdf::gety();
        Fpdf::SetXY(0,$current_y + 1.5);
        Fpdf::SetFont('Avenir-Regular', '', 6);
        Fpdf::MultiCell(35,2.5, 'ID No.: ' . $employee->employee_number ,0,'L');


        
        Fpdf::SetXY(0,76.5);
        Fpdf::SetFont('Avenir-Bold', '', 6);
        Fpdf::MultiCell(35,2.5, $employee->division ,0,'L');

       
        Fpdf::SetXY(0,79);
        Fpdf::SetFont('Avenir-Regular', '', 6);
        Fpdf::MultiCell(35,2.5, $employee->departments[0]['name'] ,0,'L');

        $current_y = Fpdf::gety();
        Fpdf::SetXY(1.3,$current_y + 0.5);
        $color = departmentColor($employee->departments[0]['color']);
        Fpdf::SetFillColor( $color['r'], $color['g'], $color['b']);
        Fpdf::MultiCell(7,1.5, " ",0,'L',true);

        if (file_exists( public_path() . '/id_image/employee_signature/' . $employee->id.'.png')){

            $signature = public_path() . '/id_image/employee_signature/' . $employee->id . '.png';
            $destinationPath = public_path('/id_image/temp_employee_signature/');
    
            if(!File::isDirectory($destinationPath)){
                File::makeDirectory($destinationPath, 0777, true, true);
            }
    
            $img = Image::make($signature);
    
            $img->resize(500, 300, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath.'/'. $employee->id . '.png');
    
            if (file_exists( public_path() . '/id_image/temp_employee_signature/' . $employee->id.'.png')){
                // Fpdf::Image(url("/id_image/temp_employee_signature/") . '/' . $employee->id.'.png', 30, 64, 22, 8,'PNG');
                RotatedImage(url("/id_image/temp_employee_signature/") . '/' . $employee->id.'.png',30, 67, 22, 8,15);
            }
        }

        //Back
        Fpdf::AddPage("P", [85.60, 53.98]);
        Fpdf::SetMargins(0,0,0,0);
        Fpdf::SetAutoPageBreak(false);

        //Back BG
        if (file_exists( public_path() . '/id_image/new_id_image/back.png')){
            Fpdf::Image(url("/id_image/new_id_image/back.png"), 0, 0, 53.98, 85.60,'PNG');
        }

        //Company Logo
        if (file_exists( public_path() . '/id_image/new_id_image/company/' . $employee['companies'][0]->id.'.png')){

            $signature = public_path() . '/id_image/new_id_image/company/' . $employee['companies'][0]->id . '.png';
            $destinationPath = public_path('/id_image/new_id_image/temp_company/');
    
            if(!File::isDirectory($destinationPath)){
                File::makeDirectory($destinationPath, 0777, true, true);
            }
    
            $img = Image::make($signature);
    
            $img->resize(500, 300, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath.'/'. $employee['companies'][0]->id. '.png');
    
            if (file_exists( public_path() . '/id_image/new_id_image/temp_company/' . $employee['companies'][0]->id .'.png')){
                Fpdf::Image(url("/id_image/new_id_image/temp_company/") .'/'. $employee['companies'][0]->id.'.png', 15, 13, 25, 25,'PNG');
            }
            
        }

        //SSS, TIN, PHIC, HDMF

        Fpdf::SetFillColor(255,255,255);

        
        Fpdf::SetXY(1.3,38);

        Fpdf::SetFont('Arial', 'B', 5);
        Fpdf::SetDrawColor(253,209,62);
        Fpdf::Cell(26,21,'','R',1,'R',true);

        Fpdf::SetXY(1.3,39);
        Fpdf::Cell(26,2,'SSS',0,1,'R');
      

        Fpdf::SetFont('Arial', '', 5);
        Fpdf::SetX(1.3);
        Fpdf::Cell(26,2,$employee->sss_number,0,2,'R');

        Fpdf::Ln(1);

        Fpdf::SetFont('Arial', 'B', 5);
        Fpdf::SetX(1.3);
        Fpdf::Cell(26,2,'TIN',0,2,'R');

        Fpdf::SetFont('Arial', '', 5);
        Fpdf::SetX(1.3);
        Fpdf::Cell(26,2,$employee->tax_number,0,2,'R');

        Fpdf::Ln(1);

        Fpdf::SetFont('Arial', 'B', 5);
        Fpdf::SetX(1.3);
        Fpdf::Cell(26,2,'PHIC',0,2,'R');

        Fpdf::SetFont('Arial', '', 5);
        Fpdf::SetX(1.3);
        Fpdf::Cell(26,2,$employee->phil_number,0,2,'R');

        Fpdf::Ln(1);

        Fpdf::SetFont('Arial', 'B', 5);
        Fpdf::SetX(1.3);
        Fpdf::Cell(26,2,'HDMF',0,2,'R');

        Fpdf::SetFont('Arial', '', 5);
        Fpdf::SetX(1.3);
        Fpdf::Cell(26,2,$employee->tax_number,0,2,'R');

        Fpdf::SetFont('Arial', 'B',5);
        Fpdf::SetXY(27.3,39);
        Fpdf::Cell(26,2,'IN CASE OF EMERGENCY',0,1,'L');

        Fpdf::Ln(1);

        Fpdf::SetFont('Arial', 'B',5);
        Fpdf::SetX(27.3);
        Fpdf::MultiCell(26,2, $employee->contact_person ,0,'L');

        Fpdf::SetFont('Arial', '',5);
        Fpdf::SetX(27.3);
        Fpdf::Cell(26,2,$employee->contact_number,0,1,'L');

        Fpdf::Ln(2);

        Fpdf::SetFont('Arial', 'B',5);
        Fpdf::SetX(27.3);
        Fpdf::Cell(26,2,'EMPLOYEE ADDRESS ',0,1,'L');

        $current_y = Fpdf::gety();
        Fpdf::SetFont('Arial', '',5);
        Fpdf::SetXY(27.3,$current_y +1);
        Fpdf::MultiCell(25,2, $employee->current_address ,0,'L');

       
        Fpdf::SetTextColor(3,119, 57);
        Fpdf::SetFont('Arial', '',10);
        Fpdf::SetXY(2,63);
        Fpdf::MultiCell(50,3, 'www.lafilgroup.com' ,0,'C',true);
        
        $current_y = Fpdf::gety();
        Fpdf::SetTextColor(3,119, 57);
        Fpdf::SetFont('Arial', '',8);
        Fpdf::SetXY(2,$current_y += 1);
        Fpdf::MultiCell(50,2.5, '(02) 8516-73-62' ,0,'C',true);


        Fpdf::SetTextColor(1,1, 1);
        Fpdf::SetFont('Arial', '',6);
        Fpdf::SetXY(2,$current_y += 4);

        if($address){
            Fpdf::MultiCell(50,2, $address ,0,'C',true);
        }

        Fpdf::SetTextColor(3,119, 57);
        
        Fpdf::SetXY(7,80);
        Fpdf::SetFont('Arial', 'B',6);
        Fpdf::Cell(13,1.5,"INTEGRITY",0,1,'C');

        Fpdf::SetXY(21,80);
        Fpdf::Cell(13,1.5,"LOYALTY",0,1,'C');

        Fpdf::SetXY(36,80);
        Fpdf::Cell(13,1.5,"EXCELLENCE",0,1,'C');

        Fpdf::Output(utf8_decode($employee->last_name) .'_' . utf8_decode($employee->first_name) . '_' . $employee->employee_number  . ".pdf", 'I');
        exit();

        
    }
    
    public function organizational_chart($employee_id)
    {
        $api = Api::first();
        $user = Employee::where('id',$employee_id)->first();
        if($user){
            $datas = '';
            if($employee_id){
                $rUrl =  $api->api_link.$employee_id;
                $datas = file_get_contents($rUrl);
            }
            return view('employees.organizational_chart',compact('datas','user'));
        }else{
            return redirect('employees');
        }

        
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
