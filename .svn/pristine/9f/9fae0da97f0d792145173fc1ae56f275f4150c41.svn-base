<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Location;
use Auth;
use App\Plan;
use App\PlanItem;
use Carbon\Carbon;
use App\Country;
use \LocationManager;
use \PlanManager;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $data['breakfast'] = null;
        $data['lunch'] = null;
        $data['dinner'] = null;


        // Ovo bi trebalo negde da se izvrsi a da nije ovde
       LocationManager::set();

      //dd(PlanManager::today()->breakfast());


        if(LocationManager::isActive()) {

            
            $plan = Plan::getActive();

         
            if ($plan !== null) {

                $item = $plan->todayItem()->first();

                if($item !== null) {

                    $data['breakfast'] = $item->breakfast()->first();
                    $data['lunch'] = $item->lunch()->first();
                    $data['dinner'] = $item->dinner()->first();
                } 

            }
        }


     
      
        //dd($data['breakfast']);

        //dd(Carbon::nOw()->format('Y-m-d')); - MORA DA CUVA DATUM DRZAVE ZA KOJU SE RADI PLAN
      return view('home/home')->with('data',$data);
    }
}
