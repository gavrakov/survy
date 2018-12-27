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
use \PhotoManager; // Service for upload and manage photos







class RecipePhotosController extends Controller
{

    // Konstruktor
    public function __constuct(){
        $this->middleware('auth'); 
    }



    /**
     * Prikaz modala za upload i edit fotografija
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function index($id)
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
    public function load($id)
    {
         $data['recipe'] = $data['recipe'] = Recipe::with('photos')->find($id);
         return view('recipes/modals/m_photos_load')->with('recipe',$data['recipe'])->render(); 
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
     * @param  int  $recipe_id
     * @param  int  $photo_id
     * @return \Illuminate\Http\Response
     */
    public function destroy($recipe_id, $photo_id)
    {
        //$photo_id = $request->input('photo');

        $recipe = Recipe::find($recipe_id);


        $photo = RecipesPhotos::find($photo_id);    // OVO SVE PREBACITI U PhotoManager

        // Ako je fotografija cover setujemo novi cover
        if ($photo->cover == 1) {

            $new_cover = Recipe::find($recipe_id)->photos()->where('id','<>',$photo->id)->first();

            if(count($new_cover) > 0) {
                $new_cover->cover = 1;
                $new_cover->save();
            }
            
        }

        $photo_path = config('photos.public.recipes') . $photo->dir . '/' . $photo->name;
        $thumb_300 = config('photos.public.recipes') . $photo->dir . '/thumbs/md_' . $photo->name;
        $thumb_150 = config('photos.public.recipes') . $photo->dir . '/thumbs/sm_' . $photo->name;

        // Brisanje fotografija ukljucujuci i thumbnail fotke
        Storage::delete([$photo_path,$thumb_300,$thumb_150]);

        // Brisanje fotografije iz baze
        $photo->delete();
        
        return response()->json(['recipe',$recipe], 200);
        
    }



    /**
     * Upload photos
     * 
     * @param Illuminate\Http\Request
     * @param  int  $id
     * @return Illuminate\Http\Response
     */
   

    public function upload(Request $request, $id) {

        // Ovde moram da iskoristim UploadRecipesPhotosRequest, sve uradjeno samo srediti klijent deo kada jquery treba da prepozna status 422
        // Problem je do klijent dela jer su sve funkcije, treba proveriti kako radi i da li ima funkcije kada vraca status koji nije 200, odnosno kao kod ajaxa kada postoji deo errors:.....

        $recipe = Recipe::find($id);

        // Preuzimanje podataka sa forme
        $input_data = $request->all();

        // Validation
        $validator = Validator::make(
            $input_data, [
            'photos.*' => 'required|mimes:jpg,jpeg,png,gif|max:10240'
            ]
            ,[
                'photos.*.mimes' => 'Only jpeg, jpg, png and gif images are allowed',
                'photos.*.max' => 'Maximum allowed size for an image is 10MB',
            ]
        );


        // Fajlovi nisu validni
        if ($validator->fails()) {
            return response()->json(array( 'success' => false, 'errors' => $validator->errors())); 
        }


        // Upload
        if (!empty($request->photos)) {


            foreach($request->photos as $photo){

                // Upload path
                $path = config('photos.public.recipes');
           

                // Upload photos and create thumbnails
                PhotoManager::uploadWithThumbnails($photo, $path, $recipe->id);
                                
                // Insert uploaded photograph into the database
                $recipePhoto = new RecipesPhotos;

                $recipePhoto->name = PhotoManager::filename();
                $recipePhoto->recipe_id = $recipe->id;

                // Setovanje covera
                $recipePhoto->cover = 0;
               
                $recipePhoto->dir = hash('sha256', $recipe->id);

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



}
