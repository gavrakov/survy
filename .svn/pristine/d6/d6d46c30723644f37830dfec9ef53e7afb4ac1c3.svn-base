<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class GroceriesPrices extends Model
{
    
    // Groceries prices model

    use Notifiable;


    public $table = "groceries_prices";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'grocery_id','quantity','price','country_id'
    ];


    public function grocery()
    {
        return $this->belongsTo('App\Grocery','grocery_id','id')->where('country_id',session('location'));
    }


    public function country()
    {
        return $this->belongsTo('App\Country','country_id','id');
    }


}
