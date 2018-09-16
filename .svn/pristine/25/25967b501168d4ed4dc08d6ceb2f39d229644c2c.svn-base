<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class RecipesPhotos extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'photo', 'recipe_id', 'deafult'
    ];


     /**
     * Get the recipe that owns the photo.
     */
    public function recipe() {
    	return $this->belongsTo('App\Recipe');
    }
}
