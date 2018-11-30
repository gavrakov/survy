<?php

namespace App\Http\Controllers\Plan;

use Illuminate\Http\Request;
use App\Plan;
use App\PlanItem;
use Carbon\Carbon;
use \App\Http\Controllers\Controller;
use App\PlanItemList;
use Illuminate\Support\Facades\DB;



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

    		return view('plans/items_table')->with('items',$data['items'])->render();
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



    /*
    * Load item list - the list of groceries and activities
    */
    public function list(int $plan_id, int $item_id) {

        $item = PlanItem::find($item_id); 

        $data['list'] = $item->list()->orderBy(['breakfast','lunch','dinner']);

        return view('plans/items_list_load')->with('list', $data['list'])->render();

    }



    /*
    * Show modal chart for recipes
    */
    public function recipesReport(int $plan_id, int $item_id){

        $item = PlanItem::find($item_id);

        $list = $item->list()->get();
        
        return view('plans/modals/m_recipes_report')->with('list', $list)->render();

    }


     /*
    * Show modal chart for recipes
    */
    public function groceriesReport(int $plan_id, int $item_id){

        $data['list'] = DB::table('plan_item_list')
                    ->join('groceries','plan_item_list.grocery_id','=','groceries.id')
                    ->join('groceries_category','groceries.category', '=', 'groceries_category.id')
                    ->join('groceries_unite','groceries.unite', '=', 'groceries_unite.id')
                    ->select('groceries.name as name',  DB::raw('SUM(plan_item_list.price) as price'),  DB::raw('SUM(plan_item_list.quantity) as quantity'),'groceries_unite.unite as unite', 'groceries_category.icon as icon')
                    ->where('plan_item_list.item_id','=',$item_id)
                    ->groupBy('groceries.name','groceries_unite.unite','groceries_category.icon')
                    ->orderby('groceries.name')
                    ->get();

        $data['item'] = PlanItem::find($item_id);
             
        return view('plans/modals/m_groceries_report')->with('data', $data)->render();

    }



    
}
