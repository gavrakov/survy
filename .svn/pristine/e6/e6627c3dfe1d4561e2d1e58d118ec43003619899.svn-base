<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Auth;
use Image;
use File;


class UserController extends Controller
{
    // Kontstruktor
    function __construct() {

		$this->middleware('auth');    	

    }

    // Show user profile
    public function profile() {
    	return view('user/profile',['user'=>Auth::user()]);
    }


    // Handle update users avatar
    public function update(Request $request){

    	//var_dump($request->file('avatar'));

    	if($request->hasFile('avatar')){

    		$user = Auth::user();
    		$avatar = $request->file('avatar');

    		// Settings a photo name
    		$filename = hash('sha256', $user->id) . '.' . $avatar->getClientOriginalExtension();

    		$img = Image::make($avatar);

    		// Changing rotation and formation of image
    		$img->orientate();
    		$img->resize(300,300);

    		// Settings the filepath to upload image
    		$filepath = public_path('uploads/users/') . $filename;

    		//var_dump($filepath);

    		// Deleting the file if it exsists
    		if(File::exists($filepath)) {
    			File::delete(public_path($filepath));
    		}

    		// Saves image
    		$img->save($filepath);

    		// Update users avatar
    		$user->avatar = $filename;
    		$user->save();

    		// Redirection
    		return redirect('/user')->with('status','Photograph uploaded successfully');

    	}

    	//return view('user/profile', array('user' => Auth::user()));

    	// Ovde treba da prosledim gresku
    	return redirect('/user')->with('status','Error');
    	//return back()->withInput();

    }
}
