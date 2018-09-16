 <?php
$recipes 	= $data['recipes'];
$item 		= $data['item'];
$category	= $data['category'];
$plan 		= $data['plan'];

if (session()->has('location')) {
	$location 	= $data['location'];
}

 ?>

 <div class="row">
 	
	<form name="f_add_recipe" id="f_add_recipe" type="post" action="">
	    <!--input name="f_category" id="f_category" value="{{$category}}" type="text" class="form-control" value="" hidden-->
	    <input name="f_recipe" id="f_recipe" type="text" class="form-control" value="" hidden>
	</form>

 </div>

 @if (isset($recipes))
 	@foreach ($recipes as $recipe)

		<div id="recipe_holder" class="row">
			<div class="col-md-3">

				<!-- Photo -->
				<img width="60px" src="<?php 

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
				<span id="btn_{{$recipe->id}}" class="btn btn-default btn-sm" onClick="insertRecipe({{$recipe->id}},{{$item->id}},{{$category}},'{{route('plans.items.recipe.add',['plan_id' => $item->plan_id, 'item_id' => $item->id, 'category_id' => $category])}}');"><i class="fa fa-plus fa-fw"></i>&nbsp Add</span>
			</div>
		                                     

		</div>

		<hr>
	@endforeach

	<div id="pagination_container" class="row">
		<div class="col-md-12 col-md-offset-4">{{ $recipes->links()}}</div>
	</div>
 
 @endif 


<script type="text/javascript">

 // Pagination
$(function() {
    $('#recipes > #pagination_container').on('click', '.pagination a', function(e) {
        e.preventDefault();
        var url = $(this).attr('href');  
        getRecipes(url);
        window.history.pushState("", "", url);
    });


    function getRecipes(url) {
        $.ajax({
            type: 'get',
            url : url ,
            dataType: 'html' 
        }).done(function (data) {
            $('#recipes').html(data);  
        }).fail(function () {
            alert('Recipes could not be loaded.');
        });
    }
});

</script>