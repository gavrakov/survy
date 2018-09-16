<?php

namespace App\Http\Controllers;

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

        // U koliko je setovana lokacija plana
        if(session()->has('location') !== null) {
            $data['location'] = Country::find(session('location'));
        }   

        return view('recipes/recipes')->with('location',$data['location']);  
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
     * Prikaz modala za upload i edit fotografija
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function modalPhotos($id)
    {
         $data['recipe'] = $data['recipe'] = Recipe::with('photos')->find($id);
         return view('recipes/modals/m_photos')->with('recipe',$data['recipe'])->render(); 
    }



    /**
     * Prikazuje fotografije u modalu za editovanje fotografija
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function modalPhotosLoad($id)
    {
         $data['recipe'] = $data['recipe'] = Recipe::with('photos')->find($id);
         return view('recipes/modals/m_photos_load')->with('recipe',$data['recipe'])->render(); 
    }



    /**
     * Show the form for adding and editing recipes groceries
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
    */
    public function modalGroceries($id)
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
     * Update cover photo
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updCover(Request $request, $id)
    {
        $photo_id = $request->input('photo');
        
        DB::table('recipes_photos')->where('recipe_id',$id)->update(['cover' => 0]);

        $photo = RecipesPhotos::find($photo_id);

        $photo->cover=1;
        $photo->save();

        $recipe = Recipe::with('photos')->find($id);


        if($request->ajax()) {
            return response()->json(['recipe',$recipe], 200);
        }

    }



    /**
     * Delete photo
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyPhoto(Request $request, $id)
    {
        $photo_id = $request->input('photo');

        $recipe = Recipe::find($id);


        $photo = RecipesPhotos::find($photo_id);

        // Ako je fotografija cover setujemo novi cover
        if ($photo->cover == 1) {

            $new_cover = Recipe::find($id)->photos()->where('id','<>',$photo->id)->first();

            if(count($new_cover) > 0) {
                $new_cover->cover = 1;
                $new_cover->save();
            }
            
        }

        $photo_path = 'public/photos/recipes/' . $photo->dir . '/' . $photo->name;
        $thumb_300 = 'public/photos/recipes/' . $photo->dir . '/thumbs/300_' . $photo->name;
        $thumb_150 = 'public/photos/recipes/' . $photo->dir . '/thumbs/150_' . $photo->name;

        // Brisanje fotografija ukljucujuci i thumbnail fotke
        Storage::delete([$photo_path,$thumb_300,$thumb_150]);

        // Brisanje fotografije iz baze
        $photo->delete();

        if($request->ajax()) {
            return response()->json(['recipe',$recipe], 200);
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
     * Search recipes
     * 
     * @param Illuminate\Http\Request
     * @return Illuminate\Http\Response
     */
    public function search(Request $request)
    {

        if($request->ajax()) {

            // Ako je unet parametar za pretragu
            $data['recipes'] = $request->search != '' ? 
               
                Recipe::where([['user_id', Auth::user()->id],['name','LIKE','%' . $request->search . '%']])
            
                ->with(['photos' => function($query){
                    $query->where('cover',1);
                }

            ])->orderBy('id','desc')->paginate(3)


            : // Ako nije unet parametar za pretragu

                Recipe::where('user_id', Auth::user()->id)

                ->with(['photos' => function($query){
                    $query->where('cover',1);
                }

            ])->orderBy('id','desc')->paginate(3);


            // return Response::json($recipes);
            //return response()->json($recipes);

            return view('recipes/recipes_load')->with('recipes',$data['recipes'])->render();
           
        }
    }



    /**
     * Upload photos
     * 
     * @param Illuminate\Http\Request
     * @param  int  $id
     * @return Illuminate\Http\Response
     */
    //UploadRecipesPhotosRequest 
    public function upload(Request $request, $id) {

        // Ovde moram da iskoristim UploadRecipesPhotosRequest, sve uradjeno samo srediti klijent deo kada jquery treba da prepozna status 422
        // Problem je do klijent dela jer su sve funkcije, treba proveriti kako radi i da li ima funkcije kada vraca status koji nije 200, odnosno kao kod ajaxa kada postoji deo errors:.....

        $recipe = Recipe::find($id);

        // Preuzimanje podataka sa forme
        $input_data = $request->all();

        // Validation
        $validator = Validator::make(
            $input_data, [
            'photos.*' => 'required|mimes:jpg,jpeg,png,gif|max:80000'
            ]
            ,[
                'photos.*.mimes' => 'Only jpeg, jpg, png and gif images are allowed',
                'photos.*.max' => 'Maximum allowed size for an image is 8MB',
            ]
        );


        // Fajlovi nisu validni
        if ($validator->fails()) {
            return response()->json(array( 'success' => false, 'errors' => $validator->errors())); 
        }


        if (!empty($request->photos)) {


            foreach($request->photos as $photo){

                // ONEMOGUCITI UPLOAD FOTOGRAFIJE U KOLIKO FAJL SA ISTIM IMENOM VEC POSTOJI

                // Make filename to upload and store in database
                $filename = pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME); //. '_' .time();
                $extension = $photo->getClientOriginalExtension();
                $filenameToStore = $filename . '.' . $extension;
                $filenameToStore_300 = '300_' . $filename . '.' . $extension;
                $filenameToStore_150 = '150_' . $filename . '.' . $extension;
               

                // Directory for storing photos
                $photos_dir = 'public/photos/recipes/' .hash('sha256', $recipe->id). '/';

                if (Storage::exists($photos_dir . $filenameToStore)) {
                    $filename = $filename . rand(1,100);
                    $filenameToStore = $filename . '.' . $extension;
                    $filenameToStore_300 = '300_' . $filename . '.' . $extension;
                    $filenameToStore_150 = '150_' . $filename . '.' . $extension;
                }



                // Directory for storing photos thumbs
                $thumbs_dir = $photos_dir . 'thumbs/';

                // Upload photo
                $photo->storeAs($photos_dir,$filenameToStore);

                // Upload thumb 300
                $photo->storeAs($thumbs_dir,$filenameToStore_300);

                 // Upload thumb 150
                $photo->storeAs($thumbs_dir,$filenameToStore_150);

                // Thumbs 300 fullpath
                $thumbsPath_300 = $thumbs_dir . $filenameToStore_300;

                // Thumbs 150 fullpath
                $thumbsPath_150 = $thumbs_dir . $filenameToStore_150;

                // Image width/height
                $img_width = Image::make($photo->getRealPath())->width();
                $img_height = Image::make($photo->getRealPath())->height();


                // Ako je sirina veca od duzine
                if ($img_width > $img_height) {
                    $thumb_300 = Image::make(Storage::get($thumbsPath_300))->resize(null,320,function($constraint){
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })->crop(300,300,3,3)->encode();


                    $thumb_150 = Image::make(Storage::get($thumbsPath_150))->resize(null,120,function($constraint){
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })->crop(100,100,1,1)->encode();

                // Sirina manja od duzine    
                } else {
                    $thumb_300 = Image::make(Storage::get($thumbsPath_300))->resize(320,null,function($constraint){
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })->crop(300,300,3,3)->encode();


                    $thumb_150 = Image::make(Storage::get($thumbsPath_150))->resize(120,null,function($constraint){
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })->crop(100,100,1,1)->encode();

                }

                // Save resized photo
                Storage::put($thumbsPath_300, $thumb_300);
                Storage::put($thumbsPath_150, $thumb_150);

                                
                // Insert uploaded photograph into the database
                $recipePhoto = new RecipesPhotos;

                $recipePhoto->name = $filenameToStore;
                $recipePhoto->recipe_id = $recipe->id;

                // Setovanje covera
                $recipePhoto->cover = 0;
               
                $recipePhoto->dir = hash('sha256', $recipe->id);

                // Save u bazi
                $recipePhoto->save();

            }


        } 

        $cover = $recipe->cover()->get();

        // Ako recept nema cover
        if (count($cover) == 0) {

            // Make default cover photo
            $cover_photo = Recipe::find($id)->photos()->first();
            $cover_photo->cover = 1;
            $cover_photo->save();

        }   


        $data['recipe'] = $recipe;

        $result = view('recipes/modals/m_photos_load')->with('recipe',$data['recipe'])->render();

        return response()->json(array( 'success' => true, 'errors' => $validator->errors(),'res' => $result));
    }



    /**
     * Load all groceries
     */
    public function load(Request $request) {

       
        $data['recipes'] = Recipe::orderBy('id','desc')->paginate(10);

        // Ajax
        if($request->ajax()) {
            return view('recipes/recipes_load')->with('recipes',$data['recipes'])->render();
        }

        // Non ajax
        return view('recipes/recipes')->with('recipes',$data['recipes']);
 
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
    * ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    * GROCERIES THAT BELONGS TO RECIPE
    * ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    */


    /*
    * Load groceries  that are inserted into a recipe and show it into the modal
    */
    public function modalbasketload(Request $request, $id) {

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
    * Load groceries  that are inserted into a recipe and show it into the recipe page
    */
    public function basketload(Request $request, $id) {

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



    /*
    * Load groceries
    */
    public function modalgroceriesload(Request $request, $id) {

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
    public function addGrocery(AddGroceryToTheRecipeRequest $request , $id) {

        $relation = new RecipeGroceriesRelation();
        $relation->recipe_id = $id;
        $relation->grocery_id = $request->input('f_grocery');
        $relation->quantity = $request->input('f_quantity');
        $relation->save();

        return response()->json(array( 'success' => true, 'relation' => $relation));
        
    }



    /*
    * Add grocery to a recipe
    * @id int - recipe id
    */
    public function delGrocery($id) {
     
        $relation = RecipeGroceriesRelation::find($id)->delete();
        return response()->json(array( 'success' => true, 'relation' => $relation));   
    }



     /**
     * Search groceries
     * 
     * @param Illuminate\Http\Request
     * @return Illuminate\Http\Response
     */
    public function groceriesSearch(Request $request, $id)
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
