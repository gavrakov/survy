@extends('layouts.app')
@section('content')

<div class="row">

     
        <div class="col-md-3">

            <!-- Avatar -->
            <div id="recipe_cover" class="card mb-3">
                
                    <div id="avatar" class="card-img">
                        <div class="p-2">
                            <img style="" class="image" width="100%" src="{{asset($recipe->cover_link_md())}}">
                        </div>
                    </div>
            </div>
           
            <!-- Details -->
            <div class="card mb-3">
                <div class="card-body">

                    <div id="details">

                        <span id="recipe_name"><h5>{{$recipe->name}}</h5></span>
                   
                        <p id="recipe_categories" class="d-inline-block mb-2">
                            <i>
                                <?php $counter = 0; ?>
                                @foreach($recipe->categories()->get() as $category)

                                    <?php if($counter != 0) { echo",";}?>

                                    {{$category['name']}}

                                    <?php $counter ++; ?>
                                @endforeach
                            </i>
                        </p>
                   
                        <p class="mb-2">
                            <span class="d-inline-block">Number of persons:</span> 
                            <span id="recipe_persons" class="d-inline-block"><b>{{$recipe->persons}}</b></span>
                        </p> 
                            
                    </div> <!-- Details -->
                </div>  <!-- Card body -->

            </div> <!-- Details Card ends -->


            <div class="card mb-3">
                <div class="card-body">
                    <span class="d-inline-block">Recipe made by<img class="ml-3" style="position:relative; width:25px;  border-radius:100%; padding: 2px; border:1px #888888 solid" src="{{$recipe->user()->cover_link()}}">&nbsp;<i class="text-primary">{{$recipe->user()->name}}</i>
                    </span>
                    
                </div>
            </div>


            <!-- Create new -->
            <div class="text-center mb-3">
                <span id="btn_yum" class="btn btn-info btn-sm" style="width:100%">
                    <i class="far fa-heart"></i>&nbsp; Yum, Yum
                </span>
            </div>



        </div> <!-- col-md-3 -->
                   

        <div class="col-md-5">

            <!-- Description -->
            <div class="card mb-3">
                <div class="card-body">
                    <h6 class="card-title">Description</h6>
                    <p id="description_p" class="text-justify">
                        @if ($recipe->description == '') 
                            <i>No description found...</i>
                        @else
                            {{$recipe->description}}
                        @endif
                    </p>
                </div>
            </div>

            <!-- Photos -->
            <div class="card mb-3">
                <div class="card-body">
                    <h6 class="card-title">Photos</h6>
                   
                    <div id="photos"></div>  
                </div>
                
            </div>

           
        </div>


      
        <div class="col-md-4">

            <!-- Groceries -->
            <div class="card mb-3">
                <div class="card-body p-0">
                   <h6 class="card-title p-3">Groceries</h6>

                    <table id="groceries_basket" class="table">
                        <tbody>
                            <!-- Load basket - Ajax -->
                        </tbody>
                    </table>
                   
                    <!--button id="btn_groceries" class="btn btn-light btn-sm m-3"><i class="fa fa-edit fa-fw"></i>&nbsp;Add groceries</button-->

                </div> 
            </div> <!-- Groceries ends -->

        </div>

</div>


<script type="text/javascript">


$(document).ready(function(){

        /*$(".modal-wide").on("show.bs.modal", function() {
          var height = $(window).height() - 200;
          $(this).find(".modal-body").css("max-height", height);
        });*/


        // Open modal edit recipe 
        /*$("#btn_edit").on('click', function(){
           showModal('{{ route('recipes.edit',['id' => $recipe->id]) }}','edit');
        });


        // OpeN modal description
        $('#btn_description').on('click',function(){
            showModal('{{ route('recipes.description',['id' => $recipe->id]) }}','description'); 
        });


        // Open modal edit groceries
        $("#btn_groceries").on('click', function(){
            showModal('{{ route("recipes.groceries",["id" => $recipe->id]) }}','m_groceries');
        });


        // Open modal edit photos
        $("#btn_edit_photos").on('click', function(){
            showModal('{{ route('recipes.photos',['id' => $recipe->id]) }}','m_photos');
        });


        // Open modal edit cover photo
        $("#edit_cover").on('click',function(){
            showModal('{{ route('recipes.cover',['id' => $recipe->id]) }}','m_cover');
        });
        */


        // Load photos
        loadDivData('{{ route("recipes.loadphotos",["id" => $recipe->id]) }}',"photos");

        // Load groceries - basket
        loadTableData('{{ route("recipes.basket",["id" => $recipe->id]) }}','groceries_basket');

});


</script>



<script type="text/javascript">

    /* 
    * Save recipe  
    */
     function save(modal_id) {
        //alert($("#public").val());
        var name = $("#name");
        var category = $("#category");
        var persons = $("#persons");
        var public = $("#public:checked").val();
        var form = $("#edit_f");

        //alert(public);

        $.ajax({
            headers: {'X-CSRF-TOKEN' : '{{ csrf_token() }}'},
            type: 'put',
            url: form.attr("action"),
            dataType: 'json',
            data: form.serialize(),

            success: function(response) {

                console.log(response);

                // Form reset
                form[0].reset();

                $("#" + modal_id).modal('hide');

                // Shows the notification
                showNotification('success', 'The recipe succcessfully saved');

                // Setovanje novih podataka
                $("#recipe_name").html('<h5>' + response.recipe.name + '</h5>');
                $("#recipe_categories").html('<i>' + response.categories + '</i>');
                $("#recipe_persons").html('<b>' + response.recipe.persons + '</b>');
                if(response.recipe.public == 1) {
                    $("#recipe_public").html('<b>everyone</b>');
                } else {
                    $("#recipe_public").html('<b>only me</b>');
                }

           },

            error: function(response) {
              
                showValidationErrors(response);
            }  

        });

    }



    // Delete recipe
    function deleteRecipe(url) {

     
        $.ajax({
            headers: {'X-CSRF-TOKEN' : '{{ csrf_token() }}'},
            type: 'delete',
            url: url,
            dataType: 'html',

            success: function(response) {
               
                var url_redirect = '{{URL::to('recipes')}}'; 
                window.location.replace(url_redirect);
            },

            error: function(response) {

                // Prikaz notifikacije
                showNotification('danger', 'The recipe could not be deleted');

                console.log(response);
            }

        });
       
    }

</script>



@endsection
