<?php

namespace App\Models;

use Mindscms\Entrust\EntrustRole;

class Role extends EntrustRole
{
    protected $table = 'roles';
    
    protected $guarded = [];
}


