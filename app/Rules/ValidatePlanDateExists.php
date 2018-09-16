<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Auth;
use App\Plan;
use Carbon\Carbon;

class ValidatePlanDateExists implements Rule
{

    protected $date_to;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($date_to)
    {
        //
        $this->date_to = $date_to;
       
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
      
       return $this->checkDates($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'There is a plan with a date in that period.';
    }



    /*
    * Check dates
    */
    public function checkDates($date_from) {


        $starts = new Carbon($date_from);
        $ends = new Carbon($this->date_to);

        // Nije dobro
        $plan_count = Plan::where(function($query) use ($starts, $ends) {
            $query->where(function($query) use ($starts, $ends) {
                $query->where('date_from', '>=', $starts)
                        ->where('date_to', '<', $ends)
                        ->where('user_id', '=', Auth::user()->id)
                        ->where('country_id', '=', session('location'));
            })
            ->orWhere(function($query) use ($starts, $ends) {
                $query->where('date_from', '<', $ends)
                        ->where('date_to', '>=', $ends)
                        ->where('user_id', '=', Auth::user()->id)
                        ->where('country_id', '=', session('location'));
            })
            ->orWhere(function($query) use ($starts, $ends) {
                $query->where('date_from', '<', $starts)
                        ->where('date_to', '>=', $starts)
                        ->where('user_id', '=', Auth::user()->id)
                        ->where('country_id', '=', session('location'));

            });

        })->count();

       // dd($plan_count)


        return $plan_count > 0 ? false : true;
    }
}
