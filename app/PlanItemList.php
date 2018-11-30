<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlanItemList extends Model
{

	protected $table="plan_item_list";


	//protected $fillable = ['item_id','breakfast','lunch','dinnner','grocery_id'];


    // Item
    public function item(){
    	return $this->belongsTo('App\PlanItem','item_id','id');
    }


    // Grocery
    public function grocery(){
    	return $this->belongsTo('App\Grocery','grocery_id','id');
    }


    // Breakfast
    public function breakfast(){
    	return $this->belongsTo('App\Recipe','breakfast','id');
    }

    // Lunch
    public function lunch(){
    	return $this->belongsTo('App\Recipe','lunch','id');
    }


    // Dinner
    public function dinner(){
    	return $this->belongsTo('App\Recipe','dinner','id');
    }


    


}
