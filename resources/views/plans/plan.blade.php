@extends('layouts.app')
@section('content')

<?php $plan = $data['plan']; ?>
<?php $today = $data['today']; ?>

<div class="row">
	
			<div id="plan" class="col-md-4">
	
			<div class="card text-left mb-4">
	            <div class="card-header-white">
	             	<p class="fa fa-file"><b>&nbsp;Plan details </b></p>
	            </div>

	            <div class="card-body">

		        	<!-- Details -->
	            	<div class="row">

		            	<div id="picture" class="col-md-2">
		            		<img id="plan-icon" name="plan-icon" src="{{ asset('storage/icons/plan-icon32.png') }}">
		            	</div>

		            	<!-- Name and date -->
		            	<div id="details" class="col-md-10">
		            		<h5>{{$plan->name}}</h5>
		                	<em>{{$plan->dateFrom()}} - {{$plan->dateTo()}}</em>
		            	</div>         	

		            </div>

		            <hr>

		            <div class="row">
		            	<div id="persons" class="col-md-12">
		            		<p><b>Number of persons:</b></p>
		            		<em>The plan is intended for:</em> <span class="label label-danger text-uppercase">{{$plan->persons}} persons</span>
		            	</div>	
		            </div>
		            <hr>

		            <!-- Description -->
		            <div class="row">

		            	<div id ="description" class="col-md-12">
		            		<p><b>Description:</b></p>
		            		<em>{{$plan->description}}</em>
		            	</div>

		 			</div>

		 			<hr>

		 			<!-- Edit btn -->
		 			<div class="row">
		            	<div id ="btn" class="col-md-12">
		            	<button id="btn_edit" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal"><i class="fa fa-edit fa-fw"></i>&nbsp;Edit</button>

		            	</div>
	            	</div>	
	      	       
	            </div>
	           
	        </div>
    	</div>

    	<div class="col-md-8">
			<div class="table-responsive">
				<table id="items" class="table table-survy">
                    <tbody></tbody>
                </table>

	           
	            	
	           
			</div>	
		</div>

		
		<!-- Today -->
		@if (!empty($today) and $today != null)
		<div class="col-md-4">
			<div class="card text-left mb-4">
				<p class="card-header-white"><b>Today</b></p>

	            <div class="card-body">

	            	<!-- Meals -->
	            	<div class="row">


	            		<h6 class="col-md-12"><i class="glyphicon glyphicon-cutlery"> Meals</i></h6>

	            		<!-- Breakfast -->
	            		@if($today->breakfast()->first() != null)
		            		<div class="col-md-4">
							    <div class="recipe-card">
								    <img src="<?php 
								    	 		// Vraca collection of object
										        $photo = $today->breakfast()->first()->cover()->first();
										        $path = 'storage/photos/recipes/' . $photo['dir'] .  '/thumbs/150_' . $photo['name'];
										        echo asset($path); ?>

								    	" alt="Avatar">
							    	
									<span>
									    {{$today->breakfast()->first()->name}} -
									    <small>
	                                    	{{number_format((float)$today->breakfast()->first()->getTotalPrice(), 2, '.', '')}}
	                                    	<span class='text-danger'>({{$location->currency}})</span>
	                                	</small>
									</span>
								</div>
							</div>
	            		@endif

	            		<!-- Lunch -->
	            		@if($today->lunch()->first() != null)
		            		<div class="col-md-4">
							    <div class="recipe-card">
								    <img src="<?php 
								    	 		// Vraca collection of object
										        $photo = $today->lunch()->first()->cover()->first();
										        $path = 'storage/photos/recipes/' . $photo['dir'] .  '/thumbs/150_' . $photo['name'];
										        echo asset($path); ?>

								    	" alt="Avatar">
							    	
									<span>
									    {{$today->lunch()->first()->name}} -
									    <small>
	                                    	{{number_format((float)$today->lunch()->first()->getTotalPrice(), 2, '.', '')}}
	                                    	<span class='text-danger'>({{$location->currency}})</span>
	                                	</small>
									</span>
								</div>
							</div>
	            		@endif

	            		<!-- Dinner -->
	            		@if($today->dinner()->first() != null)
						    <div class="col-md-4">
							    <div class="recipe-card">
								    <img src="<?php 
								    	 		// Vraca collection of object
										        $photo = $today->dinner()->first()->cover()->first();
										        $path = 'storage/photos/recipes/' . $photo['dir'] .  '/thumbs/150_' . $photo['name'];
										        echo asset($path); ?>

								    	" alt="Avatar">
							    	
									<span>
									    {{$today->dinner()->first()->name}} -
									    <small>
	                                    	{{number_format((float)$today->dinner()->first()->getTotalPrice(), 2, '.', '')}}
	                                    	<span class='text-danger'>({{$location->currency}})</span>
	                                	</small>
									</span>
								</div>
							</div>
	            		@endif


	            	</div>	

				<!---p class="btn btn-default btn-circle btn-sm"><i class="glyphicon glyphicon-cutlery"></i></p>
				<hr>
				<p class="btn btn-default btn-circle btn-sm"><i class="glyphicon glyphicon-shopping-cart"></i></p>
				<hr>
				<p class="btn btn-default btn-circle btn-sm"><i class="glyphicon glyphicon-glass"></i></p-->

				
				<!--span class="badge badge badge-danger badge-lg"> Jaja na oko</span>
				<span class="badge badge badge-danger badge-lg"> Slatki kupus</span>
				<span class="badge badge badge-danger badge-lg"> Kvasenice</span-->
				<hr>
				<h6><i class="glyphicon glyphicon-shopping-cart"> Groceries</i></h6>
				<!--span class="badge badge badge-danger badge-lg"> Hleb</span -->
				<hr>
				<h6><i class="glyphicon glyphicon-glass"> Activities</i></h6>
				<!--span class="badge badge badge-danger badge-lg"> Kafa u actorsu</span-->

				<hr>

            	<!--span class="badge badge badge-success badge-lg"><i class="glyphicon glyphicon-cutlery"> Slatki kupus</i></span>
				<span class="badge badge badge-danger badge-lg"><i class="glyphicon glyphicon-shopping-cart"> Prasak za ves</i></span>
				<span class="badge badge badge-warning badge-lg"><i class="glyphicon glyphicon-shopping-cart"> Kafa u Actorsu</i></span-->
			
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


		$('#btn_edit').on('click',function(){
			showModal("{{ route('plans.edit',['plan_id' => $plan->id]) }}",'m_edit_plan');
		});

	    // Load plan items
	    loadTableData('{{ route("plans.items",["id" => $plan->id]) }}','items');
	    //loadDiv//Data('{{ route("plans.items",["id" => $plan->id]) }}','items');
});



/* 
* Update plan 
*/

 function UpdatePlan(modal_id) {
  
    //var name = $("#name");
    //var description = $("#description");
   // var persons = $("#persons")
    var form = $("#edit_f");

    $.ajax({
        headers: {'X-CSRF-TOKEN' : '{{ csrf_token() }}'},
        type: 'put',
        url: form.attr("action"),
        dataType: 'json',
        data: form.serialize(),

        success: function(response) {

            // Form reset
            form[0].reset();

            $("#" + modal_id).modal('hide');

            console.log(response);

            // Prikaz novih podataka
            var name = response[1].name;
            var persons = response[1].persons + ' persons';
            var description = response[1].description;

            $('#details > h4').text(name);
            $('#persons > span').text(persons);
            $('#description > em').text(description);


       },

        error: function(response) {
           
            console.log(response);
            // Show errors
            showValidationErrors(response);
           
        }  

    });

}


</script>

</script>



@endsection