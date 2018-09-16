<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class GroceriesUnite extends Model
{

    // Grocery category unite

    use Notifiable;


    public $table = "groceries_unite";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','unite' 
    ];


     /**
     * Get the grocery that owns the unite.
     */
    public function groceries() {
    	return $this->HasMany('App\Grocery');
    }
}
