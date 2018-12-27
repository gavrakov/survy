@extends('layouts.app')
@section('content')

@php 
    $categories = $data['categories'];
    $location   = $data['location'];
@endphp

<div class="row">

    <!-- Navbar - categories -->
    <div class="col-md-2">
        <nav role="categories"> 

            <!-- Search -->
            <div class="text-center p-0 mb-4">
                <input type="text" style="width:100%;" id="search" name="search" class="form-control" placeholder="Search...">
                <input type="hidden" style="width:100%;" id="url_holder" name="url" value="{{route('recipes.load', ['category' => '0'])}}" class="form-control">
                <input type="hidden" style="width:100%;" id="category_holder" name="category" value="0" class="form-control">
            </div>

             <!-- Create new -->
            <div class="text-center mb-3">
                <span id="create_recipe" class="btn btn-info btn-sm" style="width:100%" data-toggle="modal" data-target="#m_create_plan">
                    <i class="fas fa-plus"></i>&nbsp; Create new recipe
                </span>
            </div>

            <!-- Cateogry navigation -->
            <div class="navbar-categories mb-3">   
                <ul id="categories-menu" class="list-unstyled components sidebar">
                    <li id="0" class="nav-item-active">
                        <!---a class="nav-link" href="#" onClick="loadRecipes('{{route('recipes.load', ['category' => '0'])}}','0');">All recipes</a-->
                         <a class="nav-link" href="{{route('recipes.load', ['category' => 0])}}">All recipes</a>
                    </li>
                    @foreach ($categories as $category)
                      <li id="{{$category->id}}" class="nav-item">
                        <!--a class="nav-link" href="#" onClick="loadRecipes('{{route('recipes.load', ['category' => $category->id])}}','{{$category->id}}');">{{$category->name}}</a -->
                        <a class="nav-link" href="{{route('recipes.load', ['category' => $category->id])}}">{{$category->name}}</a>
                      </li>
                      <!--script type="text/javascript">

                        $('#{{$category->id}}').loadbycategory({
                            url: "{{route('recipes.load', ['category' => $category->id])}}",
                            category: '{{$category->id}}',
                            menu: '#category-menu',
                            container: '#recipes',

                      });

                    </script-->
                    @endforeach
                </ul>
            </div>
        </nav>
    </div>

    <div id="holder" class="col-md-10">
        <div id="recipes" class="card-columns-recipes">
            <!-- Load recipes -->

        
        </div>


        <div id="ajax-load" class="offset-5 mb-5" style="display:none; z-index:500;">
            <p><img src="{{asset('storage/icons/loading.gif')}}" style="width: 16px;"></img>&nbsp;Loading More Recipes</p>
        </div>

        <div class="offset-10">
            <button id="show_more" class="btn btn-info btn-circle btn float-right mb-3"><i class="fas fa-chevron-down"></i></button>
        </div>
    </div> <!-- col md-10 - end -->


    
</div>


<script type="text/javascript">


$(document).ready(function(){


    // Load all recipes
    $("#recipes").dataLoader("{{ route('recipes.load',['category' => '0']) }}");


    // Modal Create/Edit
    $('#create_recipe').on('click',function(){
        showModal('{{ route('recipes.create') }}','create'); 
    });


    // Page loader - Loads data depends of category
    $("#categories-menu").pageLoader("{{route('recipes.load', ['category' => 0])}}","#recipes");


    // Show button
    $("#categories-menu").on('click', function(){
        $("#show_more").show();
    });


    // Search recipes
    $("#search").searchLoader("#recipes");



    // Load more data - Infinite scroll paggination
    $("#show_more").loadMore('#recipes','#ajax-load');

    

});


// Delete recipe - Ne radi, ne prepoznaje destroy rutu
function deleteRecipe(url) {

 
    $.ajax({
        headers: {'X-CSRF-TOKEN' : '{{ csrf_token() }}'},
        type: 'delete',
        url: url,
        dataType: 'html',

        success: function(response) {

            // Prikaz notifikacije
            showNotification('success', 'The recipe was succcessfully deleted');

            loadDivData("{{ route('recipes.load',['category' => '0']) }}","recipes");

            console.log(response);
        },

        error: function(response) {

            // Prikaz notifikacije
            showNotification('danger', 'The recipe could not be deleted');

            console.log(response);
        }

    });
   
}




/* 
* Save recipe  
*/
 function save(modal_id) {

    var name = $("#name");
    var category = $("#category");
    var persons = $("#persons");
    var form = $("#create_f");
    var public = $("#public:checked").val();


    $.ajax({
        headers: {'X-CSRF-TOKEN' : '{{ csrf_token() }}'},
        type: 'post',
        url: form.attr("action"),
        dataType: 'json',
        data: form.serialize(),

        success: function(response) {

            console.log(response[1]);

            // Form reset
            form[0].reset();

            $("#" + modal_id).modal('hide');

            var url_redirect = '{{URL::to('recipes')}}'; 

            // Full url with recipe id
            window.location.replace(url_redirect + '/' + response[1]);

       },

        error: function(response) {

            // Show errores
            showValidationErrors(response);
        }  

    });

}
 
</script>
 

<script type="text/javascript">
 
$.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });


// Add scroll to the page
//$("body").css('overflow-y','scroll');

</script>

@endsection
