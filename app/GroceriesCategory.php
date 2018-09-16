<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class GroceriesCategory extends Model
{
    // Grocery category model

    use Notifiable;


    public $table = "groceries_category";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','description','icon'
    ];


     /**
     * Get the grocery that owns the category.
     */
    public function groceries() {
    	return $this->HasMany('App\Grocery');
    }
}
