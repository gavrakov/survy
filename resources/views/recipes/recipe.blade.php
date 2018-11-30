@extends('layouts.app')
@section('content')

<div class="row">
    <div class="col-md-4">
        <div class="card mb-3">
            <!--div class="panel-heading"><p class="glyphicon glyphicon-book">&nbsp;{{$recipe->name}}</p></div-->
                <div class="card-body">

                    <div class="d-flex">

                        <div>
                       
                             <img class="mr-4" style="position:relative; width:60px;  border-radius:100%; padding: 2px; border:1px #888888 solid"
                            src="{{asset($recipe->cover_link_sm())}}"
                          
                            style="position:relative; border-radius:3%; border:1px">
                        </div>
                      
                        <div>

                            <span id="recipe_name"><h5>{{$recipe->name}}</h5></span>
                       
                            <p id="recipe_categories" class="d-inline-block">
                                <i>

                                <?php $counter = 0; ?>
                                @foreach($recipe->categories()->get() as $category)

                                    <?php if($counter != 0) { echo",";}?>

                                    {{$category['name']}}

                                    <?php $counter ++; ?>
                                @endforeach
                            

                                </i>
                            </p>
                       
                            <p>
                                <span class="d-inline-block">Number of persons:</span> 
                                <span id="recipe_persons" class="d-inline-block"><b>{{$recipe->persons}}</b></span>
                            </p>     
                                
                        </div>

                    </div>

                    <button id="btn_edit" class="btn btn-light btn-sm" data-toggle="modal" data-target="#myModal" data-path="{{route('recipes.edit',['id'=>$recipe->id])}}"><i class="fa fa-edit fa-fw"></i>&nbsp;Edit details</button>
            </div>

        </div>
                

        <!-- Groceries -->	
        <div class="card mb-3">
            <div class="card-body p-0">
               <h6 class="card-title p-3">Groceries</h6>

                <table id="groceries_basket" class="table">
                    <tbody>
                        <!-- Load basket - Ajax -->
                    </tbody>
                </table>
               
                <button id="btn_groceries" class="btn btn-light btn-sm m-3"><i class="fa fa-edit fa-fw"></i>&nbsp;Add groceries</button>

            </div>
            
        </div>

 
    </div> <!-- col-md-4 ends -->


<!-- Description -->
<div class="col-md-4">
    <div class="card mb-3">
        <div class="card-body">
            <h6 class="card-title">Description</h6>
            <p id="description_p" class="text-justify">
                @if ($recipe->description == '') 
                    <i>Describe every step in making this recipe...</i>
                @else
                    {{$recipe->description}}
                @endif
            </p>
            <button id="btn_description" class="btn btn-light btn-sm" data-toggle="modal" data-target="#myModal" data-path="{{route('recipes.description',['id'=>$recipe->id])}}"><i class="fa fa-edit fa-fw"></i>&nbsp;
                @if ($recipe->description == '')  Add description
                  @else
                    Edit description
                @endif
            </button>

        </div>
    </div>
</div>

 <!-- Photos -->
<div class="col-md-4">

    <div class="card mb-3">
        <div class="card-body">
            <h6 class="card-title">Photos</h6>

            <!--div id="photos_row" name="photos_row" class="row"-->
            <div id="photos"></div>  
            <button id="btn_edit_photos" class="btn btn-light btn-sm" data-toggle="modal" data-target="#myModal"><i class="fa fa-edit fa-fw"></i>&nbsp;Edit photos
            </button> 
            <!--/div-->
        </div>
        
    </div>
    
</div>
                
       

</div>



<script type="text/javascript">


$(document).ready(function(){

        $(".modal-wide").on("show.bs.modal", function() {
          var height = $(window).height() - 200;
          $(this).find(".modal-body").css("max-height", height);
        });


        // Open modal edit recipe 
        $("#btn_edit").on('click', function(){
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
  
        var name = $("#name");
        var category = $("#category");
        var persons = $("#persons");
        var form = $("#edit_f");

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

           },

            error: function(response) {
              
                showValidationErrors(response);
            }  

        });

    }

</script>



@endsection
