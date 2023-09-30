<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UserController extends Controller
{
    public function disableUser(Request $id)
    {
        if(DB::table('users')->where('id', '=', $id["id"])->value('active') == 0) 
        {
            DB::table('users')
            ->where('id', '=', $id["id"])
            ->update(['active' => 1, 'updated_at' => Carbon::now()]);
        } else
        {
            DB::table('users')
            ->where('id', '=', $id["id"])
            ->update(['active' => 0, 'updated_at' => Carbon::now()]);
        }

        return redirect(route("home"));
    }
}
