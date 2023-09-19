<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class ChartsController extends Controller
{
    public function handleChart($id)
    {
        $offerData = DB::table('offers')
        ->where('id', '=', $id)
        ->value('transition_cost');

        return view('charts', compact('offerData'));
    }
}
