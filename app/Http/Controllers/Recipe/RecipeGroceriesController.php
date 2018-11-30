<?php

namespace App\Http\Controllers\Recipe;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddGroceryToTheRecipeRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Auth;
use App\Recipe;
use App\Grocery;
use App\RecipeGroceriesRelation;
use Validator;
use Illuminate\Support\Facades\DB;
use App\Country;





/*
* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
* GROCERIES THAT BELONGS TO RECIPE
* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
*/

class RecipeGroceriesController extends Controller
{

    // Konstruktor
    public function __constuct(){
        $this->middleware('auth'); 
    }



    /**
     * Show the form for adding and editing recipes groceries
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
    */
    public function index($id)
    {
        $data['recipe'] = Recipe::find($id);
        $data['groceries'] = Grocery::orderBy('id','desc')->paginate(8);

        $data['location'] = null;

        // U koliko je setovana lokacija plana
        if(session()->has('location') !== null) {
            $data['location'] = Country::find(session('location'));
        }

         return view('recipes/modals/m_groceries_wide')->with('data',$data)->render(); 
    }




    /*
    * Load groceries  that are inserted into a recipe and show it into the modal
    */
    public function basket(Request $request, $id) {

        $data['recipe'] = Recipe::find($id);
        $data['insgroceries'] = RecipeGroceriesRelation::all()->where('recipe_id',$id);//('grocery');

        $data['location'] = null;

        // U koliko je setovana lokacija plana
        if(session()->has('location') !== null) {
            $data['location'] = Country::find(session('location'));
        }


        if($request->ajax()) {
            return view('recipes/modals/m_basket_load')->with('data',$data)->render();
        }

        // Non ajax
        return view('recipes/modals/m_basket_load')->with('data',$data);
        
    }




    /*
    * Load groceries
    */
    public function load(Request $request, $id) {

        $data['recipe'] = Recipe::find($id);
      

        // Namirnice koje se ne nalaze u receptu.
        $data['groceries'] = Grocery::NonRecipeGroceries($id)->orderBy('id','desc')->paginate(6);

       
        // Ajax
        if($request->ajax()) {
             return view('recipes/modals/m_groceries_load')->with('data',$data)->render(); 
        }

        // Non ajax
         return view('recipes/modals/m_groceries_load')->with('data',$data); 
        
    }



    /*
    * Add grocery to a recipe
    * @id int - recipe id
    */
    public function store(AddGroceryToTheRecipeRequest $request , $id) {

        $relation = new RecipeGroceriesRelation();
        $relation->recipe_id = $id;
        $relation->grocery_id = $request->input('f_grocery');
        $relation->quantity = $request->input('f_quantity');
        $relation->save();

        return response()->json(array( 'success' => true, 'relation' => $relation));
        
    }



    /*
    * Delete groceries
    * @id int - recipe id
    * @id int - grocery_id
    */
    public function destroy($recipe_id,$grocery_id) {
        $relation = RecipeGroceriesRelation::where(['recipe_id'=>$recipe_id,'grocery_id'=>$grocery_id])->delete();
        return response()->json(array( 'success' => true, 'relation' => $relation));

    }




    /**
     * Search groceries
     * 
     * @param Illuminate\Http\Request
     * @return Illuminate\Http\Response
     */
    public function search(Request $request, $id)
    {

        $data['recipe'] = Recipe::find($id);

        if($request->ajax()) {

            // Ako je unet parametar za pretragu
            $data['groceries'] = $request->search != '' ? 
              
                Grocery::NonRecipeGroceries($id)
                ->where([['name','LIKE','%' . $request->search . '%']])
                ->orderBy('id','desc')->paginate(6)


            : // Ako nije unet parametar za pretragu

                Grocery::NonRecipeGroceries($id)->orderBy('id','desc')->paginate(6);
        }


        // Ajax
        if($request->ajax()) {
             return view('recipes/modals/m_groceries_load')->with('data',$data)->render(); 
        }

        // Non ajax
        return view('recipes/modals/m_groceries_load')->with('data',$data); 
    }

}
