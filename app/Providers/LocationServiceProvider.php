<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Location;
use Auth;
//use \App\Services\LocationService;

class LocationServiceProvider extends ServiceProvider
{


 


    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }



    /**
     * Register the application services.
     * @return void
     */
    public function register()
    {

        $this->app->bind('LocationManager', function(){
            return new \App\Services\LocationManager('location');
        });


    }



}
