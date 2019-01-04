<?php

namespace App\Http\Controllers\RecipeAll;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Recipe;
use App\RecipesPhotos;
use App\RecipesCategory;
use App\RecipeCategoriesRelation;
use App\Grocery;
use App\RecipeGroceriesRelation;
use Validator;
use Illuminate\Support\Facades\DB;
use App\Country;
use Auth;

class RecipeAllController extends Controller
{



    // Konstruktor
    public function __constuct(){
        $this->middleware('auth'); 
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $data['location'] = null;
        $data['categories'] = RecipesCategory::all();


        // U koliko je setovana lokacija plana
        if(session()->has('location') !== null) {
            $data['location'] = Country::find(session('location'));
        }   

        return view('recipeall/recipes')->with('data',$data);  
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
            return redirect('/recipes');
        }
      
        $data['recipe'] = Recipe::with('photos')->find($id);
        $data['categories'] = RecipesCategory::all();

        return view('recipeall/recipe')->with($data); 
    }




    /**
     * All recipes that belongs to other users with search
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $category
     * @return View
     */
    public function load(Request $request, $category) {

        $data['recipes'] = NULL;
        $data['category'] = $category;


        // All recipes
        if ($category == '0') {

            $data['recipes'] = Auth::user()->otherUsersRecipes($request->search)->orderBy('id','desc')->paginate(20);
        
        // Recipes by category    
        } else {

            $data['recipes'] = RecipesCategory::find($category)->otherUsersRecipes($request->search)->orderBy('id','desc')->paginate(20);
           
        }

        // Ovo je pokusaj da se nesto uradi
       /* $data['lp'] = false;

        $lastPage = $data['recipes']->lastPage(); 
        $currentPage = $data['recipes']->currentPage();

        if ($lastPage == $currentPage) {
            $data['lp'] = true;
        }*/

        if ($data['recipes']->count() == 0) {
            return 'nomore';
        }


        // Ajax
        if($request->ajax()) {
            return view('recipeall/recipes_load')->with('data', $data)->render();
        }
 
    }
}
