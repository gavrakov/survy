<?php

namespace App\Services;

use Auth;
use Image;
use Illuminate\Support\Facades\Storage;


/*
* Photo manager service - Upload, manage, crop, photos
OVO DEFINITIVNO SREDITI - ALI RADI - PROSLEDITI PARAMETRE ZA VELICINU FOTOGORAFIJE IZ CONFIGA
*/
class PhotoManager {


	/*
	* Filename of the uploaded photo
	*/
	protected $filename;


	/*
	* Filename of the uploaded middle size photo
	*/
	protected $filname_md;


	/*
	* Filename of the uploaded small size photo
	*/
	protected $filname_sm;



	/*
	* Return the filename with extension of the uploaded photo
	*/
	public function filename($size = 'lg'){

		switch ($size) {

			// Name of large sized
			case 'lg':
				return $this->filename;
				break;

			// Name of middle sized
			case 'md':
				return $this->filename_md;
				break;

			// Name of small sized
			case 'sm':
				return $this->filename_sm;
				break;

			default:
				return $this->filename;
				break;
		}

	}



	/*
	* Upload a photograph and make thumbnails
	* @photo File
	* @path string - path of the directory to store photo
	* @name string/Int - unique directory for storing photos (like recipe id or something)
	*/
	public function uploadWithThumbnails($photo, $path, $name){


                // Make filename to upload and store in database
                $filename = pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME); //. '_' .time();

                
                $extension = $photo->getClientOriginalExtension();
                $filenameToStore = $filename . '.' . $extension;

                $this->filename = $filenameToStore;
                $this->filename_md = 'md_' . $filename . '.' . $extension;
                $this->filename_sm = 'sm_' . $filename . '.' . $extension;
               

                // Directory for storing photos
                $default_dir = $path;
                $photos_dir = $default_dir . hash('sha256', $name). '/';


                if (Storage::exists($photos_dir . $this->filename)) {

                    $filename = $this->createRandomFilename($filename,$extension);
                    $this->filename = $filename;
                    $this->filename_md = 'md_' . $filename;
                    $this->filename_sm = 'sm_' . $filename;
                }



                // Directory for storing photos thumbs
                $thumbs_dir = $photos_dir . config('photos.storage.thumbs');

                // Upload photo
                $photo->storeAs($photos_dir,$this->filename);

                // Upload middle thumb
                $photo->storeAs($thumbs_dir,$this->filename_md);

                 // Upload small thumb
                $photo->storeAs($thumbs_dir,$this->filename_sm);

                // Photo full path
                $photoPath = $photos_dir . $this->filename;

                // Middle thumb fullpath
                $thumbsPath_md = $thumbs_dir . $this->filename_md;

                // Small thumb fullpath
                $thumbsPath_sm = $thumbs_dir . $this->filename_sm;

                // Image width/height
                $img_width = Image::make($photo->getRealPath())->width();
                $img_height = Image::make($photo->getRealPath())->height();


                // Ako je sirina veca od duzine
                if ($img_width > $img_height) {

                    // Lg - resize - h
                    $main_photo = Image::make(Storage::get($photoPath))->resize(null,config('photos.size.max_height'), function($constraint){
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })->encode();


                    // Md - crop
                    $thumb_md = Image::make(Storage::get($thumbsPath_md))->resize(null,config('photos.size.thumb.height_md'),function($constraint){
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })->fit(config('photos.size.thumb.height_md'))->encode();


                    // Sm - crop
                    $thumb_sm = Image::make(Storage::get($thumbsPath_sm))->resize(null,config('photos.size.thumb.height_sm'),function($constraint){
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })->fit(config('photos.size.thumb.height_sm'))->encode();

                // Sirina manja od duzine    
                } else {


                    // Lg - resize - w
                    $main_photo = Image::make(Storage::get($photoPath))->resize(config('photos.size.max_width'),null, function($constraint){
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })->encode();


                    // Md - crop
                    $thumb_md = Image::make(Storage::get($thumbsPath_md))->resize(config('photos.size.thumb.width_md'),null,function($constraint){
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })->fit(config('photos.size.thumb.width_md'))->encode();


                    // Sm - crop
                    $thumb_sm = Image::make(Storage::get($thumbsPath_sm))->resize(config('photos.size.thumb.width_sm'),null,function($constraint){
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })->fit(config('photos.size.thumb.width_sm'))->encode();

                }

                // Save resized photo
                Storage::put($photoPath, $main_photo);
                Storage::put($thumbsPath_md, $thumb_md);
                Storage::put($thumbsPath_sm, $thumb_sm);

                return;

	}



	/*
	* Delete photograph -- SREDITI
	* @path string - directory of all photos
	*/
	/*public function delete($){

		$thumb_path = $path . 

        // Brisanje fotografija ukljucujuci i thumbnail fotke
        Storage::delete([$photo_path,$thumb_300,$thumb_150]);

	}
	*/



	/*
	* Create random filename
	*/
	public function createRandomFilename($filename='',$extension){
		return $filename . rand(1,100) . '.' . $extension;

	}



	// Croping photos for thumbnails edit
	public function crop() {

		 /*$thumb_300 = Image::make(Storage::get($thumbsPath_300))->resize(null,320,function($constraint){
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })->crop(300,300,3,3)->encode();*/

                     /*$thumb_150 = Image::make(Storage::get($thumbsPath_150))->resize(null,120,function($constraint){
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })->crop(100,100,1,1)->encode();*/

		 /* $thumb_300 = Image::make(Storage::get($thumbsPath_300))->resize(320,null,function($constraint){
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })->crop(300,300,3,3)->encode();*/

                        /*$thumb_150 = Image::make(Storage::get($thumbsPath_150))->resize(120,null,function($constraint){
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })->crop(100,100,1,1)->encode();*/
	}


}




?>