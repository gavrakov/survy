<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Grocery;
use Illuminate\Support\Facades\Redirect;
use App\GroceriesCategory;
use App\GroceriesUnite;
use Illuminate\Support\Facades\DB;
use App\GroceriesPrices;
use App\Country;


class GroceryController extends Controller
{

    // Konstruktor
    public function __construct(){
        $this->middleware('auth');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['form_data']['location'] = null;

        // U koliko je setovana lokacija plana
        if(session()->has('location') !== null) {
            $data['form_data']['location'] = Country::find(session('location'));
        }

        return view('groceries/groceries')->with('form_data',$data['form_data']);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      
        $data['form_data']['categories'] = GroceriesCategory::all();
        $data['form_data']['unites'] = GroceriesUnite::all();
        $data['form_data']['location'] = null;

        // U koliko je setovana lokacija plana
        if(session()->has('location') !== null) {
            $data['form_data']['location'] = Country::find(session('location'));
        }


        // Ajax
        return view('groceries/modals/m_create')->with('form_data',$data['form_data'])->render();
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if(session()->has('location') == null) {

            //echo 'lokacija nije setovana';
            $this->validate($request,[
                'name' => 'required|unique:groceries|max:255|min:3',
                'quantity' => 'required|numeric|min:0.01'
            ]);

        } else { 

            $this->validate($request,[
                'name' => 'required|unique:groceries|max:255|min:3',
                'quantity' => 'required|numeric|min:0.01',
                'price' => 'required|numeric'
            ]);
            
        }

        // Saving grocery
        $grocery = new Grocery();
        $grocery->name = $request->input('name');
        $grocery->category = $request->input('category');
        $grocery->unite = $request->input('unite');
        $grocery->quantity = $request->input('quantity');
        $grocery->save();


        // Insertovanje cene u koliko je lokacija setovana
        if(session()->has('location')) {

            $price = new GroceriesPrices();

            $price->grocery_id = $grocery->id;
            $price->country_id = $request->session()->get('location');
        
            if ($request->input('price') !== null) {
                $price->price = $request->input('price');
            }


            $price->save();
        }


        if($request->ajax()) {
                return response()->json(['success' => 'success'], 200);
        }

        // Moram da prikazem ovu poruku u View layeru
        return redirect::to('groceries/')->with('message','Grocery successfully inserted');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }



    /** OVO MI TRENUTNO NE RADI, PTREBNO JE SREDITI
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $data['form_data']['grocery'] = Grocery::find($id);
        $data['form_data']['categories'] = GroceriesCategory::all();
        $data['form_data']['unites'] = GroceriesUnite::all();

        $data['form_data']['location'] = null;

        // U koliko je setovana lokacija plana
        if(session()->has('location') !== null) {

            $data['form_data']['location'] = Country::find(session('location'));
            $data['form_data']['grocery'] = Grocery::with('GroceriesPrices')->find($id);
        }

        // Ajax
        return view('groceries/modals/m_edit')->with('form_data',$data['form_data'])->render();  
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        if(session()->has('location') == null) {

            //echo 'lokacija nije setovana';
            $this->validate($request,[
                'name' => 'required|unique:groceries,id,{$id}|max:255|min:3' ,
                'quantity' => 'required|numeric|min:0.01'
            ]);

        } else { 

            $this->validate($request,[
                'name' => 'required|unique:groceries,id,{$id}|max:255|min:3',
                'quantity' => 'required|numeric|min:0.01',
                'price' => 'required|numeric'
            ]);
            
        }

        $grocery = Grocery::find($id);
        $grocery->name = $request->input('name');
        $grocery->category = $request->input('category');
        $grocery->unite = $request->input('unite');
        $grocery->quantity = $request->input('quantity');

        $grocery->save();


        if($request->session()->has('location')) {

            $price = GroceriesPrices::where([['grocery_id',$id],['country_id',session('location')]])->first();

            // Updatuje cenu u koliko je proizvod vezan za lokaciju
            if (count($price) > 0) {

                $price->price = $request->input('price');

            } else {

                $price = new GroceriesPrices();
                $price->grocery_id = $grocery->id;
                $price->country_id = $request->session()->get('location');
                $price->price = $request->input('price');
            }

            $price->save();

        }

        if($request->ajax()) {
                return response()->json(['success' => 'success'], 200);
        }

        return redirect::to('groceries/')->with('message','Grocery successfully updated');

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        // Brisanje cena namirnica za sve lokacije
        GroceriesPrices::where('grocery_id',$id)->delete();

        // Brisanje namirnice
        Grocery::find($id)->delete();

        return response()->json(['success' => 'success'], 200);

    }



    /**
     * Load all groceries
     */
    public function load(Request $request) {

        // Problem resio u modelu Grocery
        // U koliko je setovana lokacija plana, povlaci i cenu

        $data['groceries'] = '';

        if(session()->has('location')) {

            $data['groceries'] = Grocery::with('GroceriesPrices')->orderBy('id','desc')->paginate(10);
        } else {
           
            $data['groceries'] = Grocery::orderBy('id','desc')->paginate(10);
        }

        // Ajax
        if($request->ajax()) {
            return view('groceries/groceries_load')->with('groceries',$data['groceries'])->render();
        }

        // Non ajax
        return view('groceries/groceries')->with('groceries',$data['groceries']);
 
    }



    /**
     * Search recipes
     * 
     * @param Illuminate\Http\Request
     * @return Illuminate\Http\Response
     */
    public function search(Request $request)
    {

        if($request->ajax()) {

            // Ako je unet parametar za pretragu
            if ($request->search != '' ) {
               
                 if(session()->has('location') !== null) {

                    $data['groceries'] = Grocery::where('name','LIKE','%' . $request->search . '%')->with('GroceriesPrices')->orderBy('id','desc')->paginate(10);
                } else {

                    $data['groceries'] = Grocery::where('name','LIKE','%' . $request->search . '%')->orderBy('id','desc')->paginate(10);
                }



            } else { // Ako nije unet parametar za pretragu
 
                if(session()->has('location') !== null) {

                    $data['groceries'] = Grocery::with('GroceriesPrices')->orderBy('id','desc')->paginate(10);

                } else {

                    $data['groceries'] = Grocery::orderBy('id','desc')->paginate(10);
                }
                

            }
                
            return view('groceries/groceries_load')->with('groceries',$data['groceries'])->render();
 
        }
    }
}
