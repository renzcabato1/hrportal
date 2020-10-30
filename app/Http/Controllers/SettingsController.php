<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Company;
use App\Department;
use App\Level;
use App\Location;
use App\Dependent;
use App\Address;
use App\Head;
use App\MaritalStatus;
use App\EmployeeApprovalRequest;
use App\Employee;
use App\Division;
use Flashy;
use Artisan;
use Redirect;
use File;
use Entrust;
use Auth;
use Illuminate\Support\Facades\DB;

class SettingsController extends Controller
{
	/**
	 * Middleware auth for authorize users only
	 */
    public function __construct()
    {
    	$this->middleware('auth');
    }



    /**
     * Show the index page for settings controller
     */
    
    public function allCompany()
    {
        Artisan::call('cache:clear');
        $companies = Company::orderBy('name','ASC')->paginate(10);
        $total_company = Company::all();
        $total_department = Department::all();
        $total_location = Location::all();
    	return view('settings.company', 
            compact('companies',
                'total_department',
                'total_location',
                'total_company'));
    }

    /**
     * Store newly created data for company database
     */
    public function storeCompany(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:companies'
        ]);

        $company = Company::create($request->all());

        flashy()->success('Company Successfully Added');

        return back();
    }

    /**
     * Update company database
     */
    public function updateCompany($id, Request $request)
    {
        $company = Company::findOrFail($id);
        
        $this->validate($request, [
            'name' => 'required'
        ]);

        if ($request->hasFile('image_name')) {
            $filename = $id . '.' . $request->image_name->getClientOriginalExtension();   
            $request->image_name->move(public_path('id_image/company'), $filename);
        }
        


        Company::findOrFail($id)->update([
            'name'=>$request->get('name'),
        ]);
        
        if(!empty($request->division)){
            foreach($request->division as $division){
                if(!empty($division['name'])){
                    $data = [
                        'company_id'=>$id,
                        'name'=>$division['name'],
                    ];
                    
                    if(isset($division['id'])){
                        if(isset($division['delete'])){
                            if($division['delete'] == 'on'){
                                $company->divisions()->where('id',$division['id'])->delete();
                            }
                        }else{
                            $company->divisions()->where('id',$division['id'])->update($data);
                        }
                    }else{
                        $company->divisions()->create($data);
                    }     
                }

            }
        }

        flashy()->success('Company Successfully Updated!');

        return redirect('company');
    }

    /**
      * Destroy a company data
      */ 

    public function destroyCompany($id)
    {
        Company::findOrFail($id)->delete();
        flashy()->info('Company Successfully deleted!');
        return back();
    }








    /**
    * Store newly created data for department database
    */

    public function allDepartment()
    {
        $departments = Department::orderBy('name','ASC')->paginate(10);
        $total_company = Company::all();
        $total_department = Department::all();
        $total_location = Location::all();

        return view('settings.department', 
            compact('departments','total_company','total_department','total_location'));
    }

/**
 * Store department to database
 */

    public function storeDepartment(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:departments'
        ]);

        $department = Department::create($request->all());
        flashy()->success('Department Successfully Added');
        return back();
    }

    /**
     * Update department database
     */
    public function updateDepartment($id, Request $request)
    {

        $this->validate($request, [
            'name' => 'required',
            'color'=> 'required'
        ]);

        Department::findOrFail($id)->update($request->all());

        flashy()->success('Department Successfully Updated!');
        return back();
    }

    /**
    * destory data for level database
    */
    public function destroyDepartment($id)
    {
        Department::findOrFail($id)->delete();
        flashy()->info('Department Successfully deleted!');
        return back();
    }



    /**
     * Location Methods
     */
    public function allLocation()
    {
        $locations = Location::orderBy('name','ASC')->paginate(10);
        $addresses = Address::pluck('name', 'id');
        $total_company = Company::all();
        $total_department = Department::all();
        $total_location = Location::all();

        return view('settings.location', 
            compact('locations','total_company','total_department','total_location','addresses'));
    }

    /**
     * Store Locaiton to database
     */

    public function storeLocation(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:locations'
        ]);
      
        $location = Location::create($request->all());

      
        $location->addresses()->attach($request->input('address_id'));
    
        flashy()->success('Location Successfully Added');
        return back();
    }

    /**
     * Update department database
     */
    public function updateLocation(Location $location, Request $request)
    {

        $this->validate($request, [
            'name' => 'required'
        ]);
        
        Location::findOrFail($location->id)->update($request->all());
        $location->addresses()->sync( (array) $request->input('address_id'));
        
        flashy()->success('Location Successfully Updated!');
        return back();
    }

    /**
     * Delete Location database
     */

     public function destroyLocation($id)
    {
        Location::findOrFail($id)->delete();
        flashy()->info('Location Successfully deleted!');
        return back();
    }




    /**
     * Address Methods
     */
    public function allAddress()
    {
        $addresses = Address::orderBy('id','incre')->paginate(10);
        // $total_company = Company::all();
        // $total_department = Department::all();
        $total_address = Address::all();
        return view('settings.address', 
            compact('addresses','total_address'));
    }

    /**
     * Store Location to database
     */

    public function storeAddress(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:addresses'
        ]);

        $address = Address::create($request->all());
        flashy()->success('Address Successfully Added');
        return back();
    }

    /**
     * Update department database
     */
    public function updateAddress($id, Request $request)
    {

        $this->validate($request, [
            'name' => 'required|unique:addresses'
        ]);

        Address::findOrFail($id)->update($request->all());

        flashy()->success('Address Successfully Updated!');
        return back();
    }

    /**
     * Delete Address database
     */

     public function destroyAddress($id)
    {
        Address::findOrFail($id)->delete();
        flashy()->info('Address Successfully deleted!');
        return back();
    }


    public function allHead()
    {
        $heads = Head::orderBy('name','ASC')->paginate(10);
        return view('settings.head', compact('heads'));
    }


     /**
     * Store Head to database
     */

    public function storeHead(Request $request)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);

        $head = Head::create($request->all());
        flashy()->success('Head Successfully Added');
        return back();
    }

    /**
     * Update Head database
     */
    public function updateHead($id, Request $request)
    {

        $this->validate($request, [
            'name' => 'required'
        ]);

        Head::findOrFail($id)->update($request->all());

        flashy()->success('Head Successfully Updated!');
        return back();
    }

    /**
     * Delete Head database
     */

     public function destroyHead($id)
    {
        Head::findOrFail($id)->delete();
        flashy()->info('Head Successfully deleted!');
        return back();
    }


    public function allLevel()
    {
        $levels = Level::orderBy('name','ASC')->paginate(10);
        return view('settings.level', compact('levels'));
    }


     /**
     * Store Level to database
     */

    public function storeLevel(Request $request)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);

        $level = Level::create($request->all());
        flashy()->success('Level Successfully Added');
        return back();
    }

    /**
     * Update Level database
     */
    public function updateLevel($id, Request $request)
    {

        $this->validate($request, [
            'name' => 'required'
        ]);

        Level::findOrFail($id)->update($request->all());

        flashy()->success('Level Successfully Updated!');
        return back();
    }

    /**
     * Delete Level database
     */

     public function destroyLevel($id)
    {
        Level::findOrFail($id)->delete();
        flashy()->info('Level Successfully deleted!');
        return back();
    }


    public function allMaritalStatus()
    {
        $marital_statuses = MaritalStatus::orderBy('name','ASC')->paginate(10);
        return view('settings.marital_status', compact('marital_statuses'));
    }


     /**
     * Store MaritalStatus to database
     */

    public function storeMaritalStatus(Request $request)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);

        $marital_status = MaritalStatus::create($request->all());
        flashy()->success('Marital Status Successfully Added');
        return back();
    }

    /**
     * Update Level database
     */
    public function updateMaritalStatus($id, Request $request)
    {

        $this->validate($request, [
            'name' => 'required'
        ]);

        MaritalStatus::findOrFail($id)->update($request->all());

        flashy()->success('Marital Status Successfully Updated!');
        return back();
    }

    /**
     * Delete Level database
     */

    public function destroyMaritalStatus($id)
    {
        MaritalStatus::findOrFail($id)->delete();
        flashy()->info('Marital Status Successfully deleted!');
        return back();
    }


    public function allEmployeeApprovalRequest(Request $request){

        $search = $request->input('search');   
        $status = $request->input('status');   

        $employee_approval_requests = [];
        if(Entrust::hasRole('Administrator') || Entrust::hasRole('HR Staff')){
            
            $notifications = EmployeeApprovalRequest::where('status','Pending')
                                ->orderBy('created_at','desc')
                                ->count();
            session(['notifications' => $notifications]);

            if(!empty($search)){
                $employee_approval_requests = EmployeeApprovalRequest::with('employee')
                                                ->whereHas('employee', function($q) use($search){
                                                    $q->whereRaw("CONCAT(`first_name`, ' ', `last_name`) LIKE ?", ["%{$search}%"]);
                                                })
                                                ->when(!empty($status) , function($q) use($status){
                                                    return $q->where('status',$status);
                                                }) 
                                                ->orderBy('id','DESC')
                                                ->paginate(10);           
                
            }elseif(!empty($status)){
                $employee_approval_requests = EmployeeApprovalRequest::with('employee')
                                                ->where('status',$status)
                                                ->orderBy('id','DESC')
                                                ->paginate(10);
            }
            else{
                $employee_approval_requests = EmployeeApprovalRequest::with('employee')       
                                                ->orderBy('id','DESC')
                                                ->paginate(10);
            } 

            return view('settings.employee_approval_request', compact('employee_approval_requests'));

        }
        else {

            $notifications =  EmployeeApprovalRequest::with('employee')
            ->where('status','Pending')
            ->whereHas('employee', function($q){
                $q->where('user_id', '=', Auth::user()->id);
            })
            ->orderBy('created_at','desc')->count();
            session(['notifications' => $notifications]);

            if(!empty($search)){
                $employee_approval_requests = EmployeeApprovalRequest::with('employee')
                                                ->whereHas('employee', function($q){
                                                    $q->where('user_id', '=', Auth::user()->id);
                                                })
                                                ->when(!empty($status) , function($q) use($status){
                                                    return $q->where('status',$status);
                                                }) 
                                                ->orderBy('id','DESC')
                                                ->paginate(10);
            }elseif(!empty($status)){
                $employee_approval_requests = EmployeeApprovalRequest::with('employee')
                                                ->whereHas('employee', function($q){
                                                    $q->where('user_id', '=', Auth::user()->id);
                                                })
                                                ->where('status',$status)
                                                ->orderBy('id','DESC')
                                                ->paginate(10);
            }
            else{
                $employee_approval_requests = EmployeeApprovalRequest::with('employee')   
                                                ->whereHas('employee', function($q){
                                                    $q->where('user_id', '=', Auth::user()->id);
                                                })    
                                                ->orderBy('id','DESC')
                                                ->paginate(10);
            } 

            return view('settings.employee_approval_request', compact('employee_approval_requests'));
        
        }        
    }

    public function updateEmployeeApprovalRequest($id, Request $request){
        $this->validate($request, [
            'status' => 'required'
        ]);
        
        $employee_approval_requests = EmployeeApprovalRequest::where('id', '=', $id)->first();

        $employee_approved_data = [];
        if($request->status == "Approved"){
            $employee = Employee::find($employee_approval_requests->employee_id);
            $employee_data = json_decode($employee_approval_requests->employee_data);
            
            //Approved Employee Data
            $employee_approved_data['first_name'] = $employee_data->first_name ? $employee_data->first_name : $employee->first_name;
            $employee_approved_data['middle_name'] = $employee_data->middle_name ? $employee_data->middle_name : $employee->middle_name;
            $employee_approved_data['last_name'] = $employee_data->last_name ? $employee_data->last_name : $employee->last_name;
            $employee_approved_data['marital_status'] = $employee_data->marital_status;
            if(isset($employee_data->marital_status_attachment)){
                $employee_approved_data['marital_status_attachment'] = $employee_data->marital_status_attachment;
            }
            $employee_approved_data['current_address'] = $employee_data->current_address;
            $employee_approved_data['permanent_address'] = $employee_data->permanent_address;
            $employee_approved_data['phone_number'] = $employee_data->phone_number;
            $employee_approved_data['mobile_number'] = $employee_data->mobile_number;
            $employee_approved_data['contact_person'] = $employee_data->contact_person;
            $employee_approved_data['contact_relation'] = $employee_data->contact_relation;
            $employee_approved_data['contact_number'] = $employee_data->contact_number;
            $employee_approved_data['dependent'] = $employee_data->dependent;
            
            if(!empty($employee_approved_data['marital_status_attachment'])){
                $move = File::copy(public_path('files/marital_status_attachments/temps/'.$employee_approved_data['marital_status_attachment']), public_path('files/marital_status_attachments/'.$employee_approved_data['marital_status_attachment']));
            }

            if(isset($employee_approved_data['dependent'])){
                if(!empty($employee_approved_data['dependent'])){
                    foreach($employee_approved_data['dependent'] as $dependent){
                        $dependent_data = [
                            'employee_id'=>$employee->id,
                            'dependent_name'=>$dependent->dependent_name,
                            'relation'=>$dependent->relation,
                            'bdate'=>$dependent->bdate,
                            'dependent_gender'=> isset($dependent->dependent_gender) ? $dependent->dependent_gender : ''
                        ];
                        if(isset($dependent->id)){
                            if(isset($dependent->delete)){
                                if($dependent->delete == 'on'){
                                    $employee->dependents()->where('id',$dependent->id)->delete();
                                }
                            }else{
                                $employee->dependents()->where('id',$dependent->id)->update($dependent_data); 
                            }
                        }else{
                            $employee->dependents()->create($dependent_data);
                        }     
                    }
                }   
            }

            $data = $request->all();

            $employee->update($employee_approved_data);
            $employee_approval_requests->update($data);

            

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

            flashy()->success('Employee Requests has been Approved!');
            return back();
        }else{
            $employee_approval_requests->update($request->all());
            flashy()->success('Employee Requests has been Disapproved!');
            return back();
        }
      
        
        return back();
    }


    public function getDivision($id){
        $divisions = Division::where('company_id', '=', $id)->pluck('name','name');
        return json_encode($divisions);
    }
}
