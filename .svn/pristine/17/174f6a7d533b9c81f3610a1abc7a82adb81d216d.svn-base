<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use \Auth;

class RecipesCategory extends Model
{

    use Notifiable;


    // Dodao jer nije prepoznavao ime tabele zbog naziva u jednini
    public $table = "recipes_category";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name' 
    ];



    /*
    * Get all recipes that belogns to the category
    */
    public function recipes($request='') {

        if($request == '') {
            return $this->belongsToMany('App\Recipe','recipe_categories_relation', 'category_id', 'recipe_id')->where('user_id', Auth::user()->id);
        } else {
            return $this->belongsToMany('App\Recipe','recipe_categories_relation', 'category_id', 'recipe_id')->where([['user_id', Auth::user()->id],['name','LIKE','%' . $request . '%']]);

            
        }
        
    }   


}
