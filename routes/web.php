<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return redirect('home');
})->middleware('auth');


Auth::routes();
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');


Route::group(['middleware' => ['auth']], function() {
	
Route::get('/home', 'HomeController@index');
Route::get('/totalUpdate', 'HomeController@totalUpdate');
Route::get('/remarks', 'HomeController@remarks');


Route::get('/activities','ActivityController@index');
Route::get('/generateActivities','ActivityController@generateActivities');


// Route::resource('employees','EmployeesController');


Route::get('employees',['as'=>'employees.index','uses'=>'EmployeesController@index']);
Route::get('employees/create',['as'=>'employees.create','uses'=>'EmployeesController@create','middleware' => ['role:Administrator|HR Staff']]);
Route::post('employees',['as'=>'employees.store','uses'=>'EmployeesController@store','middleware' => ['role:Administrator|HR Staff']]);
Route::get('employees/{employee}',['as'=>'employees.show','uses'=>'EmployeesController@show']);
Route::get('employees/{employee}/edit',['as'=>'employees.edit','uses'=>'EmployeesController@edit']);
Route::patch('employees/{employee}',['as'=>'employees.update','uses'=>'EmployeesController@update']);
Route::delete('employees/{employee}',['as'=>'employees.destroy','uses'=>'EmployeesController@destroy','middleware' => ['role:Administrator|HR Staff']]); 
Route::get('employees/{employee}/print_id',['as'=>'employees.print_id','uses'=>'EmployeesController@print_id','middleware' => ['role:Administrator Printer']]);
Route::post('employees/add_print_log',['as'=>'employees.add_print_log','uses'=>'EmployeesController@add_print_log','middleware' => ['role:Administrator Printer']]);
Route::get('employees/{employee}/tag',['as'=>'employees.tag','uses'=>'EmployeesController@tag','middleware' => ['role:Administrator|HR Staff']]);
Route::get('employees/{employee}/untag',['as'=>'employees.untag','uses'=>'EmployeesController@untag','middleware' => ['role:Administrator|HR Staff']]);

Route::get('employees/new_print_id/{employee}',['as'=>'employees.new_print_id','uses'=>'EmployeesController@new_print_id','middleware' => ['role:Administrator Printer']]);
Route::get('employees/old_print_id/{employee}',['as'=>'employees.old_print_id','uses'=>'EmployeesController@old_print_id','middleware' => ['role:Administrator Printer']]);
// Verify Account Number
Route::post('verify-account-number/{employee}',['as'=>'employees.verify_account_number','uses'=>'EmployeesController@verify_account_number']);

Route::get('get_id_remarks/{employee}',['as'=>'employees.get_id_remarks','uses'=>'EmployeesController@get_id_remarks','middleware' => ['role:Administrator|HR Staff']]);

Route::get('organizational_chart/{employee}',['as'=>'employees.organizational_chart','uses'=>'EmployeesController@organizational_chart','middleware' => ['role:Administrator|HR Staff']]);


// Route::resource('users','UserController');
Route::resource('roles','RoleController');


Route::get('users',['as'=>'users.index','uses'=>'UserController@index','middleware' => ['role:Administrator|HR Staff']]);
Route::get('users/create',['as'=>'users.create','uses'=>'UserController@create','middleware' => ['role:Administrator|HR Staff']]);
Route::post('users',['as'=>'users.store','uses'=>'UserController@store','middleware' => ['role:Administrator|HR Staff']]);
Route::get('users/{user}',['as'=>'users.show','uses'=>'UserController@show']);
Route::get('users/{user}/edit',['as'=>'users.edit','uses'=>'UserController@edit']);
Route::patch('users/{user}',['as'=>'users.update','uses'=>'UserController@update']);
Route::delete('users/{user}',['as'=>'users.destroy','uses'=>'UserController@destroy','middleware' => ['role:Administrator|HR Staff']]); 


// Route::get('roles',['as'=>'roles.index','uses'=>'RoleController@index','middleware' => ['permission:role-list|role-create|role-edit|role-delete']]);
// Route::get('roles/create',['as'=>'roles.create','uses'=>'RoleController@create','middleware' => ['permission:role-create']]);
// Route::post('roles/create',['as'=>'roles.store','uses'=>'RoleController@store','middleware' => ['permission:role-create']]);
// Route::get('roles/{id}',['as'=>'roles.show','uses'=>'RoleController@show']);
// Route::get('roles/{id}/edit',['as'=>'roles.edit','uses'=>'RoleController@edit','middleware' => ['permission:role-edit']]);
// Route::patch('roles/{id}',['as'=>'roles.update','uses'=>'RoleController@update','middleware' => ['permission:role-edit']]);
// Route::delete('roles/{id}',['as'=>'roles.destroy','uses'=>'RoleController@destroy','middleware' => ['permission:role-delete']]); 



Route::get('importExport', 'MaatwebsiteDemoController@importExport');
Route::get('downloadExcel/{type}', 'MaatwebsiteDemoController@downloadExcel');
Route::post('importExcel', 'MaatwebsiteDemoController@importExcel');

/**
 * companies routes
 */
Route::get('company', 'SettingsController@allCompany')->name('company');
Route::post('company','SettingsController@storeCompany');
Route::delete('company/{id}', 'SettingsController@destroyCompany');
Route::patch('company/{id}','SettingsController@updateCompany');

Route::get('get_division/{id}', 'SettingsController@getDivision')->name('division');

/**
 * Department routes
 */
Route::get('department','SettingsController@allDepartment');
Route::post('department','SettingsController@storeDepartment');
Route::delete('department/{id}','SettingsController@destroyDepartment');
Route::patch('department/{id}', 'SettingsController@updateDepartment');


/**
 * Location routes
 */
Route::get('location', 'SettingsController@allLocation');
Route::post('location','SettingsController@storeLocation');
Route::delete('location/{id}','SettingsController@destroyLocation');
Route::patch('location/{location}','SettingsController@updateLocation');


/**
 * Address routes
 */
Route::get('address', 'SettingsController@allAddress');
Route::post('address','SettingsController@storeAddress');
Route::delete('address/{id}','SettingsController@destroyAddress');
Route::patch('address/{id}','SettingsController@updateAddress');

/**
 * Head routes
 */
Route::get('head', 'SettingsController@allHead');
Route::post('head','SettingsController@storeHead');
Route::delete('head/{id}','SettingsController@destroyHead');
Route::patch('head/{id}','SettingsController@updateHead');

/**
 * Level routes
 */
Route::get('level', 'SettingsController@allLevel');
Route::post('level','SettingsController@storeLevel');
Route::delete('level/{id}','SettingsController@destroyLevel');
Route::patch('level/{id}','SettingsController@updateLevel');

/**
 * MaritalStatus routes
 */
Route::get('marital_status', 'SettingsController@allMaritalStatus');
Route::post('marital_status','SettingsController@storeMaritalStatus');
Route::delete('marital_status/{id}','SettingsController@destroyMaritalStatus');
Route::patch('marital_status/{id}','SettingsController@updateMaritalStatus');

/**
 * Employee Approval Request
 */
Route::get('employee_approval_request', 'SettingsController@allEmployeeApprovalRequest');
Route::patch('employee_approval_request/{id}','SettingsController@updateEmployeeApprovalRequest');

/**
 * Companies routes
 */

Route::get('employees/api/companies', function() {
	return App\Company::latest()->get();
});

Route::get('employees/companies/{domain}', function($domain) 
{
    return App\Company::where('domain', $domain)->first();
});


Route::get('new_employee_number', function() 
{
    $all_employee =  App\Employee::with('companies')->where('status','Active')->orderBy('date_hired','ASC')->get();

    $generated_employee = [];
    foreach($all_employee as $key => $employee){
        $generated_employee[$key]['id'] = $employee['id'];
        if($employee['companies'][0]['code'] && $employee['date_hired']){
            $company = $employee['companies'][0]['code'];
            $month = $employee['date_hired'] ? date('m',strtotime($employee['date_hired'])) : '0000';
            $year = $employee['date_hired'] ?  date('Y',strtotime($employee['date_hired'])) : '00';
            $number =  str_pad($key+1, 4, '0', STR_PAD_LEFT); 
            $created = date('Y-m-d',strtotime($employee['date_hired']));

            $generated_employee[$key]['new_employee_number'] = $company . '-' . $year . '-' . $month . '-' . $number;  
        }
        else
        {
            $generated_employee[$key]['new_employee_number'] = 'XXXX-XXXX-XX-XXXX';  
        }
        
    }
    return $generated_employee;
});




});
