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
	    <input name="f_recipe" id="f_recipe" type="text" class="form-control" value="" hidden>
	</form>

 </div>

 @if (isset($recipes))
 	@foreach ($recipes as $recipe)

		<div id="recipe_holder" class="row">
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
				<span id="btn_{{$recipe->id}}" class="btn btn-light btn-sm" onClick="insertRecipe({{$recipe->id}},{{$item->id}},{{$category}},'{{route('plans.items.recipe.add',['plan_id' => $item->plan_id, 'item_id' => $item->id, 'category_id' => $category])}}');"><i class="fa fa-plus fa-fw"></i>&nbsp; Add</span>
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