@extends('layouts.app')
@section('content')

<?php $plan = $data['plan']; ?>
<?php $today = $data['today']; ?>



<div class="row">

    	<!-- Plan details -->
    	<div id="plan" class="col-md-4">
    		<div class="card text-left mb-3">
    			<h6 class="card-header-white"><i class="fa fa-file"></i>&nbsp;&nbsp;Details</h6>
    			<div class="card-body">
    				<ul class="list-group list-group-flush">
					    <li id="name" class="list-group-item">
				    			<h5><img id="plan-icon" class="mr-3" name="plan-icon" src="{{ asset('storage/icons/plan-icon32.png') }}">{{$plan->name}}</h5>
				    			<em>{{$plan->dateFrom()}} - {{$plan->dateTo()}}</em>
					    </li>
					    <li id="persons" class="list-group-item">
					    	<p><b>Number of persons:</b></p>
		            		<em>The plan is intended for:</em> <span class="badge badge-warning text-uppercase">{{$plan->persons}} persons</span>
					    </li>
					    <li id="description" class="list-group-item">
					    	<p><b>Description:</b></p>
		            		<em>{{$plan->description}}</em>
					    </li>
					    <li class="list-group-item">
					    	<button id="btn_edit_plan" class="btn btn-info btn-sm"><i class="fa fa-edit fa-fw"></i>&nbsp;Edit</button>
					    </li>
					 </ul>
    			</div>
    		</div>
    	</div>

    	<!-- Items list -->
    	<div class="col-md-8">
    		<div class="card text-left mb-3">
    			<div class="card-body p-0">
    				<table id="items" class="table">
                        <tbody></tbody>
                    </table>
    				
    			</div>
    			
    		</div>
    	</div>

    	<!-- Stara tabela -->
    	<!--div class="col-md-8">
			<div class="table-responsive">
				<table id="items" class="table table-survy">
                    <tbody></tbody>
                </table>	
			</div>	
		</div-->

		
		<!-- Today -->
		@if (!empty($today) and $today != null)
		<div class="col-md-4">
			<div class="card text-left mb-4">
				<h6 class="card-header-white">Today</h6>

	            <div class="card-body">

	            	<!-- Meals -->
	            	<div class="row">


	            		<h6 class="col-md-12"><i class="glyphicon glyphicon-cutlery"> Meals</i></h6>

	            		<!-- Breakfast -->
	            		@if($today->breakfast()->first() != null)
		            		<div class="col-md-4">
							    <div class="card text-center">
								    <img class="card-img-top mb-2" src="<?php 
								    	 		// Vraca collection of object
										        $photo = $today->breakfast()->first()->cover()->first();
										        $path = 'storage/photos/recipes/' . $photo['dir'] .  '/thumbs/150_' . $photo['name'];
										        echo asset($path); ?>

								    	" alt="Avatar">
								    <p class="card-title">{{$today->breakfast()->first()->name}}</p>
							    	<p class="card-text">
								    	<small class="text-muted">
								    		{{number_format((float)$today->breakfast()->first()->getTotalPrice(), 2, '.', '')}}
	                                    	<span class='text-danger'>({{$location->currency}})</span>
								    	</small>
							    	</p>
								</div>
							</div>
	            		@endif

	            		<!-- Lunch -->
	            		@if($today->lunch()->first() != null)
		            		<div class="col-md-4">
							    <div class="card text-center">
								    <img class="card-img-top mb-2" src="<?php 
								    	 		// Vraca collection of object
										        $photo = $today->lunch()->first()->cover()->first();
										        $path = 'storage/photos/recipes/' . $photo['dir'] .  '/thumbs/150_' . $photo['name'];
										        echo asset($path); ?>

								    	" alt="Avatar">
								    <p class="card-title">{{$today->lunch()->first()->name}}</p>
								    <p class="card-text">
								    	<small class="text-muted">
								    		{{number_format((float)$today->lunch()->first()->getTotalPrice(), 2, '.', '')}}
	                                    	<span class='text-danger'>({{$location->currency}})</span>
								    	</small>
							    	</p>
								</div>
							</div>
	            		@endif

	            		<!-- Dinner -->
	            		@if($today->dinner()->first() != null)
							<div class="col-md-4">
							     <div class="card text-center">
								    <img class="card-img-top" src="<?php 
								    	 		// Vraca collection of object
										        $photo = $today->dinner()->first()->cover()->first();
										        $path = 'storage/photos/recipes/' . $photo['dir'] .  '/thumbs/150_' . $photo['name'];
										        echo asset($path); ?>

								    	" alt="Avatar">
							    	
									<p class="card-title">{{$today->dinner()->first()->name}}</p>
								    <p class="card-text">
								    	<small class="text-muted">
								    		{{number_format((float)$today->dinner()->first()->getTotalPrice(), 2, '.', '')}}
	                                    	<span class='text-danger'>({{$location->currency}})</span>
								    	</small>
							    	</p>
								</div>
							</div>
	            		@endif

	            	</div>	

				<hr>
				<h6><i class="glyphicon glyphicon-shopping-cart"> Groceries</i></h6>
			
				<hr>
				<h6><i class="glyphicon glyphicon-glass"> Activities</i></h6>
				

				<hr>
			
            	<button id="btn_see_all" class="btn btn-info btn-sm" onClick="window.location.replace('{{route('plans.items.show',['plan_id' => $today->plan_id, 'item_id' => $today->id])}}');"><i class="fa fa-edit fa-fw"></i>&nbsp;Edit</button>

	            		            	
	        </div><!-- panel body - ends -->
	            
			</div>	
		</div>
		@endif

		

		<!-- Stari izgled - koristio div -->
		<!--div class="col-md-12">
			<div class="card text-left">
				<div class="card-header-white"><p class="fa fa-calendar"><b>&nbsp;Calendar</b></p></div>
	            <div class="card-body">

	           
	            	<div id="items" name="items" class="col-md-12"></div>
	            	
	            </div>
			</div>	
		</div-->



</div>	<!-- row - ends -->



<script type="text/javascript">

$(document).ready(function(){

		// Open modal edit plan 
        $("#btn_edit_plan").on('click', function(){
            showModal('{{ route("plans.edit",["id" => $plan->id])}}','m_edit_plan'); 
        });

	    // Load plan items
	    loadTableData('{{ route("plans.items",["id" => $plan->id]) }}','items');
	    //loadDiv//Data('{{ route("plans.items",["id" => $plan->id]) }}','items');

});


</script>



@endsection