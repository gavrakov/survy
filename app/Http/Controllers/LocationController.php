<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Location;
use App\Country;
use Auth;
use Illuminate\Support\Facades\DB;
use Validator;


class LocationController extends Controller
{
   
   // Counstructor
    public function __constuct(){
        $this->middleware('auth'); 
    }



    // Index
    public function index(){

    	$data['countries'] = Country::all();
    	return view('locations/locations')->with('countries',$data['countries']);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    	$input_data = $request->all();

    	$user = Auth::user();

    	//$this->validate($request,['f_country' => "required|unique:locations,country_id,null,id,user_id,{$user->id}"]);

    	// Ovde sam se napatio, ovo je uslov da proverava samo za jednog korisnika
        $validator = Validator::make($input_data,[
            'country' => "required|unique:locations,country_id,null,id,user_id,{$user->id}"
        ]);


        if ($validator->fails()) {
            return response()->json(array( 'success' => false, 'errors' => $validator->errors()),400); 
        }

        $location = new Location();
        $location->country_id = $request->input('country');
        $location->user_id = Auth::user()->id;
        $location->active = 1;

        // Samo jedna lokacije boze biti aktivna
        DB::table('locations')->where('user_id',Auth::user()->id)->update(['active' => 0]);

        $location->save();


         // Unset location from the session if it exists
        if($request->session()->has('location')) {
            $request->session()->forget('location');
        }


        // Set location into the session
        $request->session()->put('location',$location->country_id);


        if($request->ajax()) {
                return response()->json(['success' => 'success'], 200);
        }

        return redirect::to('locations/')->with('message','Location successfully inserted');
    }




     /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $location = Location::find($id);
       	$location->active = 1;

       	// Samo jedna lokacije boze biti aktivna
        DB::table('locations')->where('user_id',Auth::user()->id)->update(['active' => 0]);

         // Set location into the session
        $request->session()->put('location',$location->country_id);

        $location->save();

        if($request->ajax()) {
                return response()->json(['success' => 'success'], 200);
        }

        return redirect::to('locations/')->with('message','Location successfully changed');

    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $location = Location::find($id);

        // Ako je lokacija setovana kao aktivna i ako senalazi u sesiji, brisemo je iz sesije
        if ($location->active == 1 && session('location') == $location->country_id) {
        	session()->forget('location');
        }
        
        $location->delete();

        return response()->json(['success' => 'success'], 200);

    }



    /**
     * Load all plan locations
     */
    public function load(Request $request) {

        $data['locations'] = Location::where('user_id',Auth::user()->id)->orderBy('id','desc')->paginate(10);


        // Ajax
        if($request->ajax()) {
            return view('locations/locations_load')->with('locations',$data['locations'])->render();
        }

        // Non ajax
        return view('locations/locations')->with('locations',$data['locations']);
 
    }



    /*
	* Finds country by id
    */
    public function country() {

    	$data['countries'] = '';

    	if (session()->has('location')) {
    		$data['countries'] = Country::find(session('location'));
    	}

        return response()->json($data['countries'], 200);

    }
}
