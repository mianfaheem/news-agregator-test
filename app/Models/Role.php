<?php

namespace App\Models;

use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    protected $guard_name = 'api';

    protected $fillable = [
        'name', 
        'guard_name',
        'added_by',
    ];
    public function addedBy()
    {
        return $this->belongsTo(User::class, 'added_by');
    }
}
