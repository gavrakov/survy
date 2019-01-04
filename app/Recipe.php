<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use \Auth;
use App\RecipeCategoriesRelation;


class Recipe extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','description','public'
    ];


    /**
     * Get the photos for the recipe.
     */
    public function photos()
    {
        return $this->hasMany('App\RecipesPhotos');
    }


    /**
     * Get all categories for the recipe.
     */
    public function categories() {
        return $this->belongsToMany('App\RecipesCategory','recipe_categories_relation','recipe_id','category_id');
    }



    /**
     * Get the cover photos for the recipe.
     */
    public function cover()
    {
        return $this->hasMany('App\RecipesPhotos')->where('cover',1);
    }



    /**
     * Get user.
     */
    public function user() {
        return $this->belongsTo('App\User')->first();
    }



    /**
     * Get the cover 150px size photo for the recipe with output link.
     */
    public function cover_link_sm() {
        
        $photo = $this->hasMany('App\RecipesPhotos')->where('cover',1)->first();

        // If photo does not exists, returns default cover
        return $photo == '' ? RecipesPhotos::link_default_sm() : $photo->link_sm();
    }



    /**
     * Get the cover 320px size photo for the recipe with output link.
     */
    public function cover_link_md() {
        
        $photo = $this->hasMany('App\RecipesPhotos')->where('cover',1)->first();

        // If photo does not exists, returns default cover
        return $photo == '' ? RecipesPhotos::link_default_md() : $photo->link_md();
    }




    /**
     * Get all groceries for the recipe.
     */
    public function groceries() {
        return $this->hasMany('App\RecipeGroceriesRelation');
    }




    /*
    * Get all public recipes
    */
    public static function getPublicRecipes(){
        return Recipe::where('public', '=' , 1);
    }





    /*
    * Returns total price of the recipe
    */
    public function getTotalPrice() {

        // Total price of the recipe
        $total_price = 0.00;

        // The price of grocery added in the recipe 
        $recipe_price = 0.00;


        if(session()->has('location')) {

            // Get all groceries that belongs to the recipe
            $groceries = $this->groceries()->get();

            foreach($groceries as $grocery) {


                // Kolicina namirnice 
                $quantity = floatval($grocery->getGroceryQuantity());

                // Kolicina namirnice u receptu
                $recipe_quantity = floatval($grocery->quantity);

                // Cena po kolicini
                $price = floatval($grocery->getGroceryPrice());

                if ($quantity > 0 && $recipe_quantity > 0 && $price > 0) {

                    // Cena u receptu
                    $recipe_price = floatval($recipe_quantity/$quantity*$price);

                    // Ukupna cena
                    $total_price = $total_price + $recipe_price;
                } 
            }
            
      
        }

        return $total_price;
    }


}
