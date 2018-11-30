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
                        <a class="nav-link" href="#" onClick="loadRecipes('{{route('recipes.load', ['category' => '0'])}}','0');">All recipes</a>
                    </li>
                    @foreach ($categories as $category)
                      <li id="{{$category->id}}" class="nav-item">
                        <a class="nav-link" href="#" onClick="loadRecipes('{{route('recipes.load', ['category' => $category->id])}}','{{$category->id}}');">{{$category->name}}</a>
                      </li>
                    @endforeach
                </ul>
            </div>
        </nav>
    </div>

    <div id="holder" class="col-md-10">
        <div id="recipes" class="card-columns-recipes" >
            <!-- Load recipes -->

        
        </div>
        <div class="ajax-load text-center" style="display:none">
            <p><img class="center-block" src="{{asset('storage/icons/loading.gif')}}"></img>Loading More post</p>
        </div>

    </div> <!-- col md-10 - end -->

 

    
</div>


<script type="text/javascript">


$(document).ready(function(){

    // Load all recipes
    loadDivData("{{ route('recipes.load',['category' => '0']) }}","recipes");

    // Modal Create/Edit
    $('#create_recipe').on('click',function(){
        showModal('{{ route('recipes.create') }}','create'); 
    });


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


// Load recipe page depends of category
function loadRecipes(url, category){

    //$("#recipes").html('<img class="center-block" src="{{asset('storage/icons/loading.gif')}}"></img>');

    // Add active class
    $("#categories-menu > li").each(function(index,value) {
        $(value).removeClass('nav-item-active');
        $(value).addClass('nav-item');     
    });

    $("#"+category).toggleClass('nav-item-active');
    


    // Set category
    $("#category_holder").val(category);

    // Set url
    $("#url_holder").val(url);

    // Fade out
    $("#recipes").fadeOut("fast");

    $.ajax({
        headers: {'X-CSRF-TOKEN' : '{{ csrf_token() }}'},
        type: 'get',
        url: url,
        dataType: 'html', 

        success: function(response) {
            $("#recipes").html(response);
            $("#recipes").fadeIn("fast");
        },

        error: function(response) {
            $("#recipes").html('<i>The data could not be found</i>');
        }
    });

}


// Live search 
$('#search').on('keyup',function(){

    //$("#recipes").html('<img class="center-block" src="{{asset('storage/icons/loading.gif')}}"></img>');

    // Set url
    var url = $("#url_holder").val();
     
    $.ajax({
     
        type : 'get',
        url : url,
        dataType: 'html',
        data:{'search':this.value},

        success:function(response){

            console.log(response);
            //$("#recipes").fadeOut("fast"); 
            $('#recipes').html(response);  
        }
    });
 
});



/* 
* Save recipe  
*/
 function save(modal_id) {

    var name = $("#name");
    var category = $("#category");
    var persons = $("#persons");
    var form = $("#create_f");


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



// Pagination

/*$(function() {
    $('tbody').on('click', '.pagination a', function(e) {
        e.preventDefault();
        //$('tbody').append('<img style="position: width="15px" absolute; left: 50%; top: 50%; z-index: -100000;" src="<?php  echo asset('images/proccessing.gif'); ?>" />');

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
            $('tbody').html(data);  
        }).fail(function () {
            alert('Recipes could not be loaded.');
        });
    }
});*/



 // Infinite scroll - OVO NE RADI DOBRO, NEKADA BRKA STRANICE ZA KATEGORIJE

   /* var page = 1;
    $(window).scroll(function() {
        if($(window).scrollTop() + $("#recipes").height() >= $(document).height()) {
            page++;
            var page_url = $("#url_holder").val();
            loadMoreData(page,page_url);
        }
    });


function loadMoreData(page,page_url){
    console.log(page_url);
      $.ajax(
            {
                url: page_url + '?page=' + page,
                type: "get",
                beforeSend: function()
                {   
                    $('#holder > #recipes > .ajax-load').show();
                }
            })
            .done(function(data)
            {
                console.log(data);
                if(data == ""){
                    $('.ajax-load').html("No more records found");
                    return;
                }
                $('.ajax-load').hide();
                $("#recipes").append(data);
                $("#recipes").fadeIn("fast");
            })
            .fail(function(jqXHR, ajaxOptions, thrownError)
            {
                alert('server not responding...');
            });
}*/


 
</script>
 

<script type="text/javascript">
 
$.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });


// Add scroll to the page
$("body").css('overflow-y','scroll');

</script>

@endsection
