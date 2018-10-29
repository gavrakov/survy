<?php $recipe = $data['recipe']; ?>
<?php $item = $data['item']; ?>
<?php $location = $data['location']; ?>
<?php $category = $data['category']; ?>

@if (isset($recipe))

	<div class="col-md-3">

		<!-- Photo -->
		<img style="position:relative; width:60px;  border-radius:100%; padding: 2px; border:1px #888888 solid"

        src="{{asset($recipe->cover_link_sm())}}"

        style="position:relative; border-radius:3%; border:1px">

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
		<span id="btn_{{$recipe->id}}" class="btn btn-light btn-sm" onClick="deleteRecipe({{$item->id}},{{$category}},'{{route('plans.items.recipe.destroy',['plan_id' => $item->plan_id, 'item_id' => $item->id, 'category_id' => $category])}}');"><i class="fas fa-trash"></i>&nbsp; Remove</span>
	</div>

@else

	@if ($category == 1)
		<p id="brakfast_p" class="text-justify ml-3"><i>No breakfast for today...</i></p>
	@endif

	@if ($category == 2)
		<p id="lunch_p" class="text-justify ml-3"><i>No lunch for today...</i></p>
	@endif

	@if ($category == 3)
		<p id="dinner_p" class="text-justify ml-3"><i>No dinner for today...</i></p>
	@endif

@endif