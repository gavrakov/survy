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


    /*
    * Return all recipes that belongs to user - with search
    */
    public function recipes($request=NULL) {

        if ($request <> NULL or $request <> '') {
            return  $this->hasMany('App\Recipe')->where('name', 'LIKE' , '%' . $request . '%');
        }

        return $this->hasMany('App\Recipe');
    }

}
