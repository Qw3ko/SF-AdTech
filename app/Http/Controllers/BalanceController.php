<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BalanceController extends Controller
{
    public function topUpBalance(Request $request)
    {
        $data = $request->validate([
            "balance" => ["required", "numeric"]
        ]);

        $employer_balance = DB::table('users')
        ->where('id', '=', auth()->id())->get('balance');
        $employer_balance = json_decode($employer_balance, true);

        $balance = $employer_balance[0]['balance'] + $data["balance"];

        DB::table('users')->where('id', '=', auth()->id())->update(["balance" => $balance]);

        return redirect(route("home"));
    }
}
