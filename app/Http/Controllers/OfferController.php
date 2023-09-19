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
            $query = DB::table('offers')
            ->where('id', '=', $id);
            $query->increment('number_of_transitions');

            return Redirect::to($offer_url);
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

        $offers_of_webmasters = DB::table('offers_of_user')->get();

        return view('home', ['offers' => $offers, 'offers_of_webmasters' => $offers_of_webmasters, 'i' => $i, 'e' => $e]);
    }
}
