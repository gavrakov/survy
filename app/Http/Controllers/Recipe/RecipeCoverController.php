<?php
namespace App\Http\Controllers\Recipe;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Auth;
use Image;
use Illuminate\Support\Facades\Storage;
use App\Recipe;
use App\RecipesPhotos;
use App\RecipeGroceriesRelation;
use Illuminate\Support\Facades\DB;
use App\Country;
use \PhotoManager; // Service for upload and manage photos
use Illuminate\Support\Facades\URL;



class RecipeCoverController extends Controller
{


	// Konstruktor
    public function __constuct(){
        $this->middleware('auth'); 
    }



    /**
     * Prikaz modala za crop fotografija
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $data['recipe'] = Recipe::find($id);
        return view('recipes/modals/m_cover_edit')->with('recipe',$data['recipe'])->render(); 
    }



    /**
     * Delete photo
     * @param  int  $recipe_id
     * @param  int  $photo_id
     * @return \Illuminate\Http\Response
     */
    public function destroy($recipe_id, $photo_id){

    }



    /**
     * Crop photo - OVO KOMPLETNO SREDITI, dodati u servis PhotoManager, neka odatle poziva crop, takodje srediti response da vrati dobar link i da se fotografija prikaze na profilnoj strani
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function crop(Request $request, $recipe_id) {
    	
    	$photo = $request->image;

    	list($type, $photo) = explode(';', $photo);
        list(, $photo)      = explode(',', $photo);

    	$photo = base64_decode($photo);

    	$recipe = Recipe::find($recipe_id);
    	$old_cover = $recipe->cover()->get()[0];

    	$photo_name = $old_cover->name; // name with extension

    	$path = config('photos.storage.recipes') . $old_cover->dir .'/' . config('photos.storage.thumbs') . 'md_' . $photo_name;

    	$old_path_md = config('photos.public.recipes') . $old_cover->dir . '/thumbs/md_' . $photo_name;

    	$old_path_sm = config('photos.public.recipes') . $old_cover->dir . '/thumbs/sm_' . $photo_name;

    
    
    	// Delete old photo
    	Storage::delete([$old_path_md,$old_path_sm]);


    	// Upload the new one
    	Storage::put($old_path_md, $photo);


    	 // Sm - crop
        $thumb_sm = Image::make(Storage::get($old_path_md))->resize(null,config('photos.size.thumb.height_sm'),function($constraint){
            $constraint->aspectRatio();
            $constraint->upsize();
        })->fit(config('photos.size.thumb.height_sm'))->encode();


        // Upload new small thumb
    	Storage::put($old_path_sm, $thumb_sm);
    	
    	
        return response()->json(['success'=>'done','photo' => asset($recipe->cover_link_md())]);
    }

}

?>