<?php

namespace App\Http\Controllers\Plan;

use Illuminate\Http\Request;
use App\Plan;
use App\PlanItem;
use Carbon\Carbon;
use \App\Http\Controllers\Controller;



class PlanItemController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }



	/*
	* Load items - calendar
    */
	public function index(int $id) {

    		//setlocale(LC_TIME, 'English');

    		$data['items'] = Plan::find($id)->items()->get();

    		foreach($data['items'] as $item) {
    			$f_date = new Carbon($item->date);
    			$item->date = $f_date->formatLocalized('%d %B %Y');
    		}

    		return view('plans/items')->with('items',$data['items'])->render();
    }
    
    
	

    /*
	* Show item
    */
    public function show(int $plan_id, int $item_id) {

        $item = PlanItem::find($item_id);

        $item->date = new Carbon($item->date);
        $item->date = $item->date->formatLocalized('%d %B %Y');

        $data['item'] = $item;

        return view('plans/item')->with('item',$data['item']);

    }




    
}
