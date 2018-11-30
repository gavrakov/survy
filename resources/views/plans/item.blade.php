@extends('layouts.app')
@section('content')

<div class="row">
 
    <div class="col-md-12 mb-4">

        <!-- Razmotriti da se ubaci navbar u ovom delu --->
        
        <!--nav class="navbar navbar-item navbar-expand-sm navbar-item">
            
                <img width="25px" src="<?php  $path = 'storage/icons/calendar-icon.png'; echo asset($path); ?>">
                &nbsp;{{$item->date}}
            
               <ul class="navbar-nav ml-auto pull-right">
                  <li class="nav-item active">
                    <a class="nav-link" href="#"><i class="far fa-chart-bar"></i></a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#"><i class="fas fa-chart-line"></i></a>
                  </li>
                </ul>   
        </nav-->

  


        <div class="content-fluid">
            
            <img width="25px" class="mr-2" src="<?php  $path = 'storage/icons/calendar-icon.png'; echo asset($path); ?>">
            
            {{$item->date}}
           
 
            <div class="btn-group inline pull-right btn-survy" role="group">
                <div id="btn_recipes_report" type="button" class="btn btn-light btn-sm"><i class="far fa-chart-bar"></i></div> 
                <div id="btn_groceries_report" type="button" class="btn btn-light btn-sm"><i class="fas fa-chart-line"></i></div> 
                <!--button type="button" class="btn btn-info btn-sm"><i class="fas fa-utensils"></i></button>
                <button type="button" class="btn btn-info btn-sm"><i class="fas fa-apple-alt"></i></button>
                <button type="button" class="btn btn-info btn-sm"><i class="fa fa-coffee" aria-hidden="true"></i></button-->
            </div>
        </div>
      
    </div>
  

    <!-- Card - breakfast -->
    <div class="col-md-2">
        <div class="card text-center mb-3">
            <h6 class="card-header-white">Breakfast</h6>
            <div id="breakfast_container" class="card-body p-3">
            </div>
        </div>
    </div>

    <!-- Card - lunch -->
    <div class="col-md-2">
            <div class="card text-center mb-3">
                <h6 class="card-header-white">Lunch</h6>
                <div id="lunch_container" class="card-body p-3">
                </div>
                <!--div class="card-footer">
                    <button id="btn_lunch" class="btn btn-info btn-sm"><i class="fa fa-edit fa-fw"></i>&nbsp;Add</button>
                </div-->
            </div>
    </div>    

    <!-- Card - Dinner -->
    <div class="col-md-2">
        <div class="card text-center mb-3">
            <h6 class="card-header-white">Dinner</h6>
            <div id="dinner_container" class="card-body p-3">
            </div>
            <!--div class="card-footer">
                <button id="btn_dinner" class="btn btn-info btn-sm"><i class="fa fa-edit fa-fw"></i>&nbsp;Add</button>
            </div-->
        </div>
    </div>

        
    <!-- Groceries -->
    <div class="col-md-6">
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
    <!--div class="col-md-4">
        <div class="card text-left mb-3">
            <h6 class="card-header-white">Activities</h6>
            <div class="card-body">
                    <p>Activities</p>
                    <p id="dinner_p" class="text-justify">  
                        No activities for today...  
                    </p>
                    <table id="activities_basket" class="table table-sm" style="width:50%">
                            <tbody>
                              
                            </tbody>
                    </table>
                    <span id="btn_activities" class="btn btn-light btn-sm"><i class="fa fa-edit fa-fw"></i>&nbsp;Add activities</span>
            </div>
        </div>
    </div-->


</div> <!-- row ends -->



<script type="text/javascript">

    $(document).ready(function(){

        // Load breakfast
        loadDivData("{{ route('plans.items.recipe.show',['plan_id' => $item->plan_id, 'item_id' => $item->id, 'category_id' => 1]) }}",'breakfast_container');


         // Load lunch
        loadDivData("{{ route('plans.items.recipe.show',['plan_id' => $item->plan_id, 'item_id' => $item->id, 'category_id' => 2]) }}",'lunch_container');


        // Load dinner
        loadDivData("{{ route('plans.items.recipe.show',['plan_id' => $item->plan_id, 'item_id' => $item->id, 'category_id' => 3]) }}",'dinner_container');


        // Show recipes report
        $('#btn_recipes_report').on('click', function(){
            showModal("{{ route('plans.items.recipesreport',['plan_id' => $item->plan_id, 'item_id' => $item->id]) }}",'m_recipes_report');
        });


         // Show groceries report
        $('#btn_groceries_report').on('click', function(){
            showModal("{{ route('plans.items.groceriesreport',['plan_id' => $item->plan_id, 'item_id' => $item->id]) }}",'m_groceries_report');
        });

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

            console.log(response);

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