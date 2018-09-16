@extends('layouts.app')
@section('content')

<div class="row">
    <div class="col-md-8">
        <div class="panel panel-default">
            <div class="panel-heading"><p class="glyphicon glyphicon-book">&nbsp;{{$recipe->name}}</p></div>
            <div class="panel-body">
                <div id="alert" class="alert alert-success hide">
                        
                </div>
                	

                <div name="data" class="col-md-12">

                    <!-- Recipe data --> <!-- Ovaj deo cu morati da sredim -->
                    <div id="recipe_data" class="row"> 
                        
                        <h4>Recipe data</h4>  
                  
                        <p>
                            <span class="d-inline-block">Name:</span> 
                            <span id="recipe_name" class="d-inline-block"><b>{{$recipe->name}}</b></span>
                        </p>
                        <p>
                            <span class="d-inline-block">Categories:</span> 
                            <span id="recipe_categories" class="d-inline-block"><b>

                                <?php $counter = 0; ?>
                                @foreach($recipe->categories()->get() as $category)

                                    <?php if($counter != 0) { echo",";}?>

                                    {{$category['name']}}

                                    <?php $counter ++; ?>
                                @endforeach
                            


                            </b></span>
                        </p>
                        <p>
                            <span class="d-inline-block">Number of persons:</span> 
                            <span id="recipe_persons" class="d-inline-block"><b>{{$recipe->persons}}</b></span>
                        </p>

                        <button id="btn_edit" class="btn btn-default btn-sm" data-toggle="modal" data-target="#myModal" data-path="{{route('recipes.edit',['id'=>$recipe->id])}}"><i class="fa fa-edit fa-fw"></i>&nbsp;Edit recipe</button>
                        
                    </div>

                    <hr>

                    <!-- Groceries -->
                    <div id="groceries_row" class="row">
                        <h4>Groceries</h4>
                        
                        <table id="groceries_basket" class="table table-sm" style="width:50%">
                                <tbody>
                                    <!-- Load basket - Ajax -->
                                </tbody>
                        </table>
                       
                       
                        <span id="btn_groceries" class="btn btn-default btn-sm"><i class="fa fa-edit fa-fw"></i>&nbsp;Add groceries</span>
                    </div>

                    <hr>

                    <!-- Description -->
                    <div id="description_row" class="row">
                        <h4>Description</h4>
                        <p id="description_p" class="text-justify">

                            @if ($recipe->description == '') 
                                <i>Describe every step in making this recipe...</i>
                            @else
                                {{$recipe->description}}
                            @endif
                        </p>
                        <button id="btn_description" class="btn btn-default btn-sm" data-toggle="modal" data-target="#myModal" data-path="{{route('recipes.description',['id'=>$recipe->id])}}"><i class="fa fa-edit fa-fw"></i>&nbsp;
                            @if ($recipe->description == '')  Add description
                              @else
                                Edit description
                            @endif
                        </button>
                    </div>

                    <hr>


                    <!-- Photos -->
                    <div id="photos_row" name="photos_row" class="row">
                        <div id="photos">
                        </div>  
                        <button id="btn_edit_photos" class="btn btn-default btn-sm" data-toggle="modal" data-target="#myModal"><i class="fa fa-edit fa-fw"></i>&nbsp;Edit photos</button> 
                    </div>

                </div> 
                    
                   
                </div>
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
            showModal('{{ route('recipes.modalgroceries',['id' => $recipe->id]) }}','m_groceries');
        });


        // Open modal edit photos
        $("#btn_edit_photos").on('click', function(){
            showModal('{{ route('recipes.modalphotos',['id' => $recipe->id]) }}','m_photos');
        });
    

        // Load photos
        loadDivData('{{ route("recipes.loadphotos",["id" => $recipe->id]) }}',"photos");

        // Load groceries - basket
        loadTableData('{{ route("recipes.basketload",["id" => $recipe->id]) }}','groceries_basket');

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
                $("#recipe_name").html('<b>' + response.recipe.name + '</b>');
                $("#recipe_categories").html('<b>' + response.categories + '</b>');
                $("#recipe_persons").html('<b>' + response.recipe.persons + '</b>');

           },

            error: function(response) {
              
                showValidationErrors(response);
            }  

        });

    }

</script>



@endsection
