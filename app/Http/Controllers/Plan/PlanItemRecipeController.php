<?php

namespace App\Http\Controllers\Plan;

use Illuminate\Http\Request;
use App\Plan;
use \App\PlanItem;
use App\RecipesCategory;
use Carbon\Carbon;
use \App\Recipe;
use \App\Http\Controllers\Controller;
use App\PlanItemList;



class PlanItemRecipeController extends Controller
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
	* Load modal recipe
    */
    public function index(int $plan_id, int $item_id, int $category) {
        $data = [];
        $data['category'] = $category;
        $data['item'] = $item_id;
        $data['plan'] = $plan_id;
        return view('plans/modals/m_breakfast')->with('data', $data)->render();

    		
    }


    /*
	* Show recipes
    */
    public function show(int $plan_id, int $item_id, int $category) {

        $data['item'] = PlanItem::find($item_id);
        $data['category'] = $category;

        switch($category) {
            case 1:
                $data['recipe'] = Recipe::find($data['item']->breakfast);
                break;
            case 2:
                $data['recipe'] = Recipe::find($data['item']->lunch);
                break;
            case 3:
                $data['recipe'] = Recipe::find($data['item']->dinner);
                break;

            default:
                return response()->json(array('error' => 'Unnoungh recipe category'), 401);
        }
       

        if(session()->has('location') !== null) {
            $data['location'] = \App\Country::find(session('location'));
        }

        return view('plans/show_recipe')->with('data',$data);

    }



    /*
    * Insert recipe into the plan item.
    */
    public function add(Request $request, int $plan_id, int $item_id, int $category) {

        $item = PlanItem::find($item_id);
        $recipe = Recipe::find($request->input('f_recipe'));


        switch($category) {
            case 1:
                $item->breakfast = $recipe->id;
                $item->save();
                $item->addBreakfastToList();
                break;
            case 2:
                $item->lunch = $recipe->id;
                $item->save();
                $item->addLunchToList();
                break;
            case 3:
                $item->dinner = $recipe->id;
                $item->save();
                $item->addDinnerToList();
                break;

            default:
                return response()->json(array('error' => 'Unnoungh recipe category'), 401);
        }
                
        return response()->json(array('success' => 'The recipe has successfully added'), 200);
    }



    /*
    * Load all recipes depends on category
    */
    public function load(int $plan_id, int $item_id, int $category) {

        $req = '';

        $data['recipes'] = RecipesCategory::find($category)->myRecipes($req)->orderBy('id','desc')->paginate(5);;

        if(session()->has('location') !== null) {
            $data['location'] = \App\Country::find(session('location'));
        }

        $data['item'] = PlanItem::find($item_id);
        $data['category'] = $category;
        $data['plan'] = $plan_id;

        return view('plans/modals/m_recipes_load')->with('data', $data)->render();
    }



    /*
    * Remove recipe from the plan
    */
    public function destroy(int $plan_id, int $item_id, int $category) {

        $item = PlanItem::find($item_id);

        switch($category) {
            case 1:
                $item->removeBreakfastFromList();
                $item->breakfast = null;
                break;
            case 2:
                $item->removeLunchFromList();
                 $item->lunch = null;
                break;
            case 3:
                $item->removeDinnerFromList();
                 $item->dinner = null;
                break;

            default:
                return response()->json(array('error' => 'Unnoungh recipe category'), 401);
        }

        $item->save();

        return response()->json(array('success' => 'The recipe has successfully removed'), 200);
    }



     /**
     * Search recipes
     * 
     * @param Illuminate\Http\Request
     * @return Illuminate\Http\Response
     */
    public function search(Request $request, int $plan_id, int $item_id, int $category) {

        if($request->ajax()) {
            $data['recipes'] = RecipesCategory::find($category)->myRecipes($request->search)->paginate(3);     
        }

        if(session()->has('location') !== null) {
            $data['location'] = \App\Country::find(session('location'));
        }

        $data['item'] = PlanItem::find($item_id);
        $data['category'] = $category;
        $data['plan'] = $plan_id;

        return view('plans/modals/m_recipes_load')->with('data', $data)->render();

    }


}
