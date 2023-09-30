<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class OfferController extends Controller
{
    public function createOffer(Request $request) 
    {
        $data = $request->validate([
            "offer-name" => ["required", "string"],
            "transition-cost" => ["required", "numeric"],
            "target-url" => ["required", "url"],
            "site-theme" => ["required", "string"]
        ]);

        Offer::create([
            "employer_id" => auth()->id(),
            "name" => $data["offer-name"],
            "transition_cost" => $data["transition-cost"],
            "target_url" => $data["target-url"],
            "site_theme" => $data["site-theme"],
            "active" => 1,
        ]);

        return redirect(route("home"));
    }

    public function disableOffer(Request $id)
    {

        if(DB::table('offers')->where('id', '=', $id["id"])->value('active') == 0) 
        {
            DB::table('offers')
            ->where('id', '=', $id["id"])
            ->update(['active' => 1, 'updated_at' => Carbon::now()]);
        } else
        {
            DB::table('offers')
            ->where('id', '=', $id["id"])
            ->update(['active' => 0, 'updated_at' => Carbon::now()]);
        }

        return redirect(route("home"));
    }

    public function signUpOffer(Request $id)
    {
        $user_id = auth()->id();
        $user_offer = DB::table('offers_of_user')->where([
            ['user_id', '=', $user_id],
            ['offer_id', '=', $id["id"]],
        ]);

        if($user_offer->exists())
        {
            $user_offer->delete();
            
            $query = DB::table('offers')
            ->where('id', '=', $id["id"]);
            $query->decrement('number_of_subscribers');
        } else
        {
            DB::table('offers_of_user')->insert([
                'offer_id' => $id["id"],
                'user_id' => auth()->id()
            ]);

            $query = DB::table('offers')
            ->where('id', '=', $id["id"]);
            $query->increment('number_of_subscribers');
        }
        
        return redirect(route("home"));    
    }

    public function redirect($id)
    {
        $offer_is_active = DB::table('offers')->where('id', '=', $id)->value('active');
        $offer_url = DB::table('offers')->where('id', '=', $id)->value('target_url');
        $user_id = DB::table('offers_of_user')->where('offer_id', '=', $id)->get('user_id');
        $user_id = json_decode($user_id, true);
        if($user_id !== [])
        {
            $user_offer = DB::table('offers_of_user')->where([
                ['user_id', '=', $user_id[0]],
                ['offer_id', '=', $id],
        ]);

        if($user_offer->exists() && $offer_is_active === 1)
        {
            $employer_id = DB::table('offers')
            ->where('id', '=', $id)->get('employer_id');
            $employer_id = json_decode($employer_id, true);


            $transition_cost = DB::table('offers')
            ->where('id', '=', $id)->get('transition_cost');
            $transition_cost = json_decode($transition_cost, true);

            $employer_balance = DB::table('users')
            ->where('id', '=', $employer_id[0])->get('balance');
            $employer_balance = json_decode($employer_balance, true);

            $webmaster_balance = DB::table('users')
            ->where('id', '=', auth()->id())->get('balance');
            $webmaster_balance = json_decode($webmaster_balance, true);

            $sys_balance = DB::table('users')
            ->where('id', '=', 1)->get('balance');
            $sys_balance = json_decode($sys_balance, true);


            if($employer_balance[0]['balance'] > $transition_cost[0]['transition_cost'])
            {
                $employer_balance = $employer_balance[0]['balance'] - $transition_cost[0]['transition_cost'];

                $percent = $transition_cost[0]['transition_cost'] / 100 * 20;

                $sys_balance = $sys_balance[0]['balance'] + $percent;

                $user_percent = $transition_cost[0]['transition_cost'] - $percent;

                $webmaster_balance = $webmaster_balance[0]['balance'] + $user_percent;

                DB::table('users')->where('id', '=', 1)->update(['balance' => $sys_balance]);

                DB::table('users')->where('id', '=', auth()->id())->update(['balance' => $webmaster_balance]);

                DB::table('users')->where('id', '=', $employer_id[0]['employer_id'])->update(['balance' => $employer_balance]);

                $query = DB::table('offers')
                ->where('id', '=', $id);
                $query->increment('number_of_transitions');

                return Redirect::to($offer_url);
            }
            
            return redirect(route("404"));
            
        }
        return redirect(route("404"));
        }
        
        return redirect(route("404"));
    }

    public function index()
    {
        $i = 0;
        $e = 0;

        $offers = DB::table('offers')->get();

        $users = DB::table('users')->get();

        $offers_of_webmasters = DB::table('offers_of_user')->get();

        $current_balance = DB::table('users')->where('id', '=', auth()->id())->get();

        $sum_transitions =  $offers->sum('number_of_transitions');

        $sum_urls =  $offers->sum('number_of_subscribers');

        return view('home', ['offers' => $offers, 'users' => $users, 'offers_of_webmasters' => $offers_of_webmasters, 'sum_transitions' => $sum_transitions, 'sum_urls' => $sum_urls, 'current_balance' => $current_balance, 'i' => $i, 'e' => $e]);
    }
}
