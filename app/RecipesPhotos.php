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


    /*
    * Returns output link of the real size photo - ovde treba da podesim da povlaci putanju iz config-a
    */
    public function link(){
        return 'storage/photos/recipes/' . $this->dir . $this->name;
    }


    /*
    * Returns output link of the small 150px size thumbnail
    */
    public function link_sm(){
        return 'storage/photos/recipes/' . $this->dir .  '/thumbs/150_' . $this->name;
    }


    /*
    * Returns output link of the middle 300px size thumbnail
    */
    public function link_md(){
        return 'storage/photos/recipes/' . $this->dir .  '/thumbs/300_' . $this->name;
    }



    /* -----------------
    *   DEFAULT PHOTO
    *-------------------*/

    /*
    * Returns output link of the small 150px size default thumbnail
    */
    public static function link_default_sm(){
        return 'storage/icons/001-book.png';
    }
}
