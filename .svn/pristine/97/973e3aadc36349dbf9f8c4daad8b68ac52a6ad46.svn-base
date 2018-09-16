<?php

namespace App\Http\Controllers\Plan;

use Illuminate\Http\Request;
use App\Plan;
use \App\PlanItem;
use App\RecipesCategory;
use Carbon\Carbon;
use \App\Recipe;
use \App\Http\Controllers\Controller;



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
	* Show breakfast
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
    * Add recipe to the item - OVO JE PITANJE, DA LI CE INSERTOVANJE RECEPTA ICI OVDE ILI U KONTROLORU ZA RECEPTE
    */
    public function add(Request $request, int $plan_id, int $item_id, int $category) {


      //  dd($request->input('f_recipe'));

        $item = PlanItem::find($item_id);
        $recipe = Recipe::find($request->input('f_recipe'));

        switch($category) {
            case 1:
                $item->breakfast = $recipe->id;
                break;
            case 2:
                $item->lunch = $recipe->id;
                break;
            case 3:
                $item->dinner = $recipe->id;
                break;

            default:
                return response()->json(array('error' => 'Unnoungh recipe category'), 401);
        }
                
        
        $item->save();

        return response()->json(array('success' => 'The recipe has successfully added'), 200);
    }



    /*
    * Load all recipes depends on category
    */
    public function load(int $plan_id, int $item_id, int $category) {

        $data['recipes'] = RecipesCategory::find($category)->recipes()->paginate(3);

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
                $item->breakfast = null;
                break;
            case 2:
                $item->lunch = null;
                break;
            case 3:
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
            $data['recipes'] = RecipesCategory::find($category)->recipes($request->search)->paginate(3);     
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
