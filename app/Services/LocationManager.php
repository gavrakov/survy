<?php 
namespace App\Services;

use App\Location;
use App\Country;
use Illuminate\Support\Facades\Auth;



class LocationManager {



	/*
	* Session key for the location model
	*/
	protected $key;



	/*
	* Constructor
	*/ 

	function __construct(string $key) {

		$this->key = $key;
		
	}



	/*
	* Put the location into the session
	*/
	public function put($id) {
	
		session()->put('location',$id);
		//session(['location' => $id]);
	}



	/*
	* Delete location from the session
	*/
	public function forget() {
		session()->forget($this->key);
	}



	/*
	* Get the country model from the session.
	*/
	public function country(){
		return Country::find(session($this->key));
	}



	/*
	* Check if location is active
	*/
	public function isActive() {
		return session()->has($this->key);
	}



	/*
	* Returns the country_id of the active location
	*/
	public function getActive() {
		return $this->isActive() ? session($this->key) : null;

	}



	/*
	* Get active location model
	* returns Location or null if no location
	*/
	public function location() { // OVO NE RADI

		if(Auth::check()) {
			return Location::where([['user_id',Auth::id()],['active',1]])->first();
		}

		return null;
		
	}



	/*
	* Set active location from database, put the location into the session
	*/
	public function set() {

		if (!$this->isActive() && $this->location() !== null) {

			$location = $this->location()->country_id;

			$this->put($location);	
		} 

	}


}



?>