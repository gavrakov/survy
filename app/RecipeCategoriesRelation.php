<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use \Auth;

class RecipeCategoriesRelation extends Model
{
    //
    use Notifiable;

    public $table = "recipe_categories_relation";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'recipe_id','category_id'
    ];


    /**
     * Get all recipes that belongs to the category.
     */
    public function recipes()
    {
        return $this->hasMany('App\Recipe'); // OVDE MORAM DA POSTAVIM PRAVILNU VEZU, NESTO NIJE U REDU.
        //return $this->belongsToMany('App\Recipe','recipe_categories_relation','category_id','recipe_id');
    }


    /**
     * Get all categories thet belongs to the recipe.
     */
    public function categories()
    {
        return $this->hasMany('App\RecipesCategory');
    }



}
