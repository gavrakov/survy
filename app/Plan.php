<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\PlanItem;
use Carbon\Carbon;
use Auth;
use App\Location;
//use App\Services\LocationManager;


class Plan extends Model
{

   /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','date_from','date_to','persons','description'
    ];


      /**
     * Get all groceries for the recipe.
     */
    public function items() {
        return $this->hasMany('App\PlanItem');
    }



    /*
    *  Save items for plan - days
    */
    public function saveItems() {

        $date = $this->date_from;

        while($date <= $this->date_to) {

                $item = new PlanItem();
                $item->plan_id = $this->id;
                $item->date = new Carbon($date);
                $item->save();

                $date = $date->addDays(1);

        }
    }



    /*
    * Check if there is any active plan
    */
    public static function isActive() {

        $country_id = null;
        $plan = null;

        if (\LocationManager::isActive()) {
            $country_id = \LocationManager::getActive();
        }

        
        if ($country_id !== null) {
             $plan = Plan::where([
            ['user_id',Auth::user()->id],
            ['country_id',$country_id],
            ['date_from','<=',Carbon::now()->format('Y-m-d')],
            ['date_to', '>=', Carbon::now()->format('Y-m-d')]

            ])->first();

        }

        return ($plan !== null) ? true : false;      

    }



    /*
    * Get active plan for the location
    */
    public static function getActive() {

        $location = Location::where([['user_id',Auth::user()->id],['active',1]])->first();

        $plan = null;
        
        if ($location !== null) {
             $plan = Plan::where([
            ['user_id',Auth::user()->id],
            ['country_id',$location->country_id],
            ['date_from','<=',Carbon::now()->format('Y-m-d')],
            ['date_to', '>=', Carbon::now()->format('Y-m-d')]

        ])->first();

        }
       


        return $plan;
    }



    /*
    * Get plan by date
    */
    public function todayItem() {
       return $this->hasMany('App\PlanItem')->where('date',Carbon::now()->format('Y-m-d'));
    }



    /*
    * Returns formated date from
    */
    public function dateFrom() {
        $date_from = new Carbon($this->date_from);
        $date_from = $date_from->formatLocalized('%d %B %Y');
        return $date_from;
    }



    /*
    * Returns formated date to
    */
    public function dateTo() {
        $date_to = new Carbon($this->date_to);
        $date_to = $date_to->formatLocalized('%d %B %Y');
        return $date_to;
    }


   
}
