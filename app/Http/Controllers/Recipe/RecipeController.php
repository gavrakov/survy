<?php

namespace App\Http\Controllers\Recipe;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateRecipeRequest;
use App\Http\Requests\AddGroceryToTheRecipeRequest;
use App\Http\Requests\UploadRecipesPhotosRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Auth;
use Image;
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







class RecipeController extends Controller
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

        return view('recipes/recipes')->with('data',$data);  
    }

    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['categories'] = RecipesCategory::all();

        // Ajax
        return view('recipes/modals/m_create')->with('categories',$data['categories'])->render();
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\CreateRecipeReq  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRecipeRequest $request)
    {

        $recipe = new Recipe;
        
        $recipe->name = $request->input('name');
        $recipe->persons = $request->input('persons');
        $recipe->public = $request->input('public');
           
        if($recipe->public != 1){
            $recipe->public = 0;
        }
        
        $recipe->user_id = Auth::user()->id;

        $recipe->save();

        foreach($request->input('categories') as $category) {
         
            $relation = new RecipeCategoriesRelation();
            $relation->category_id = $category;
            $relation->recipe_id = $recipe->id;
            $relation->save();
        }

        if($request->ajax()) {
                return response()->json(['id',$recipe->id], 200);
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
            return redirect('/recipes');
        }
      
        $data['recipe'] = Recipe::with('photos')->find($id);
        $data['categories'] = RecipesCategory::all();

        return view('recipes/recipe')->with($data); 
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data=[];
        $data['recipe'] = Recipe::find($id);
        $data['categories'] = RecipesCategory::all();

        // Ne prepoznaje selektovanu kategoriju
        // Ovde srediti kategorije, sada jedan recept moze da ima vise od jedne kategorije

        // Ajax
        return view('recipes/modals/m_edit')->with('data',$data)->render();  
    }



     /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function description($id)
    {
         $data['recipe'] = Recipe::find($id);
         return view('recipes/modals/m_description')->with('recipe',$data['recipe'])->render(); 
    }




    /**
     * Update description
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updDescription(Request $request, $id)
    {
        $recipe = Recipe::find($id);

        // Form validation
        $this->validate($request,[
            'description' => 'required|min:10|max:4000',
        ]);

        if($request->ajax()) {

            $recipe->description = $request->description;
            $recipe->save();

            return response()->json($recipe, 200);
        }

    }




    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CreateRecipeRequest $request, $id)
    {

        $recipe = Recipe::find($id);

        if($request->ajax()) {

            $recipe->name = $request->input('name');
            $recipe->persons = $request->input('persons');
            $recipe->public = $request->input('public');
           
            if($recipe->public != 1){
                $recipe->public = 0;
            }

            $recipe->save();

            // Brisem sve kategorije koje pripadaju receptu i dodajem kategorije koje su oznacne na formi
            DB::table('recipe_categories_relation')->where('recipe_id', $recipe->id)->delete();

            // Dodajem kategorije koje su oznacne na formi
            foreach($request->input('categories') as $category) {
         
                $relation = new RecipeCategoriesRelation();
                $relation->category_id = $category;
                $relation->recipe_id = $recipe->id;
                $relation->save();
            }


            // Vracam imena svih kategorija recepta kako bi se prikazale u receptu
            $categories = '';
            $counter = 0;
            
            foreach($recipe->categories()->get() as $category) {

                if($counter == 0) {
                    $categories = $category->name;
                } else {
                    $categories =  $categories . ', ' . $category->name;
                }

                $counter++;
     
            }

            $data['recipe'] = $recipe;
            $data['categories'] = $categories;

            return response()->json($data, 200);
        }
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $recipe = Recipe::find($id);
       
        // Povlacim fotografiju ako bih izvukao direktorijum u kome se nalaze fotografije
        $photo = $recipe->photos()->first(); 

        // Ako postoji fotografija, brisemo je
        if(count($photo) > 0) {

            $directory = 'public/photos/recipes/' . $photo->dir;

            // Brisanje direktorijuma sa fotkama
            Storage::deleteDirectory($directory);

            // Brisanje fotografija iz baze
            $recipe->photos()->delete();
        }

        // Brisanje recepta
        $recipe->delete();

    }



    /**
     * All recipes with search
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

            $data['recipes'] = Auth::user()->myRecipes($request->search)->orderBy('id','desc')->paginate(20);
        
        // Recipes by category    
        } else {

            $data['recipes'] = RecipesCategory::find($category)->myRecipes($request->search)->orderBy('id','desc')->paginate(20);
           
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
            return view('recipes/recipes_load')->with('data', $data)->render();
        }
 
    }



    /*
    * Load recipe photos and render view
    */
    public function loadPhotos(Request $request, $id) {

        $data['recipe'] = Recipe::find($id);

        if($request->ajax()) {
            return view('recipes/load_photos')->with('recipe',$data['recipe'])->render();
        }

        // Non ajax
        return view('recipes/load_photos')->with('recipe',$data['recipe']);
        
    }




    /*
    * Load groceries  that are inserted into a recipe and show it into the recipe page
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
            return view('recipes/basket_load')->with('data',$data)->render();
        }

        // Non ajax
        return view('recipes/basket_load')->with('data',$data);
        
    }

}
