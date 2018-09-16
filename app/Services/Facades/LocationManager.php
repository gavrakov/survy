<?php

namespace App\Services\Facades;

use Illuminate\Support\Facades\Facade;


/*
* Facade for Location Manager
*/
class LocationManager extends Facade {

	public static function getFacadeAccessor() {
		return 'LocationManager';
	}

}

?>