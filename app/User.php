<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'avatar'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];



    /**
     * Get user avatar photo link.
     */
    public function cover_link() {
        
        return config('photos.public.users') . $this->avatar;
    }


    /*
    * Return all recipes that belongs to user - with search
    */
    public function myRecipes($request=NULL) {

        if ($request <> NULL or $request <> '') {
            return  $this->hasMany('App\Recipe')->where('name', 'LIKE' , '%' . $request . '%');
        }

        return $this->hasMany('App\Recipe');
    }



    /*
    * Get all other users recipes that belogns to the category
    */
    public function otherUsersRecipes($request=NULL) {

        if($request <> NULL or $request <> '') {
            return Recipe::where([['user_id', '!=', $this->id],['public', '=', 1],['name','LIKE','%' . $request . '%']]);
        } else {
            return Recipe::where([['user_id', '!=', $this->id],['public', '=', 1]]);
        }
        
    } 

}
