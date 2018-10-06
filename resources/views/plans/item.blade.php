@extends('layouts.app')
@section('content')

<div class="row">

 
    <div class="col-md-12 mb-3">
        <!--div class="well" -->
            <h6>
                <img width="30px" src="<?php  $path = 'storage/icons/calendar-icon.png'; echo asset($path); ?>">
                {{$item->date}}
            </h6>
        <!--/div-->
    
    <!--hr-->

    </div>
  

    <div class="col-md-4">    
        <div class="card text-left mb-3">
            <h6 class="card-header-white">Meals</h6>
            <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        <li id="breakfast_row" class="list-group-item">
                            <p>Breakfast</p>

                            <!-- Load breakfast -->
                            <div id="breakfast_container" class="row recipe-row"></div> 
                                
                            <div class="row recipe-row">
                                    <button id="btn_breakfast" class="btn btn-light btn-sm m-3"><i class="fa fa-edit fa-fw"></i>&nbsp;Add</button>
                            </div>
                        
                        </li>
                        <li id="lunch_row" class="list-group-item">
                            <p>Lunch</p>

                            <!-- Load lunch -->
                            <div id="lunch_container" class="row recipe-row"></div> 

                            <div class="row recipe-row">        
                                <button id="btn_lunch" class="btn btn-light btn-sm m-3"><i class="fa fa-edit fa-fw"></i>&nbsp;Add</button>
                            </div>

                        </li>
                        <li id="dinner_row" class="list-group-item">
                            <p>Dinner</p>

                            <!-- Dinner lunch -->
                            <div id="dinner_container" class="row recipe-row"></div> 
                            
                            <div class="row recipe-row"> 
                                 <button id="btn_dinner" class="btn btn-light btn-sm m-3"><i class="fa fa-edit fa-fw"></i>&nbsp;Add</button>
                            </div>
                        </li>
                        <li id="meals-total" class="list-group-item">
                            Total:
                        </li>
                    </ul>
   
            </div> <!-- Card body - ends -->
        </div> <!-- Card - ends -->
    </div>


    <!-- Groceries -->
    <div class="col-md-4">
        <div class="card text-left mb-3">
            <h6 class="card-header-white">Groceries</h6>
            <div class="card-body">
                <p>Groceries</p>
                <p id="dinner_p" class="text-justify">  
                    No groceries for today...  
                </p>
                <table id="groceries_basket" class="table table-sm" style="width:50%">
                        <tbody>
                            <!-- Load basket - Ajax -->
                        </tbody>
                </table>
                <span id="btn_groceries" class="btn btn-light btn-sm"><i class="fa fa-edit fa-fw"></i>&nbsp;Add groceries</span>
            </div>
        </div>
    </div>
    

    <!-- Activities -->
    <div class="col-md-4">
        <div class="card text-left mb-3">
            <h6 class="card-header-white">Activities</h6>
            <div class="card-body">
                    <p>Activities</p>
                    <p id="dinner_p" class="text-justify">  
                        No activities for today...  
                    </p>
                    <table id="activities_basket" class="table table-sm" style="width:50%">
                            <tbody>
                                <!-- Load basket - Ajax -->
                            </tbody>
                    </table>
                    <span id="btn_activities" class="btn btn-light btn-sm"><i class="fa fa-edit fa-fw"></i>&nbsp;Add activities</span>
            </div>
        </div>
    </div>

</div> <!-- row ends -->


<script type="text/javascript">

    $(document).ready(function(){

        // Add/edit breakfast
        $('#btn_breakfast').on('click', function(){
            showModal("{{ route('plans.items.recipe',['plan_id' => $item->plan_id, 'item_id' => $item->id, 'category_id' => 1]) }}",'m_recipes');
        });

        // Load breakfast
        loadDivData("{{ route('plans.items.recipe.show',['plan_id' => $item->plan_id, 'item_id' => $item->id, 'category_id' => 1]) }}",'breakfast_container');


         // Add/edit lunch
        $('#btn_lunch').on('click', function(){
            showModal("{{ route('plans.items.recipe',['plan_id' => $item->plan_id, 'item_id' => $item->id, 'category_id' => 2]) }}",'m_recipes');
        });

         // Load lunch
        loadDivData("{{ route('plans.items.recipe.show',['plan_id' => $item->plan_id, 'item_id' => $item->id, 'category_id' => 2]) }}",'lunch_container');


        // Add/edit dinner
        $('#btn_dinner').on('click', function(){
            showModal("{{ route('plans.items.recipe',['plan_id' => $item->plan_id, 'item_id' => $item->id, 'category_id' => 3]) }}",'m_recipes');
        });


        // Load dinner
        loadDivData("{{ route('plans.items.recipe.show',['plan_id' => $item->plan_id, 'item_id' => $item->id, 'category_id' => 3]) }}",'dinner_container');

    });



</script>



<script type="text/javascript">
    

// Add recipe to the item   
function insertRecipe(recipe_id,item_id,category_id,adresa) {

    var form = $("#f_add_recipe");
    $("#f_recipe").val(recipe_id); // setovanje forme za recept id

    $.ajax({
    headers: {'X-CSRF-TOKEN' : '{{ csrf_token() }}'},
    type: 'post',
    url: adresa, 
    dataType: 'json',
    data: form.serialize(),

        success: function(response) {

            form[0].reset();
            $("#m_recipes").modal('hide');

            if(category_id == 1) {
                loadDivData("{{ route('plans.items.recipe.show',['plan_id' => $item->plan_id, 'item_id' => $item->id, 'category_id' => 1]) }}",'breakfast_container');
            } else if (category_id == 2) {
                loadDivData("{{ route('plans.items.recipe.show',['plan_id' => $item->plan_id, 'item_id' => $item->id, 'category_id' => 2]) }}",'lunch_container');
            } else if (category_id == 3) {
                loadDivData("{{ route('plans.items.recipe.show',['plan_id' => $item->plan_id, 'item_id' => $item->id, 'category_id' => 3]) }}",'dinner_container');
            }
            ;
        },
        error: function(response) {

            // Prikaz gresaka
            var data = response.responseJSON;

            console.log(response);
        }

    });
}


// Remove recipe from plan item  
function deleteRecipe(item_id,category_id,adresa) {

   // var adresa = item_id+'/recipe/category/' + category_id + '/destroy';

    $.ajax({
    headers: {'X-CSRF-TOKEN' : '{{ csrf_token() }}'},
    type: 'get',
    url: adresa, 
    dataType: 'json',
    //data: form.serialize(),

        success: function(response) {

            if(category_id == 1) {
                loadDivData("{{ route('plans.items.recipe.show',['plan_id' => $item->plan_id, 'item_id' => $item->id, 'category_id' => 1]) }}",'breakfast_container');
            } else if (category_id == 2) {
                loadDivData("{{ route('plans.items.recipe.show',['plan_id' => $item->plan_id, 'item_id' => $item->id, 'category_id' => 2]) }}",'lunch_container');
            } else if (category_id == 3) {
                loadDivData("{{ route('plans.items.recipe.show',['plan_id' => $item->plan_id, 'item_id' => $item->id, 'category_id' => 3]) }}",'dinner_container');
            }
            

            console.log(response);
        },
        error: function(response) {

            // Prikaz gresaka
            var data = response.responseJSON;

            console.log(response);
        }

    });
}


</script>

@endsection