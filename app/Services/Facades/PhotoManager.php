<?php

namespace App\Services\Facades;

use Illuminate\Support\Facades\Facade;


class PhotoManager extends Facade {

	public static function getFacadeAccessor() {
		return 'PhotoManager';
	}
}


?>