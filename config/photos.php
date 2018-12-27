<?php

return [

	/*
    |--------------------------------------------------------------------------
    | Photos - everything for app uploaded photos, icons, ...
    |--------------------------------------------------------------------------
	*/
 

 	// Storage path
	'storage' => [


		// Default directory for uploading photos
		'root' => 'storage/photos/',


		// Directory of recipes photos
		'recipes' => 'storage/photos/recipes/',


		// Directory of photos thumbnails
		'thumbs' => 'thumbs/',


		// Directory of app icons
		'icons' => 'storage/icons/',

	],

	// Public path
	'public' => [

		// Default directory for uploading photos
		'root' => 'public/photos/',


		// Directory of recipes photos
		'recipes' => 'public/photos/recipes/',


		// Directory of app icons
		'icons' => 'public/icons/'
	],


	// Size settings
	'size' => [

		// Maximum width size 800 pixels
		'max_width' => 800,


		// Maximum height size 800 pixels
		'max_height' => 600,


		// Thumbnail size
		'thumb' => [

			// Thumbnail middle width 320 pixels
			'width_md' => 320,


			// Thumbnail middle height 320 pixels
			'height_md' => 320,


			// Thumbnail small width 120 pixels
			'width_sm' => 120,


			// Thumbnail small height 120 pixels
			'height_sm' => 120,

		]


		
	]

	

];