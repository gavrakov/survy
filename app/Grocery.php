<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grocery extends Model
{
    // Grocery model
    protected $fillable = ['name','category','unite'];

    /**
     * Get the category for the grocery.
     */
    public function category()
    {
        return $this->belongsTo('App\GroceriesCategory','category','id');
    }


    /**
     * Get the unite model for the grocery.
     */
    public function unite()
    {
        return $this->belongsTo('App\GroceriesUnite','unite','id');
    }


    public function GroceriesPrices()
    {
        return $this->hasMany('App\GroceriesPrices')->where('country_id',session('location'));
    }



    public function RecipesGroceries()
    {
        return $this->hasMany('App\RecipesGroceriesRelation');
    }



    // All groceries that are not in recipe
    public static function NonRecipeGroceries($recipe_id){
        
        return Grocery::whereNotIn('id',function($query) use ($recipe_id){
            $query->select('grocery_id')
            ->from('recipe_groceries_relation')
            ->where('recipe_id','=', $recipe_id);
        });
    }



    // Get the unite value for the grocery
    public function getUnite(){
        return $this->unite()->first()->unite;
    }


    // Get the price value for the grocery
    public function getPrice() {
        return $this->GroceriesPrices()->first()['price'];
    }


    // Get the category name value for the grocery
    public function getCategoryName() {
        return $this->category()->first()->name;
    }


     // Get the category icon
    public function getCategoryIcon() {
        return $this->category()->first()->icon;
    }



}
