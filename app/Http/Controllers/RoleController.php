<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function isRoleExist($role)
    {
        return Role::where('name', '=', $role)->count() > 0;
    }
}
