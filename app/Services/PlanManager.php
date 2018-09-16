<?php

namespace App\Services;

use App\Location;
use App\Country;
use App\Plan;
use Auth;


/*
* Plan manager service
*/
class PlanManager {



	/*
	* Check is there any active plan
	*/
	public function isActive(){
		return Plan::isActive();
	}



	/*
	* Returns active plan
	*/
	public function getActive(){
		return $this->isActive() ? Plan::getActive() : null;

	}



	/*
	* Returns todays items
	*/
	public function today() {
		return $this->getActive()->todayItem()->first();

	}

}




?>