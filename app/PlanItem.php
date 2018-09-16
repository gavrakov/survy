<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class PlanItem extends Model
{


	// Returns the breakfast data
	public function breakfast(){
			return $this->belongsTo('App\Recipe','breakfast');
	}


    // Returns the lunch data
	public function lunch(){
			return $this->belongsTo('App\Recipe','lunch');
	}


	// Returns the dinner data
	public function dinner(){
			return $this->belongsTo('App\Recipe','dinner');
	}


}
