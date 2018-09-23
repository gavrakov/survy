@extends('layouts.app')
@section('content')

<?php $breakfast = $data['breakfast'] !== null ? $data['breakfast'] : null; ?>
<?php $lunch = $data['lunch'] !== null ? $data['lunch'] : null; ?>
<?php $dinner = $data['dinner'] !== null ? $data['dinner'] : null; ?>


  <div class="row">

    <!-- Active location -->
    @if (LocationManager::isActive())
        <div class="col-lg-4">
         
            <div class="card text-center">
                <h6 class="card-header-white">Active location</h6>
                    <!--i class="glyphicon glyphicon-ok-circle"></i--> 
                
                <div class="card-body">
                    <!--h6 class="card-title">Active location</h6-->
                    <!--h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6-->
                    <p class="card-text">
                        <img width="32px" src="<?php  
                                $path = 'storage/icons/earth.png';
                                echo asset($path);

                            ?>">
                    </p>
                    <p class="card-text">{{LocationManager::country()->country_name}}</p>
                    <button id="btn_edit" class="btn btn-light btn-sm"  onClick="window.location.replace('{{route('locations')}}');"><i class="far fa-edit"></i>&nbsp;Edit</button>
                </div>
               
               
            </div> <!-- card - ends -->

        </div>
    @endif


    <!-- Active plan -->
    

        <div class="col-md-4">
            <div class="card text-center">
                    <h6 class="card-header-white">Active plan</h6>
                    <div class="card-body">
                        <!--h6 class="card-title">Active plan</h6-->
         
                                <p class="card-text">
                                    <img id="plan-icon" name="plan-icon" src="{{ asset('storage/icons/plan-icon32.png') }}">
                                </p>
                                <p class="card-text"> 

                                    @if (PlanManager::isActive() != null)
                                        <b>{{PlanManager::getActive()->name}}</b><br>
                                        <small>{{PlanManager::getActive()->dateFrom()}} - {{PlanManager::getActive()->dateTo()}}</small>
                                    @else
                                        <p>No plan selected</p>

                                    @endif

                                </p>
                                
                                @if (PlanManager::isActive() != null)
                                    <button id="btn_edit" class="btn btn-light btn-sm"  onClick="window.location.replace('{{route('plans.show',['id' => PlanManager::getActive()->id])}}');"><i class="far fa-edit"></i>&nbsp;Edit</button>
                                @endif
                       
                    </div>
            </div> <!-- card - ends -->

        </div>  <!-- Col-md-4 -->

    </div> <!-- Row ends -->

    
    @if (PlanManager::isActive() != null)
  
        <!--h5>Today</h5>

            <div class="card-body">

                <div class="row">

     
                    <div id="breakfast" class="col-md-4">
            
                   
                        <div class="card">
                            
                            <div class="card-header bg-info">Breakfast</div>
                            
                            @if (PlanManager::today()->breakfast()->first() !== null)     
                            <img class="card-image" src="<?php
                                $photo = PlanManager::today()->breakfast()->first()->cover()->first();
                                $path = 'storage/photos/recipes/' . $photo['dir'] .  '/' . $photo['name'];
                                echo asset($path);
                            ?>">
                                    
                                    
                                 
                            <div class="card-body">
                                <h4><i>{{PlanManager::today()->breakfast()->first()->name}}</i> </h4>
                                     <small>
                                        {{number_format((float) PlanManager::today()->breakfast()->first()->getTotalPrice(), 2, '.', '')}}
                                        <span class='text-danger'>({{LocationManager::country()->currency}})</span>
                                    </small>
                               
                               
                                
                            </div>

                            <div class="card-footer bg-info">
                                <span href="#" class="btn-default btn pull-right">Show</span>
                                
                            </div>

                            @else
                                <p>No breakfast for today</p>
                            @endif
   

                        </div>

                    </div>



               

                    <div id="lunch" class="col-md-4">
                        <div class="card">
                            
                            <div class="card-header bg-success">Lunch</div>
                            
                            @if (PlanManager::today()->lunch()->first() !== null)     
                            <img class="card-image" src="<?php
                                $photo = PlanManager::today()->lunch()->first()->cover()->first();
                                $path = 'storage/photos/recipes/' . $photo['dir'] .  '/' . $photo['name'];
                                echo asset($path);
                            ?>">
                                    
                                    
                                 
                            <div class="card-body">
                                <h4><i>{{PlanManager::today()->lunch()->first()->name}}</i> </h4>
                                     <small>
                                        {{number_format((float) PlanManager::today()->lunch()->first()->getTotalPrice(), 2, '.', '')}}
                                        <span class='text-danger'>({{LocationManager::country()->currency}})</span>
                                    </small>
                               
                               
                                
                            </div>

                            <div class="card-footer bg-success">
                                <span href="#" class="btn-default btn pull-right">Show</span>
                                
                            </div>

                            @else
                                <p>No lunch for today</p>
                            @endif


                        </div>

                    </div>




                    <div id="lunch" class="col-md-4">
                        <div class="card">
                            
                            <div class="card-header bg-warning">Dinner</div>
                            
                            @if (PlanManager::today()->dinner()->first())     
                            <img class="card-image" src="<?php
                                $photo = PlanManager::today()->dinner()->first()->cover()->first();
                                $path = 'storage/photos/recipes/' . $photo['dir'] .  '/' . $photo['name'];
                                echo asset($path);
                            ?>">
                                    
                                    
                                 
                            <div class="card-body">
                                <h4><i>{{PlanManager::today()->dinner()->first()->name}}</i> </h4>
                                     <small>
                                        {{number_format((float) PlanManager::today()->dinner()->first()->getTotalPrice(), 2, '.', '')}}
                                        <span class='text-danger'>({{LocationManager::country()->currency}})</span>
                                    </small>
                               
                               
                                
                            </div>

                            <div class="card-footer bg-warning">
                                <span href="#" class="btn-default btn pull-right">Show</span>
                                
                            </div>

                            @else
                                <p>No lunch for today</p>
                            @endif


                        </div>

                    </div>


      

                </div> 


        @endif <!-- Plan::isActive() ends -->


        <div class="row">
                <!-- Groceries -->
                <h4>Groceries</h4>
                <hr>
                <div class="row">
                </div>    


                 <!-- Activities -->
                <h4>Actvities</h4>
                <hr>
                <div class="row">
                </div> 

        </div>

</div> <!-- Panel body ends -->


   

@endsection
