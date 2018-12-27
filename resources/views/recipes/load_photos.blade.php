<?php $photos = $recipe->photos()->get(); ?>

@foreach ($photos as $photo)
        <a href="{{ asset('storage/photos/recipes') . '/'. $photo->dir .'/'. $photo->name}}">
        	<img width="170px" style="margin: 2px;" name="{{$photo->id}}" src="{{asset($photo->link_md() .'?'. date('h:i:sa')) }}">
    	</a>
@endforeach

<br><br>

