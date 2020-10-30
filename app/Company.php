<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use OwenIt\Auditing\Auditable;

class Company extends Model implements AuditableContract
{

    use Auditable;
    protected $auditIncluded = [];
    protected $auditTimestamps = true;

    protected $fillable = [
    	'name',
    	'domain'
    ];

    public function employees()
    {
    	return $this->belongsToMany('App\Employee');
    }

    public function divisions()
    {
    	return $this->hasMany('App\Division');
    }
}
