<?php $photos = $recipe->photos()->get(); ?>

@foreach ($photos as $photo)
        <a href="{{ asset('storage/photos/recipes') . '/'. $photo->dir .'/'. $photo->name}}"><img style="margin-bottom:3px;" name="{{$photo->id}}" src="
            <?php
                $path = 'storage/photos/recipes/' . $photo->dir .  '/thumbs/150_' . $photo->name;
                echo asset($path);
            ?>"
        	>
        </span>
    </a>
    
@endforeach

<br><br>

