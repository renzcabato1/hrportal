<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model 
{
    protected $fillable = [
    	'name',
    	'address_id'
    ];

    public function employees()
    {
    	return $this->belongsToMany('App\Employee');
    }

    public function addresses()
    {
        return $this->belongsToMany('App\Address');
    
    }
}
