<?php

namespace App\Http\Controllers\Plan;

use \App\Http\Controllers\Controller;
use App\Http\Requests\CreatePlanRequest;
use App\Http\Requests\UpdatePlanRequest; 
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Country;
use Carbon\Carbon;
use App\Plan;
use App\PlanItem;
use App\Recipe;
use Auth;
use Validator;
use Illuminate\Support\Facades\DB;
use App\RecipeCategoriesRelation;
use App\RecipesCategory;



class PlanController extends Controller
{
    

    // Counstructor
    public function __constuct(){
        $this->middleware('auth'); 
        $this->middleware('location');
    }




    // Index
    public function index() {

        // Location je prosledjena preko view composera
        $active = Plan::getActive(); 
    	return view('plans/plans')->with('active',$active);
    }




    /*
	* Show modal for createing plan
    */
    public function create() {
        // Ovo nece trebati
    	return view('plans/modals/m_create_plan')->render();

    }



    /*
	* Store plan into the database
    */
    public function store(CreatePlanRequest $request) {

    	$plan = new Plan;
    	$plan->name = $request->input('name');
    	$plan->date_from = new Carbon($request->input('date_from'));
    	$plan->date_to = new Carbon($request->input('date_to'));
    	$plan->description = $request->input('description');
    	$plan->user_id = Auth::user()->id;
    	$plan->persons = $request->input('persons');


    	if(session()->has('location')) {
    		$plan->country_id = $request->session()->get('location');
    	}

    	$plan->save();

    	// Save plan items
    	if (isset($plan->id)) {
    		$plan->saveItems();
    	}
    	
    	if($request->ajax()) {
                return response()->json(['id',$plan->id], 200);
        }


    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {

    	if(!isset($id)) {
            return redirect('/plans');
        }

    	$data['plan'] = Plan::find($id);
        $data['today'] = $data['plan']->todayItem()->first();

        return view('plans/plan')->with('data',$data);
        
    }



      /*
    * Edit form for plan detals
    */
    public function edit(int $id) {


        if(!isset($id)) {
            return redirect('/plans');
        }

        $data['plan'] = Plan::find($id);
        return view('plans/modals/m_edit_plan')->with('plan',$data['plan']);

    }



    /*
    * Update plan data
    */
    public function update(UpdatePlanRequest $request, int $id) {

        $plan = Plan::find($id);

        // Update - name, description, persons
        $plan->name = $request->input('name');
        $plan->description = $request->input('description');
        $plan->persons = $request->input('persons');


        if(session()->has('location')) {
            $plan->country_id = $request->session()->get('location');
        }

        $plan->save();

        if($request->ajax()) {
                return response()->json(['plan',$plan], 200);
        }

    }




    /**
     * Load and search all plans
     */
    public function load(Request $request) {

       
        $data['plans'] = Plan::where('country_id',session('location'))->orderBy('id','desc')->paginate(5);

        // Ajax
        if($request->ajax()) {
            return view('plans/plans_load')->with('plans',$data['plans'])->render();
        }

        // Ako nije ajax
        return redirect()->route('plans');
 
    }





    /**
     * Load and search all plans
     */
    public function search(Request $request) {

       
        if ($request->search == '') {
            $data['plans'] = Plan::where('country_id',session('location'))->orderBy('id','desc')->paginate(5);
        } else {
            $data['plans'] = Plan::where([
                ['country_id',session('location')], 
                ['name','LIKE','%' . $request->search . '%']
            ]

            )->orderBy('id','desc')->paginate(5);
        }
        

        // Ajax
        if($request->ajax()) {
            return view('plans/plans_load')->with('plans',$data['plans'])->render();
        }

        // Ako nije ajax
        return redirect()->route('plans');
 
    }



    /*
    * Notification about location
    */
    public function notiflocation() {
        return view('plans/notification');
    }






}
