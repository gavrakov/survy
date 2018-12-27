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
        'photo', 'recipe_id', 'default'
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
        return config('photos.storage.recipes') . $this->dir . '/'. $this->name;
    }


    /*
    * Returns output link of the middle 300px size thumbnail
    */
    public function link_sm(){
        return config('photos.storage.recipes') . $this->dir .  '/' . config('photos.storage.thumbs') . 'sm_' . $this->name;
    }


    /*
    * Returns output link of the middle 300px size thumbnail
    */
    public function link_md(){

        return config('photos.storage.recipes') . $this->dir .  '/' . config('photos.storage.thumbs') . 'md_' . $this->name;
    }


    /* -----------------
    *   DEFAULT PHOTO
    *-------------------*/

    /*
    * Returns output link of the small 150px size default thumbnail
    */
    public static function link_default_sm(){
        return config('photos.storage.icons') . '001-book-64.png';
    }


    /*
    * Returns output link of the small 320px size default thumbnail
    */
    public static function link_default_md(){
        return config('photos.storage.icons') . '001-book-512.png';
    }

}
