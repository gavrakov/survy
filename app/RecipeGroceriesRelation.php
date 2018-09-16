<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class RecipeGroceriesRelation extends Model
{
    //

    use Notifiable;


    public $table = "recipe_groceries_relation";


    protected $fillable = [
        'recipe_id','grocery_id'
    ];


    /**
     * Get all recipes that belongs to the category.
     */
    public function recipes()
    {
        return $this->hasMany('App\Recipes');
    }


    /**
     * Get all groceries thet belongs to the recipe.
     */
    public function groceries()
    {
        return $this->hasMany('App\Grocery');
    }


    /**
     * Get the grocery thet belongs to the recipe.
     */
    public function grocery()
    {
        return $this->belongsTo('App\Grocery','grocery_id','id');
    }



    /*
    * Returns the name of the grocery
    */
    public function getGroceryName() {
        return $this->grocery()->first()->name;
    }


    /*
    * Returns the name of the category that grocery belongs
    */
    public function getGroceryCategory() {
        return $this->grocery()->first()->category()->first()->name;
    }


    /*
    * Returns the category icon
    */
    public function getGroceryCategoryIcon() {
        return $this->grocery()->first()->getCategoryIcon();
    }


    /*
    * Returns the unit of the grocery
    */
    public function getGroceryUnite() {
        return $this->grocery()->first()->getUnite();
    }


    /*
    * Returns the price of the grocery
    */
    public function getGroceryPrice() {
        return $this->grocery()->first()->getPrice();
    }


    /*
    * Returns the quantity of the grocery
    */
    public function getGroceryQuantity() {
        return $this->grocery()->first()->quantity;
    }


    /*
    * Returns calculate quantity price of grocery
    */
    public function calculateGroceryPrice() {

        // Calculated price
        $cal_price = 0.00;

        if (session()->has('location')) {

             // Grocery quantity
            $quantity = floatval($this->grocery()->first()->quantity);

            // Grocery basket quantity
            $basket_quantity = floatval($this->quantity);

            // Price
            $price = floatval($this->getGroceryPrice());

            // Calculate price
            if ($quantity > 0 && $basket_quantity > 0 && $price > 0) { 
                $cal_price = floatval($basket_quantity/$quantity*$price);
            }

        } 

        return $cal_price;
             
    }


}
