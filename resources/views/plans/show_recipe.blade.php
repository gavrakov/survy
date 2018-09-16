<?php $recipe = $data['recipe']; ?>
<?php $item = $data['item']; ?>
<?php $location = $data['location']; ?>
<?php $category = $data['category']; ?>

@if (isset($recipe))

	<div class="col-md-3">

		<!-- Photo -->
		<img width="50px" src="<?php 

	        // Vraca collection of object
	        $photo = $recipe->cover()->first();

	        $path = 'storage/photos/recipes/' . $photo['dir'] .  '/thumbs/150_' . $photo['name'];
	        
	        echo asset($path);
	        
	        ?>" style="position:relative; border-radius:3%; border:1px">
	</div>

	<!-- Name -->
	<div class="col-md-3">
		<p>{{$recipe->name}}</p>
	</div>


	<!-- Price -->
	@if (session()->has('location'))

		<div class="col-md-3">
			<p>{{number_format((float)$recipe->getTotalPrice(), 2, '.', '')}}
	        <small class='text-danger'>({{$location->currency}})</small>
	        </p>
		</div>

	 @endif

	<!-- Button -->
	<div class="col-md-3">
		<span id="btn_{{$recipe->id}}" class="btn btn-default btn-sm btn-circle" onClick="deleteRecipe({{$item->id}},{{$category}},'{{route('plans.items.recipe.destroy',['plan_id' => $item->plan_id, 'item_id' => $item->id, 'category_id' => $category])}}');"><i class="fa fa-times"></i></span>
	</div>

@else

	@if ($category == 1)
		<p id="brakfast_p" class="text-justify">No breakfast for today...</p>
	@endif

	@if ($category == 2)
		<p id="lunch_p" class="text-justify">No lunch for today...</p>
	@endif

	@if ($category == 3)
		<p id="dinner_p" class="text-justify">No dinner for today...</p>
	@endif

@endif