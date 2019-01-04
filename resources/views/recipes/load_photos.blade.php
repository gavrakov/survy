@php $photos = $recipe->photos()->get(); @endphp

@if(!empty($photos))
	@foreach ($photos as $photo)
	        <a href="{{ asset('storage/photos/recipes') . '/'. $photo->dir .'/'. $photo->name}}">
	        	<img width="170px" style="margin: 2px;" name="{{$photo->id}}" src="{{asset($photo->link_md() .'?'. date('h:i:sa')) }}">
	    	</a>
	@endforeach
@else
	<p>No photos for this recipe</p>
@endif


