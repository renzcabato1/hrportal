<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Entrust;

class EmployeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
       
        return [
       
           'company_list' => 'required',
           'department_list' => 'required',
           'location_list' => 'required',
           // 'birthplace' => 'min:3|alpha',
           // 'first_name' => 'alpha',
           // 'middle_name' => 'alpha',
           // 'last_name' => 'alpha',
           // 'name_suffix' => 'alpha',

        ];
   
    }

    public function messages()
    {
      
        return [
      
            'employee_number.required' => 'This field is required',
            'company_list.required' => 'This field is required',
            'department_list.required' => 'This field is required',
            'location_list.required' => 'This field is required',
       
        ];
  

    }
}
