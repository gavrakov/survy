  @if (isset($items))
    	@foreach ($items as $item)

        <div id="{{$item->id}}" class="row">


            <!-- Recipe name and dates -->
            <div id="date" class="col-md-3">
                <h4><img width=20x" src="<?php  $path = 'storage/icons/calendar-icon.png'; echo asset($path); ?>">&nbsp;{{$item->date}}</h4>
            </div>

            <!-- Recipes -->
            <div id="recipes_list" class="col-md-3">
                    
                        <h5><i class="glyphicon glyphicon-cutlery"> Meals</i></h5>
                    
                        @if ($item->breakfast != null)
                            <span class="label label-info">{{$item->breakfast()->first()->name}}</span>
                        @endif
                        @if ($item->lunch != null)
                            <span class="label label-success">{{$item->lunch()->first()->name}}</span>
                        @endif
                        @if ($item->dinner != null)
                            <span class="label label-warning">{{$item->dinner()->first()->name}}</span>
                        @endif

                        @if ($item->breakfast == null and $item->lunch == null and $item->dinner == null)
                            <p class="bg-warning"><i>No meals for these day</i></p>
                        @endif
                  
            </div>


            <!-- Activities --> 
            <div id="activitie_list" class="col-md-3">      
                        <h5><i class="glyphicon glyphicon-glass"> Activities</i></h5> 
            </div>


            <!-- Edit item -->
            <div id="see_all" class="col-md-3">
                <span id="btn_breakfast" class="btn btn-default btn-sm pull-right"  onClick="window.location.replace('{{route('plans.items.show',['plan_id' => $item->plan_id, 'item_id' => $item->id])}}');"><i class="fa fa-edit fa-fw"></i>&nbsp;edit</span>
            </div>

        </div>

        <hr>  

        @endforeach     
@endif
