<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Dependent extends Model
{
    protected $fillable  = [
    	'dependent_name',
        'dependent_gender',
    	'bdate',
        'relation'
    ];

    protected $dates = [
    	'bdate'
    ];

    /**
     * Connect to employee's model data
     */
    public function employee()
    {
    	return $this->belongsTo('App\Employee');
    }

    /**
     * configure date function
     */
    public function setBdateAttribute($date)
    {
    	$this->attributes['bdate'] = Carbon::parse($date);
    }

    public function getBdateAttribute($date)
    {
    	return Carbon::parse($date);
    }
}
