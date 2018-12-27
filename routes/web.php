<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::get('/', function () {
    return view('welcome');
});


Auth::routes();

// Home
Route::get('/home', 'HomeController@index')->name('home');

// Users routes
Route::get('/user', 'UserController@profile')->name('user.profile');
Route::post('/user/update', 'UserController@update')->name('user.update');


// Recipe routes grouping test
Route::namespace('Recipe')->group(function () {
   
	// Recipes
    Route::get('/recipes/{category}/load', 'RecipeController@load')->name('recipes.load');
    Route::get('/recipes/{category}/search', 'RecipeController@search')->name('recipes.search');
    Route::get('/recipes/{id}/description','RecipeController@description')->name('recipes.description');
    Route::put('/recipes/{id}/upddescription', 'RecipeController@upddescription')->name('recipes.upddescription');
    Route::get('/recipes/{id}/basket','RecipeController@basket')->name('recipes.basket');
    Route::get('/recipes/{id}/loadphotos','RecipeController@loadphotos')->name('recipes.loadphotos');
	Route::resource('recipes', 'RecipeController', 
		[
			'names' => [
				'index' 	=> 'recipes',
				'create' 	=> 'recipes.create',
				'store' 	=> 'recipes.store',
				'show' 		=> 'recipes.show',
				'edit'		=> 'recipes.edit',
				'update'	=> 'recipes.update',
				'destroy'	=> 'recipes.destroy',
			]
	]);


	// Recipe photos
	Route::post('/recipes/{id}/photos/upload', 'RecipePhotosController@upload')->name('recipes.photos.upload');
	Route::get('/recipes/{id}/photos/load', 'RecipePhotosController@load')->name('recipes.photos.load');
	Route::put('/recipes/{id}/photos/{photo_id}/updcover', 'RecipePhotosController@updcover')->name('recipes.photos.updcover');
	Route::resource('recipes.photos', 'RecipePhotosController', 
		[
			'names' => [
				'index' 	=> 'recipes.photos',
				'destroy' 	=> 'recipes.photos.destroy',
			]
		],

		['only' => ['index', 'destroy']

	]);
	

	//Recipe cover crop
	Route::post('/recipes/{id}/cover/crop', 'RecipeCoverController@crop')->name('recipes.cover.crop');
	Route::resource('recipes.cover', 'RecipeCoverController', 
		[
			'names' => [
				'index' 	=> 'recipes.cover',
				'destroy' 	=> 'recipes.cover.destroy',
			]
		],

		['only' => ['index', 'destroy']

	]);



	// Recipe groceries
	Route::get('/recipes/{id}/groceries/load', 'RecipeGroceriesController@load')->name('recipes.groceries.load');
	Route::get('/recipes/{id}/groceries/basket', 'RecipeGroceriesController@basket')->name('recipes.groceries.basket');
	Route::get('/recipes/{id}/groceries/search', 'RecipeGroceriesController@search')->name('recipes.groceries.search');
	Route::resource('recipes.groceries', 'RecipeGroceriesController', 
		[
			'names' => [
				'index' 	=> 'recipes.groceries',
				'store' 	=> 'recipes.groceries.store',
				'destroy'	=> 'recipes.groceries.destroy',
			]

		],

		['only' => ['index', 'store', 'destroy']
	]);


});



// Groceries routes
Route::get('/groceries', 'GroceryController@index')->name('groceries');
Route::get('/groceries/create','GroceryController@create')->name('groceries.create');
Route::post('/groceries/store','GroceryController@store')->name('groceries.store');
Route::get('/groceries/load','GroceryController@load')->name('groceries.load');
Route::get('/groceries/destroy/{id}','GroceryController@destroy')->name('groceries.destroy');
Route::get('/groceries/edit/{id}','GroceryController@edit')->name('groceries.edit');
Route::post('/groceries/update/{id}','GroceryController@update')->name('groceries.update');
Route::get('/groceries/search', 'GroceryController@search')->name('groceries.search');


// Locations routes
Route::get('/locations', 'LocationController@index')->name('locations');
Route::get('/locations/load','LocationController@load')->name('locations.load');
Route::post('/locations/store', 'LocationController@store')->name('locations.store');
Route::get('/locations/destroy/{id}','LocationController@destroy')->name('locations.destroy');
Route::put('/locations/update/{id}', 'LocationController@update')->name('locations.update');
Route::get('/locations/country', 'LocationController@country')->name('locations.country');


// Plans


//Route::get('/plans', 'PlanController@index')->name('plans');
//Route::get('/plans/create', 'PlanController@create')->name('plans.create');
//Route::post('/plans/store', 'PlanController@store')->name('plans.store');
//Route::get('/plans/show/{id}', 'PlanController@show')->name('plans.show');

//Route::get('/plans/loaditems/{plan_id}', 'PlanController@loaditems')->name('plans.loaditems');
//Route::get('/plans/item/{item_id}', 'PlanController@item')->name('plans.item');
//Route::get('/plans/item/modalrecipes/{item}/category/{category}','PlanController@modalrecipes')->name('plans.modalrecipes');
//Route::get('/plans/item/modalrecipesload/{item}/category/{category}','PlanController@modalrecipesload')->name('plans.modalrecipesload');
//Route::post('/plans/item/addrecipe/{item_id}','PlanController@addrecipe')->name('plans.addrecipe');



// Plan routes

// Posebno se setuju rute koje ne kreiraju dinamicki sa resource
Route::namespace('Plan')->group(function () {
   
	// Plans
    Route::get('/plans/load', 'PlanController@load')->name('plans.load')->middleware('location');
    Route::get('/plans/search', 'PlanController@search')->name('plans.search')->middleware('location');
    Route::get('/plans/notiflocation', 'PlanController@notiflocation')->name('plans.notiflocation');
	Route::resource('plans', 'PlanController', 
		[
			'names' => [
				'index' 	=> 'plans',
				'create' 	=> 'plans.create',
				'store' 	=> 'plans.store',
				'show' 		=> 'plans.show',
				'edit'		=> 'plans.edit',
				'update'	=> 'plans.update'	
			]
	])->middleware('location');


	// Plan items
	//Route::get('/plans/{plan_id}/items/load', 'PlanItemController@load')->name('plans.items.load');
	Route::get('/plans/{plan_id}/items/{item_id}/list', 'PlanItemController@list')->name('plans.items.list');
	Route::get('/plans/{plan_id}/items/{item_id}/recipesreport', 'PlanItemController@recipesreport')->name('plans.items.recipesreport');
	Route::get('/plans/{plan_id}/items/{item_id}/groceriesreport', 'PlanItemController@groceriesreport')->name('plans.items.groceriesreport');
	Route::resource('plans.items', 'PlanItemController', 
		[
			'names' => [
				'index' 	=> 'plans.items',
				'show' 		=> 'plans.items.show',
			]
		],

		['only' => ['index', 'show']

	]);


	// Plan item recipes
	Route::get('/plans/{plan_id}/items/{item_id}/recipe/category/{category_id}/index', 'PlanItemRecipeController@index')->name('plans.items.recipe');
	Route::get('/plans/{plan_id}/items/{item_id}/recipe/category/{category_id}/load', 'PlanItemRecipeController@load')->name('plans.items.recipe.load');
	Route::post('/plans/{plan_id}/items/{item_id}/recipe/category/{category_id}/add', 'PlanItemRecipeController@add')->name('plans.items.recipe.add');
	Route::get('/plans/{plan_id}/items/{item_id}/recipe/category/{category_id}/show', 'PlanItemRecipeController@show')->name('plans.items.recipe.show');
	Route::get('/plans/{plan_id}/items/{item_id}/recipe/category/{category_id}/destroy', 'PlanItemRecipeController@destroy')->name('plans.items.recipe.destroy');
	Route::get('/plans/{plan_id}/items/{item_id}/recipe/category/{category_id}/search', 'PlanItemRecipeController@search')->name('plans.items.recipe.search');
	


	

});





\Event::listen('illuminate.query',function($query){
    var_dump($query);
});

