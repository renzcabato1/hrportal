<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use OwenIt\Auditing\Auditable;


class Employee extends Model implements AuditableContract
{
    use Auditable;
    protected $auditIncluded = [];
    protected $auditTimestamps = true;


    protected $fillable = [
    	'employee_number',
    	'company', 
        'division',
        'department',
    	'level',
    	'location',
    	'area',
    	'last_name',
    	'first_name',
    	'middle_name',
    	'middle_initial',
        'job_remarks', // job information remarks
        'id_remarks', // identification information remarks
        'gender',
        'marital_status',
        'marital_status_attachment',
        'current_address',
    	'position',
    	'classification',
    	'status',
    	'permanent_address',
    	'phone_number',
    	'mobile_number',
    	'birthdate',
    	'birthplace',
    	'bank_name',
    	'bank_account_number',
    	'sss_number',
        'phil_number',
        'hdmf',
    	'tax_number',
    	'tax_status',
    	'contact_person',
        'contact_number',
    	'contact_relation',
        'name_suffix',
        'date_hired',
        'date_regularized',
        'date_resigned',
        'ess_ee_number',
        'avatar', // employee avatar
        'update_remark', // seperate added table
        'school_graduated',
        'school_course',
        'school_year',
        'vocational_graduated',
        'vocational_course',
        'vocational_year',
    ];

    protected $dates = [
        'date_hired',
        'birthdate',
        'date_regularized',
        'date_resigned'
    ];

    public function getFullEmailAttribute()
    {
        return ucfirst($this->first_name) .'.'. ucfirst($this->last_name);
    }

    public function getFullNameAttribute()
    {
        return ucfirst($this->first_name) .' '. ucfirst($this->last_name);
    }

    /* list date hired */
    public function setDateHiredAttribute($date)
    {
        $this->attributes['date_hired'] = Carbon::parse($date);
    }

    public function getDateHiredAttribute($date)
    {
        return Carbon::parse($date);
    }




    /* list date resigned */

    // public function setDateResignedAttribute($date)
    // {
    //     dd($date);
    //     $this->attributes['date_resigned'] =  Carbon::parse($date);
    // }
    
    // public function getDateResignedAttribute($date)
    // {
    //     return Carbon::parse($date);
    // }

    /* list birthdate */
    // public function setBirthdateAttribute($date)
    // {
    //     $this->attributes['birthdate'] = Carbon::parse($date);
    // }
    
    // public function getBirthdateAttribute($date)
    // {
    //     return new Carbon($date);
    // }

    public function getAgeRange($age = null)
    {
        switch ($age) {
            case $age >= 1 && $age <= 10:
                $check = "(1-10 YEARS OLD)";
                break;
            case $age >= 11 && $age <= 20:
                $check = "(11-20 YEARS OLD)";
                break;
            case $age >= 21 && $age <= 30:
                $check = "(21-30 YEARS OLD)";
                break;
            case $age >= 31 && $age <= 40:
                $check = "(31-40 YEARS OLD)";
                break;
            case $age >= 41 && $age <= 50:
                $check = "(41-50 YEARS OLD)";
                break;
            case $age >= 51 && $age <= 60:
                $check = "(51-60 YEARS OLD)";
                break;
            case $age >= 61 && $age <= 70:
                $check = "(61-70 YEARS OLD)";
                break;
            case $age >= 71 && $age <= 80:
                $check = "(71-80 YEARS OLD)";
                break;
            case $age >= 81 && $age <= 90:
                $check = "(81-90 YEARS OLD)";
                break;
            case $age >= 91 && $age <= 100:
                $check = "(91-100 YEARS OLD)";
                break;
            case $age >= 101 && $age <= 110:
                $check = "(101-110 YEARS OLD)";    
                break;
            case $age >= 111 && $age <= 120:
                 $check = "(111-120 YEARS OLD)";
                break;
            default:
                $check = '';
        }

        return $check;
    }

    public function getAge(){
        if($this->attributes){
            $birthdate = Carbon::parse($this->attributes['birthdate'])->age;
            return $birthdate != Carbon::now()->year ? $birthdate  : '';
        }
    }

    public function getTenure($date_hired, $differenceFormat = '%y year(s) %m month(s)' )
    {
        if($date_hired){
            $date_hired = Carbon::parse($date_hired);
            $now = Carbon::now();
            $interval = date_diff($date_hired, $now);
            return $interval->format($differenceFormat);
        }else{
            return '';
        }
    }


    /* list all user creator */

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * List from company
     */

    public function companies()
    {
        return $this->belongsToMany('App\Company')->withTimestamps();
    }

    public function getCompanyListAttribute()
    {
        return $this->companies()->pluck('id')->all();
    }

    

    public function departments()
    {
        return $this->belongsToMany('App\Department')->withTimestamps();
    }

    public function getDepartmentListAttribute()
    {
        return $this->departments()->pluck('id')->all();
    }

    public function print_id_logs()
    {
        return $this->hasMany('App\PrintIdLog');
    }


    /**
     * list all location database to employee 
     */

    public function locations()
    {
        return $this->belongsToMany('App\Location')->withTimestamps();
    }

    public function getLocationListAttribute()
    {
        return $this->locations->pluck('id')->all();
    }

    /**
     * Add dependent model to employee's model
     */
    public function dependents()
    {
        return $this->hasMany('App\Dependent');
    }

    public function assign_heads()
    {
        return $this->hasMany('App\AssignHead');
    }

    public function tag()
    {
        return $this->hasOne('App\Tag');
    }

}
