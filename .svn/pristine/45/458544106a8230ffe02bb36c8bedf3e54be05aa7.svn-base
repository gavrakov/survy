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




// OVDE PRIKAZUJE DA JE NEAKTIVAN  - NE ZNAM ZASTO?
//dd(LocationManager::isActive());



//dd(PlanManager::isActive());

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// Users routes
Route::get('/user', 'UserController@profile')->name('user.profile');
Route::post('/user/update', 'UserController@update')->name('user.update');


// Recipes routes
Route::get('/recipes', 'RecipeController@index')->name('recipes');
Route::get('/recipes/create', 'RecipeController@create')->name('recipes.create');
Route::post('/recipes/store', 'RecipeController@store')->name('recipes.store');
Route::get('/recipes/search', 'RecipeController@search')->name('recipes.search');
Route::get('/recipes/show/{id}', 'RecipeController@show')->name('recipes.show');
Route::get('/recipes/edit/{id}', 'RecipeController@edit')->name('recipes.edit');
Route::put('/recipes/update/{id}', 'RecipeController@update')->name('recipes.update');
Route::post('/recipes/upload/{id}', 'RecipeController@upload')->name('recipes.upload');
Route::get('/recipes/destroy/{id}', 'RecipeController@destroy')->name('recipes.destroy');
Route::get('/recipes/load','RecipeController@load')->name('recipes.load');
Route::get('/recipes/description/{id}','RecipeController@description')->name('recipes.description');
Route::put('/recipes/upddescription/{id}', 'RecipeController@upddescription')->name('recipes.upddescription');
Route::get('/recipes/modalphotos/{id}','RecipeController@modalphotos')->name('recipes.modalphotos');
Route::get('/recipes/modalphotosload/{id}','RecipeController@modalphotosload')->name('recipes.modalphotosload');
Route::put('/recipes/updcover/{id}', 'RecipeController@updcover')->name('recipes.updcover');
Route::put('/recipes/destroyphoto/{id}', 'RecipeController@destroyphoto')->name('recipes.destroyphoto');
Route::get('/recipes/loadphotos/{id}','RecipeController@loadphotos')->name('recipes.loadphotos');
Route::get('/recipes/modalgroceries/{id}','RecipeController@modalgroceries')->name('recipes.modalgroceries');
Route::get('/recipes/modalbasketload/{id}','RecipeController@modalbasketload')->name('recipes.modalbasketload');
Route::get('/recipes/basketload/{id}','RecipeController@basketload')->name('recipes.basketload');
Route::get('/recipes/modalgroceriesload/{id}','RecipeController@modalgroceriesload')->name('recipes.modalgroceriesload');
Route::post('/recipes/addgrocery/{id}','RecipeController@addgrocery')->name('recipes.addgrocery');
Route::post('/recipes/delgrocery/{id}','RecipeController@delgrocery')->name('recipes.delgrocery');
Route::get('/recipes/{recipe_id}/groceriessearch', 'RecipeController@groceriessearch')->name('recipes.groceriessearch');



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



// Plan routes test

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

