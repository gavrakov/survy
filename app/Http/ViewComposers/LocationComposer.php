<?php
namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Country;


Class LocationComposer {



	public $location;



	/**
     * Create a location composer.
     *
     * @return void
     */
	public function __construct(){
            $this->location = session()->has('location') !== null  ? Country::find(session('location')) : null;
	}


	/**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */

	public function compose(View $view){
		$view->with('location', $this->location);

	}
}