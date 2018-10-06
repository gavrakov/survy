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
  

    <div class="col-md-12">    
        <div class="card text-left mb-3">
            <h6 class="card-header-white">Meals</h6>
            <div class="card-body p-0">

                <div name="data" class="col-md-12">

                    <!-- Breakfast -->
                    <div id="breakfast_row" class="row">
                        
                        <div class="col-md-12">
                            <p>Breakfast</p>

                            <!-- Load breakfast -->
                            <div id="breakfast_container" class="row recipe-row"></div> 
                                
                            <div class="row recipe-row">
                                    <button id="btn_breakfast" class="btn btn-default btn-sm"><i class="fa fa-edit fa-fw"></i>&nbsp;Add breakfast</button>
                            </div>
                        </div>
                        
                    </div>

                    <hr>

                    <!-- Lunch -->
                    <div id="lunch_row" class="row">
                        <div class="col-md-12">
                            <p>Lunch</p>
                                <!-- Load lunch -->
                                <div id="lunch_container" class="row recipe-row"></div> 

                            <div class="row recipe-row">        
                                <button id="btn_lunch" class="btn btn-default btn-sm"><i class="fa fa-edit fa-fw"></i>&nbsp;Add lunch</button>
                            </div>
                        </div>
                    </div>

                    <hr>


                    <!-- Lunch -->
                    <div id="dinner_row" class="row">
                        <div class="col-md-12">
                            <p>Dinner</p>

                            <!-- Dinner lunch -->
                            <div id="dinner_container" class="row recipe-row"></div> 
                            
                            <div class="row recipe-row"> 
                                 <button id="btn_dinner" class="btn btn-default btn-sm"><i class="fa fa-edit fa-fw"></i>&nbsp;Add dinner</button>
                            </div>
                        </div>
                    </div>


                </div> <!-- Data div - ends -->
                    
            </div> <!-- Card body - ends -->
        </div> <!-- Card - ends -->
    </div>


    <!-- Groceries -->
    <div class="col-md-12">
        <div class="card text-left mb-3">
            <h6 class="card-header-white">Groceries</h6>
            <div class="card-body">
           
                <div name="data" class="col-md-12">
                    <!-- Breakfast -->
                    <div id="groceries_row" class="row">
                        <p>Groceries</p>

                        <p id="dinner_p" class="text-justify">  
                            No groceries for today...  
                        </p>
                        
                        <table id="groceries_basket" class="table table-sm" style="width:50%">
                                <tbody>
                                    <!-- Load basket - Ajax -->
                                </tbody>
                        </table>
                       
                       
                        <span id="btn_groceries" class="btn btn-default btn-sm"><i class="fa fa-edit fa-fw"></i>&nbsp;Add groceries</span>
                    </div>  
               
            </div>
        </div>
    </div>
    

    <!-- Activities -->
    <div class="col-md-8">
        <div class="panel panel-default">
            <div class="panel-heading"><p class="glyphicon glyphicon-glass"> Activities</p></div>
            <div class="panel-body">
           
   
                <div name="data" class="col-md-12">

                    <!-- Breakfast -->
                    <div id="activities_row" class="row">
                        <h4>Activities</h4>

                        <p id="dinner_p" class="text-justify">  
                            No activities for today...  
                        </p>
                        
                        <table id="activities_basket" class="table table-sm" style="width:50%">
                                <tbody>
                                    <!-- Load basket - Ajax -->
                                </tbody>
                        </table>
                       
                       
                        <span id="btn_activities" class="btn btn-default btn-sm"><i class="fa fa-edit fa-fw"></i>&nbsp;Add activities</span>
                    </div>  

                </div>    
               
            </div>
        </div>
    </div>


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

    /*complete : function(){
        alert(this.url)
    },*/

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