<?php

namespace App\Models;

use Mindscms\Entrust\EntrustPermission;

class Permission extends EntrustPermission
{
    protected $table = 'permissions';
    protected $guarded = [];

}
