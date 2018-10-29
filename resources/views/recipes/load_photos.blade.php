<?php $photos = $recipe->photos()->get(); ?>

@foreach ($photos as $photo)
        <a href="{{ asset('storage/photos/recipes') . '/'. $photo->dir .'/'. $photo->name}}">
        	<img style="margin-bottom:3px;" name="{{$photo->id}}" src="{{asset($photo->link_sm())}}">
    	</a>
    
@endforeach

<br><br>

