<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use OwenIt\Auditing\Auditable;

class Department extends Model implements AuditableContract
{
    use Auditable;
    protected $auditIncluded = [];
    protected $auditTimestamps = true;

    protected $fillable = [
        'name',
        'color'
    ];

    public function employees()
    {
    	return $this->belongsToMany('App\Employee');
    }
}
