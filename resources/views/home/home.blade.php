@extends('layouts.app')
@section('content')

<?php $breakfast = $data['breakfast'] !== null ? $data['breakfast'] : null; ?>
<?php $lunch = $data['lunch'] !== null ? $data['lunch'] : null; ?>
<?php $dinner = $data['dinner'] !== null ? $data['dinner'] : null; ?>


  <div class="row">

    <!-- Active location -->
    @if (LocationManager::isActive())
        <div class="col-md-4">
         
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


        <!-- Videcemo sta cemo -->
        <div class="col-md-4">
            <div class="card text-center">
                    <h6 class="card-header-white">Test box</h6>
                    <div class="card-body">
                              
                        <p class="card-text text-justify"> 

                              Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. 
                        </p>       
                       
                    </div>
            </div> <!-- card - ends -->

        </div>  <!-- Col-md-4 -->

    </div> <!-- Row ends -->


    @if (PlanManager::isActive() != null)

    <div class="row">


        <!--div class="card-columns  col-lg-12 col-md-12"-->

                <div class="card mr-2" style="width: 10rem;">

                    <h6 class="card-header-white">Breakfast</h6>

                    @if (PlanManager::today()->breakfast()->first() !== null) 

                        <img class="card-img-top" src="<?php
                            $photo = PlanManager::today()->breakfast()->first()->cover()->first();
                            $path = 'storage/photos/recipes/' . $photo['dir'] .  '/' . $photo['name'];
                            echo asset($path);
                        ?>">
                                

                        <div class="card-body">
                            <h5 class="card-title">{{PlanManager::today()->breakfast()->first()->name}}</h5>
                            <p class="card-text">
                                {{number_format((float) PlanManager::today()->breakfast()->first()->getTotalPrice(), 2, '.', '')}}
                                <span class='text-danger'>({{LocationManager::country()->currency}})</span>
                            </p>
                             <span href="#" class="btn-light btn pull-right">Show</span>
                        </div>

                    @else
                        <div class="card-body">
                            <p class="card-text">No breakfast for today</p>
                        </div>
                    @endif


                </div>


                <div class="card mr-2" style="width: 10rem;">

                    <h6 class="card-header-white">Lunch</h6>

                    @if (PlanManager::today()->lunch()->first() !== null) 
       
                        <img class="card-img-top" src="<?php
                            $photo = PlanManager::today()->lunch()->first()->cover()->first();
                            $path = 'storage/photos/recipes/' . $photo['dir'] .  '/' . $photo['name'];
                            echo asset($path);
                        ?>">
                                
 
                        <div class="card-body">
                            <h5 class="card-title">{{PlanManager::today()->lunch()->first()->name}}</h5>
                            <p class="card-text">
                                {{number_format((float) PlanManager::today()->lunch()->first()->getTotalPrice(), 2, '.', '')}}
                                <span class='text-danger'>({{LocationManager::country()->currency}})</span>
                            </p>
                             <a href="#" class="btn-light btn pull-right">Show</a>
                        </div>

                    @else
                        <div class="card-body">
                            <p class="card-text">No lunch for today</p>
                        </div>
                    @endif

                </div>


                <div class="card mr-2" style="width: 10rem;">

                    <h6 class="card-header-white">Dinner</h6>

                    @if (PlanManager::today()->dinner()->first() !== null) 
       
                        <img class="card-img-top" src="<?php
                            $photo = PlanManager::today()->dinner()->first()->cover()->first();
                            $path = 'storage/photos/recipes/' . $photo['dir'] .  '/' . $photo['name'];
                            echo asset($path);
                        ?>">
                                
 
                        <div class="card-body">
                            <h5 class="card-title">{{PlanManager::today()->dinner()->first()->name}}</h5>
                            <p class="card-text">
                                {{number_format((float) PlanManager::today()->dinner()->first()->getTotalPrice(), 2, '.', '')}}
                                <span class='text-danger'>({{LocationManager::country()->currency}})</span>
                            </p>
                             <span href="#" class="btn-light btn pull-right">Show</span>
                        </div>

                    @else
                        <div class="card-body">
                            <p class="card-text">No dinner for today</p>
                        </div>
                    @endif

                </div>

                <div class="col-md-4">
                    <div class="card mr-2">
                        <h6 class="card-header-white">Actvities</h6>
                        <div class="card-body">
                            <p class="card-text">
                                    Kafa u Actorsu
                                    <span class='text-danger'></span>
                            </p>
                            <span href="#" class="btn-light btn pull-right">Show</span>
                        </div>
                    </div>
                    
                </div> 
                <div class="col-md-4">
                    <div class="card mr-2">
                        <h6 class="card-header-white">Groceries</h6>
                        <div class="card-body">
                            <p class="card-text">
                                    Hleb
                                    <span class='text-danger'></span>
                            </p>
                            <span href="#" class="btn-light btn pull-right">Show</span>
                        </div>
                    </div>
                    
                </div>     

        <!--/div--> <!-- Card columns ends -->
 

    </div> <!-- Row ends -->


    @endif <!-- Plan::isActive() ends -->


        <!--div class="row">
          
                <h4>Groceries</h4>
                <hr>
                <div class="row">
                </div>    


              
                <h4>Actvities</h4>
                <hr>
                <div class="row">
                </div> 

        </div-->


   

@endsection
