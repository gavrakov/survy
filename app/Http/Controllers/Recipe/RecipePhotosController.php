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


        $photo = RecipesPhotos::find($photo_id);

        // Ako je fotografija cover setujemo novi cover
        if ($photo->cover == 1) {

            $new_cover = Recipe::find($recipe_id)->photos()->where('id','<>',$photo->id)->first();

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
        
        return response()->json(['recipe',$recipe], 200);
        
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
            'photos.*' => 'required|mimes:jpg,jpeg,png,gif|max:8192'
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

                    /*$thumb_300 = Image::make(Storage::get($thumbsPath_300))->resize(null,320,function($constraint){
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })->crop(300,300,3,3)->encode();*/

                    $thumb_300 = Image::make(Storage::get($thumbsPath_300))->resize(null,320,function($constraint){
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })->fit(300)->encode();



                    /*$thumb_150 = Image::make(Storage::get($thumbsPath_150))->resize(null,120,function($constraint){
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })->crop(100,100,1,1)->encode();*/

                    $thumb_150 = Image::make(Storage::get($thumbsPath_150))->resize(null,120,function($constraint){
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })->fit(100)->encode();

                // Sirina manja od duzine    
                } else {
                   /* $thumb_300 = Image::make(Storage::get($thumbsPath_300))->resize(320,null,function($constraint){
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })->crop(300,300,3,3)->encode();*/

                    $thumb_300 = Image::make(Storage::get($thumbsPath_300))->resize(320,null,function($constraint){
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })->fit(300)->encode();


                    /*$thumb_150 = Image::make(Storage::get($thumbsPath_150))->resize(120,null,function($constraint){
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })->crop(100,100,1,1)->encode();*/

                    $thumb_150 = Image::make(Storage::get($thumbsPath_150))->resize(120,null,function($constraint){
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })->fit(100)->encode();



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



}
