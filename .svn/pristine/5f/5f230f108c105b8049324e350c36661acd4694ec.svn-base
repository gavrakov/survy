<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database;

class Location extends Model
{

	protected $table="Locations";


	// Grocery model
    protected $fillable = ['country_id','user_id','active'];

    /**
     * Get the country for the location.
     */
    public function country()
    {
        return $this->belongsTo('App\Country','country_id','id');
    }


    

}
