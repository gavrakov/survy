@extends('layouts.app')
@section('content')

<?php $breakfast = $data['breakfast'] !== null ? $data['breakfast'] : null; ?>
<?php $lunch = $data['lunch'] !== null ? $data['lunch'] : null; ?>
<?php $dinner = $data['dinner'] !== null ? $data['dinner'] : null; ?>


  <div class="row">

    <!-- Active location -->
    @if (LocationManager::isActive())
        <div class="col-lg-4">
         
            <div class="panel panel-info">
                <div class="panel-heading">
                    <!--i class="glyphicon glyphicon-ok-circle"></i--> <p>Active location</p>
                </div>
                <div class="panel-body">
                    <div class="row">
                  
                        <!--div class="col-md-1">
                            <img width="20px" src="<?php  
                                $path = 'storage/icons/earth.png';
                                echo asset($path);

                            ?>">
                        </div-->
                           
                          
                        <div class="col-md-4">
                            <h4><img id="plan-icon" name="plan-icon" src="{{ asset('storage/icons/earth.png') }}">&nbsp;</h4> 
                        </div>

                        <div class="col-md-4">
                            <h4>{{LocationManager::country()->country_name}}</h4>
                            <p>Currency: <em class="text-danger">{{LocationManager::country()->currency}}</em></p>
                        </div> 

        
                        <div class="col-md-4">
                             <span id="btn_edit" class="btn btn-default btn-sm pull-right"  onClick="window.location.replace('{{route('plans.show',['id' => PlanManager::getActive()->id])}}');"><i class="fa fa-edit fa-fw"></i>&nbsp;edit</span>
                        </div>
                        
                 
                    </div>
                </div>
            </div> <!-- panel-info - ends -->

        </div>
    @endif


    <!-- Active plan -->
    @if (PlanManager::isActive())
        <div class="col-lg-8">
         
            <div class="panel panel-info">
                <div class="panel-heading">
                    <!--i class="glyphicon glyphicon-ok-circle"></i--> <p>Active plan</p>
                </div>
                <div class="panel-body">
                    <div class="row">
                  
                        <!--div class="col-md-1">
                            <img width="20px" src="<?php  
                                $path = 'storage/icons/calendar-icon.png';
                                echo asset($path);

                            ?>">
                        </div-->
                           
                          
                        <div class="col-md-4">
                            <h4><img id="plan-icon" name="plan-icon" src="{{ asset('storage/icons/plan-icon32.png') }}"> </h4>
                            
                        </div>

                        <div class="col-md-4">
                                <h4>{{PlanManager::getActive()->name}}</h4>
                                <em>{{PlanManager::getActive()->dateFrom()}} - {{PlanManager::getActive()->dateTo()}}</em> 
                        </div> 

        
                        <div class="col-md-4">
                             <span id="btn_edit" class="btn btn-default btn-sm pull-right"  onClick="window.location.replace('{{route('plans.show',['id' => PlanManager::getActive()->id])}}');"><i class="fa fa-edit fa-fw"></i>&nbsp;edit</span>
                        </div>
                        
                 
                    </div>
                </div>
            </div> <!-- panel-info - ends -->

        </div>
    @endif

    </div>




        <div class="panel panel-default" class="col-md-12">

            <div class="panel-heading">
                    <!--i class="glyphicon glyphicon-ok-circle"></i--> <p>Today</p>
            </div>

            <div class="panel-body">

                <h4>Recipes</h4>
                <hr>

                <div class="row">

                    <!-- Breakfast -->
                    <div id="breakfast" class="col-md-4">
                        <!--i class="glyphicon glyphicon-cutlery"></i>&nbsp;<em>Breakfast</em-->
                        <!---div class="panel panel-info">
                            <div class="panel-heading">
                                <i class="glyphicon glyphicon-cutlery">&nbsp;Breakfast</i>
                            </div>
                            <div class="panel-body">
                                @if($breakfast != null)

                                    <div class="col-md-2">
                                        <img width="50px" src="<?php 

                                      
                                        $photo = $breakfast->cover()->first();
                                        $path = 'storage/photos/recipes/' . $photo['dir'] .  '/thumbs/150_' . $photo['name'];
                                        echo asset($path);
                                        
                                        ?>" style="position:relative; border-radius:3%; border:1px">
                                    </div>
                                    <div class="col-md-8">
                                        <p>{{$breakfast->name}}</p>

                                       
                                       
                                            <small>
                                                {{number_format((float)$breakfast->getTotalPrice(), 2, '.', '')}}
                                                <span class='text-danger'>({{LocationManager::country()->currency}})</span>
                                            </small>
                                        
                                    </div>

                                    <div class="col-md-2"><button class="btn btn-default btn-sm pull-right">Show recipe</button></div>
                                @else
                                    <em>No breakfast for today</em>
                                @endif

                                
                            </div>
                  
                        </div-->
                        
                        <!--div class="recipe-card-large">
                                    <img src="<?php 
                                                // Vraca collection of object
                                                $photo = PlanManager::today()->breakfast()->first()->cover()->first();
                                                $path = 'storage/photos/recipes/' . $photo['dir'] .  '/thumbs/150_' . $photo['name'];
                                                echo asset($path); ?>

                                        " alt="Avatar">
                                    
                                    <span>
                                        {{PlanManager::today()->breakfast()->first()->name}} -
                                        <small>
                                            {{number_format((float) PlanManager::today()->breakfast()->first()->getTotalPrice(), 2, '.', '')}}
                                            <span class='text-danger'>({{LocationManager::country()->currency}})</span>
                                        </small>
                                    </span>
                                </div>
                        </div-->

                        <!--div class="card" style="height:150px;">
                            <img class="card-img-top" src="<?php
                                $photo = PlanManager::today()->breakfast()->first()->cover()->first();
                                $path = 'storage/photos/recipes/' . $photo['dir'] .  '/thumbs/150_' . $photo['name'];
                                echo asset($path);
                          ?>" alt="Card image" style="height:150px;">  

                            <div class="card-body">
                                <h4 class="card-title">{{PlanManager::today()->breakfast()->first()->name}}</h4>
                                <p class="card-text">
                                    {{number_format((float) PlanManager::today()->breakfast()->first()->getTotalPrice(), 2, '.', '')}}
                                    <span class='text-danger'>({{LocationManager::country()->currency}})</span>
                                </p>
                                <span class="btn btn-info">Show</span>
                            </div>       
                        </div-->

                        <!--div class="card" style="width:400px">
                          <img class="card-img-top" src="<?php
                                $photo = PlanManager::today()->breakfast()->first()->cover()->first();
                                $path = 'storage/photos/recipes/' . $photo['dir'] .  '/thumbs/300_' . $photo['name'];
                                echo asset($path);
                          ?>" alt="Card image" style="width:100%">
                          <div class="card-body">
                            <h4 class="card-title">{{PlanManager::today()->breakfast()->first()->name}}</h4>
                            <p class="card-text">
                                {{number_format((float) PlanManager::today()->breakfast()->first()->getTotalPrice(), 2, '.', '')}}
                                <span class='text-danger'>({{LocationManager::country()->currency}})</span>
                            </p>
                            <a href="#" class="btn btn-info">Show</a>
                          </div>
                        </div-->

                        <!--div class="card">
                              <img src="<?php
                                $photo = PlanManager::today()->breakfast()->first()->cover()->first();
                                $path = 'storage/photos/recipes/' . $photo['dir'] .  '/thumbs/300_' . $photo['name'];
                                echo asset($path);

                              ?>" alt="Avatar">
                              <div class="container">
                                <h4><b>{{PlanManager::today()->breakfast()->first()->name}}</b></h4> 
                                <p>
                                    {{number_format((float) PlanManager::today()->breakfast()->first()->getTotalPrice(), 2, '.', '')}}
                                    <span class='text-danger'>({{LocationManager::country()->currency}})</span>
                                </p> 
                                
                              </div>
                        </div-->


                        <!-- Breakfast -->
                        <div class="card">
                            
                            <div class="card-header bg-info">Breakfast</div>
                            
                                 
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
   

                        </div>

                    </div>



                    <!-- Lunch -->

                    <div id="lunch" class="col-md-4">
                        <div class="card">
                            
                            <div class="card-header bg-success">Lunch</div>
                            
                                 
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


                        </div>

                    </div>



                     <!-- Dinner -->

                    <div id="lunch" class="col-md-4">
                        <div class="card">
                            
                            <div class="card-header bg-warning">Lunch</div>
                            
                                 
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


                        </div>

                    </div>

                        


                       
                    </div>

                 
                    <!--div id="lunch" class="col-lg-4">
                        <i class="glyphicon glyphicon-cutlery"></i>&nbsp;<em>Lunch</em><hr>
                        <div class="panel panel-success">
                            <div class="panel-heading">
                                <i class="glyphicon glyphicon-cutlery">&nbsp;Lunch</i>
                            </div>
                            <div class="panel-body">
                                @if($lunch != null)

                                    <div class="col-md-2">
                                        <img width="50px" src="<?php 

                                        // Vraca collection of object
                                        $photo = $lunch->cover()->first();
                                        $path = 'storage/photos/recipes/' . $photo['dir'] .  '/thumbs/150_' . $photo['name'];
                                        echo asset($path);
                                        
                                        ?>" style="position:relative; border-radius:3%; border:1px">
                                    </div>
                                    <div class="col-md-8">
                                        <p>{{$lunch->name}}</p>

                                        
                                        
                                            <small>Price: {{number_format((float)$lunch->getTotalPrice(), 2, '.', '')}}
                                                <span class='text-danger'>({{LocationManager::country()->currency}})</span>
                                            </small>
                                        
                                    </div>
                                    <div class="col-md-2"><button class="btn btn-default btn-sm pull-right">Show recipe</button></div>
                                   
                                @else
                                    <em>No lunch for today</em>
                                @endif

                               
                            </div>

                        </div>
                    </div>


                
                    <div id="dinner" class="col-lg-4">

                        <i class="glyphicon glyphicon-cutlery"></i>&nbsp;<em>Dinner</em><hr>
                        <div class="panel panel-warning">
                            <div class="panel-heading">
                                <i class="glyphicon glyphicon-cutlery">&nbsp;Dinner</i>
                            </div>
                            <div class="panel-body">
                                @if($dinner != null)
                                    <div class="col-md-2">
                                        <img width="50px" src="<?php 

                                        // Vraca collection of object
                                        $photo = $dinner->cover()->first();
                                        $path = 'storage/photos/recipes/' . $photo['dir'] .  '/thumbs/150_' . $photo['name'];
                                        echo asset($path);
                                        
                                        ?>" style="position:relative; border-radius:3%; border:1px">
                                    </div>
                                    <div class="col-md-8">
                                        <p>{{$dinner->name}}</p>

                                      
                                       
                                            <small>
                                                {{number_format((float)$dinner->getTotalPrice(), 2, '.', '')}}
                                                <span class='text-danger'>({{LocationManager::country()->currency}})</span>
                                            </small>
                                       
                                    </div>

                                    <div class="col-md-2"><button class="btn btn-default btn-sm pull-right">Show recipe</button></div>
                                    
                                   
                                @else
                                    <em>No dinner for today</em>
                                @endif

                            </div>
                            
                        </div>
                    </div-->
                  
      

                </div> <!-- Row ends -->


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

            </div> <!-- Panel body ends -->

        


   

@endsection
