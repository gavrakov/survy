  @if (isset($items))
    	@foreach ($items as $item)

        <tr id="{{$item->id}}">


            <!-- Recipe name and dates -->
            <td id="date" class="p-2 align-middle">
                <h6><img width=20x" src="<?php  $path = 'storage/icons/calendar-icon.png'; echo asset($path); ?>">&nbsp;{{$item->date}}</h6>
            </td>

            <!-- Recipes -->
            <td id="recipes_list" class="p-2">
                    
                        <p>Meals</p>
                    
                        @if ($item->breakfast != null)
                            <span class="badge badge-info">{{$item->breakfast()->first()->name}}</span>
                            
                        @endif
                        @if ($item->lunch != null)
                            <span class="badge badge-success">{{$item->lunch()->first()->name}}</span>
                        @endif
                        @if ($item->dinner != null)
                            <span class="badge badge-warning">{{$item->dinner()->first()->name}}</span>
                        @endif

                        @if ($item->breakfast == null and $item->lunch == null and $item->dinner == null)
                            <!--p class="bg-warning"><i>No meals for these day</i></p-->
                            <span class="badge badge-light"><i>No meals for these day</i></span>
                        @endif
                  
            </td>


            <!-- Activities --> 
            <td id="activitie_list" class="p-2 align-middle">      
                        <p>Activities</p> 
            </div>


            <!-- Edit item -->
            <td id="see_all" class="p-2 align-middle">
                <button id="btn_breakfast" class="btn btn-light btn-sm pull-right"  onClick="window.location.replace('{{route('plans.items.show',['plan_id' => $item->plan_id, 'item_id' => $item->id])}}');"><i class="fa fa-edit fa-fw"></i>&nbsp;edit</button>
            </td>

        </tr>

        

        @endforeach     
@endif
