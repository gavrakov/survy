<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Recipe;
use App\Plan;
use App\PlanItemList;
use Illuminate\Support\Facades\DB;


class PlanItem extends Model
{


	protected $fillable = ['plan_id','breakfast','lunch','dinnner'];



	// Returns the breakfast data
	public function breakfast(){
			return $this->belongsTo('App\Recipe','breakfast');
	}



    // Returns the lunch data
	public function lunch(){
			return $this->belongsTo('App\Recipe','lunch');
	}



	// Returns the dinner data
	public function dinner(){
			return $this->belongsTo('App\Recipe','dinner');
	}



	// Returns the list of the groceries
	public function list(){
		return $this->hasMany('App\PlanItemList','item_id','id');
	}



	// Remove item grocery list
	public function removeList(){

		$list = $this->list()->get();

		foreach ($list as $l) {
            $l->delete();
        }

	}


	// Remove breakfast from list
	public function removeBreakfastFromList() { // OVO IZGLEDA NE RADI

	    $breakfast = $this->breakfast()->first();
	    $groceries = $this->list()->where('breakfast',$breakfast->id)->get();

	    foreach ($groceries as $grocery) {
	    	$grocery->delete();
	    }
	}



	// Remove lunch from list
	public function removeLunchFromList() {

	    $lunch = $this->lunch()->first();
	    $groceries = $this->list()->where('lunch',$lunch->id)->get();

	    foreach ($groceries as $grocery) {
	    	$grocery->delete();
	    }
	}



	// Dinner lunch from list
	public function removeDinnerFromList() {

	    $dinner = $this->dinner()->first();
	    $groceries = $this->list()->where('dinner',$dinner->id)->get();

	    foreach ($groceries as $grocery) {
	    	$grocery->delete();
	    }
	}



	// Insert recipe groceries to the item list - OVO NE RADI!
	public function addLunchToList(){

		$plan = Plan::find($this->plan_id)->first();
	    $recipe = $this->lunch()->first();

        // Setovanje namirnica recepta
		$groceries = RecipeGroceriesRelation::all()->where('recipe_id',$recipe->id);

		// Brisanje namirnica starog recepta - ako postoji
		$this->removeLunchFromList();
	
		foreach($groceries as $grocery) {

			$list = new PlanItemList();
			$list->item_id = $this->id;
			$list->lunch = $recipe->id;
			$list->grocery_id = $grocery->grocery()->first()->id;
			$list->quantity = $this->calculateQuantity($grocery,$recipe->persons,$plan->persons);
			$list->price = $this->calculatePrice($grocery,$list->quantity);

			$list->save();
		}
    }



    // Add breakfast to the list
    public function addBreakfastToList(){


		$plan = Plan::find($this->plan_id)->first();
	    $recipe = $this->breakfast()->first();

        // Setovanje namirnica recepta
		$groceries = RecipeGroceriesRelation::all()->where('recipe_id',$recipe->id);

		// Brisanje namirnica starog recepta - ako postoji
		$this->removeBreakfastFromList(); // OVO IZGLEDA NE RADI
	
		foreach($groceries as $grocery) {

			$list = new PlanItemList();
			$list->item_id = $this->id;
			$list->breakfast = $recipe->id;
			$list->grocery_id = $grocery->grocery()->first()->id;
			$list->quantity = $this->calculateQuantity($grocery,$recipe->persons,$plan->persons);
			$list->price = $this->calculatePrice($grocery,$list->quantity);

			$list->save();
		}
    }



    // Add dinner to the list
    public function addDinnerToList(){

    	$plan = Plan::find($this->plan_id)->first();
	    $recipe = $this->dinner()->first();

        // Setovanje namirnica recepta
		$groceries = RecipeGroceriesRelation::all()->where('recipe_id',$recipe->id);

		// Brisanje namirnica starog recepta - ako postoji
		$this->removeDinnerFromList();
	
		foreach($groceries as $grocery) {

			$list = new PlanItemList();
			$list->item_id = $this->id;
			$list->dinner = $recipe->id;
			$list->grocery_id = $grocery->grocery()->first()->id;
			$list->quantity = $this->calculateQuantity($grocery,$recipe->persons,$plan->persons);
			$list->price = $this->calculatePrice($grocery,$list->quantity);

			$list->save();
		}
    }



    /*
	* Vraca vrednost realne kolicine namirnice, u zavisnosti od broja osoba za koje je pravljen plan
    */
    public function calculateQuantity(RecipeGroceriesRelation $grocery, $recipe_persons, $plan_persons) {

    	// Kolicina namirnice koja ce se prilagoditi broju osoba plana
		$plan_quantity = 0.00;

		// Osnovna kolicina namirnice - kolicna iz recepta
		$base_quantity = floatval($grocery->getGroceryQuantity());

		// Racunanje kolicine i cene
		if($base_quantity > 0 && $grocery->quantity > 0) {

			// Nova kolicina - formula: kolicina(recept) / broj_osoba(recept) * broj_osoba(plan)
			$plan_quantity = floatval($grocery->quantity / $recipe_persons * $plan_persons);

		}

		return $plan_quantity;
    }



    /*
	* Vraca vrednost realne cene namirnice, u zavisnosti od broja osoba za koje je pravljen plan
    */
    public function calculatePrice(RecipeGroceriesRelation $grocery, $plan_quantity) {

		// Cena namirnice u odnosu na novu kolicinu
		$new_price = 0.00;

		// Osnovna kolicina namirnice - kolicna iz recepta
		$base_quantity = floatval($grocery->getGroceryQuantity());

		// Osnovna cena namirnice - cena iz recepta
		$base_price = floatval($grocery->getGroceryPrice());

		// Racunanje kolicine i cene
		if($base_quantity > 0 && $base_price > 0 && $grocery->quantity > 0) {

			// Nova cena - fromula: kolicina(plan) / osnovna kolicina * osnovna cena
			$new_price = floatval($plan_quantity / $base_quantity * $base_price);
		}

		return $new_price;
    }



    /*
	* Vraca ukupnu cenu dana
    */
    public function getTotalPrice(){
    	return $this->list()->sum('price');
    }



    /*
	* Vraca ukupnu cenu dorucka
    */
    public function getBreakfastPrice(){
    	return $this->list()->where('breakfast','=', $this->breakfast)->sum('price');
    }


    /*
	* Vraca ukupnu cenu rucka
    */
    public function getLunchPrice(){
    	return $this->list()->where('lunch','=', $this->lunch)->sum('price');
    }


    /*
	* Vraca ukupnu cenu vecere
    */
    public function getDinnerPrice(){
    	return $this->list()->where('dinner','=', $this->dinner)->sum('price');
    }






}
