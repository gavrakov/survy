<?php $recipe = $data['recipe']; ?>
<?php $item = $data['item']; ?>
<?php $location = $data['location']; ?>
<?php $category = $data['category']; ?>

@if (isset($recipe))

	<p class="card-text">

		<!-- Photo -->
		<img style="position:relative; width:60px;  border-radius:100%; padding: 2px; border:1px #888888 solid"

        src="{{asset($recipe->cover_link_sm())}}"

        style="position:relative; border-radius:3%; border:1px">

	</p>

	<!-- Name -->
	<p class="card-text">
		<p>{{$recipe->name}}</p>
	</div>

	<!-- Price -->
	@if (session()->has('location'))

		<div class="card-text">
			<p>
				@if ($category == 1)
		        	{{$item->getBreakfastPrice()}}
		        @elseif ($category == 2)
		        	{{$item->getLunchPrice()}}
		        @elseif ($category == 3) 
		        	{{$item->getDinnerPrice()}}	
		        @endif
	        	<small class='text-danger'>&nbsp;({{$location->currency}})</small>
	        </p>
		</div>

	 @endif

	<!-- Button -->
	<div class="card-text">
		<span id="btn_{{$recipe->id}}" class="btn btn-light btn-sm" onClick="deleteRecipe({{$item->id}},{{$category}},'{{route('plans.items.recipe.destroy',['plan_id' => $item->plan_id, 'item_id' => $item->id, 'category_id' => $category])}}');"><i class="fas fa-trash"></i>&nbsp; Remove</span>
	</div>

@else

	@if ($category == 1)
		<div id="breakfast_zone" style="border: 1px dashed #d4d4d4; padding: 60px 10px; background-color:#fafafa; color:#e1e1e1;">
			<i class="fas fa-plus"></i>
		</div>

	@endif

	@if ($category == 2)
		<div id="lunch_zone" style="border: 1px dashed #d4d4d4; padding: 60px 10px; background-color:#fafafa; color:#e1e1e1;">
			<i class="fas fa-plus"></i>
		</div>
	@endif

	@if ($category == 3)
		<div id="dinner_zone" style="border: 1px dashed #d4d4d4; padding: 60px 10px; background-color:#fafafa; color:#e1e1e1;">
			<i class="fas fa-plus"></i>
		</div>
	@endif

@endif


<script type="text/javascript">

	// Add/edit breakfast
    $('#breakfast_zone').css( 'cursor', 'pointer' );
    $('#breakfast_zone').on('click', function(){
        showModal("{{ route('plans.items.recipe',['plan_id' => $item->plan_id, 'item_id' => $item->id, 'category_id' => 1]) }}",'m_recipes').parent();
    });

	// Add/edit lunch
    $('#lunch_zone').css( 'cursor', 'pointer' );
    $('#lunch_zone').on('click', function(){
        showModal("{{ route('plans.items.recipe',['plan_id' => $item->plan_id, 'item_id' => $item->id, 'category_id' => 2]) }}",'m_recipes').parent();
    });
	
	// Add/edit dinner
    $('#dinner_zone').css( 'cursor', 'pointer' );
    $('#dinner_zone').on('click', function(){
        showModal("{{ route('plans.items.recipe',['plan_id' => $item->plan_id, 'item_id' => $item->id, 'category_id' => 3]) }}",'m_recipes').parent();
    });

</script>