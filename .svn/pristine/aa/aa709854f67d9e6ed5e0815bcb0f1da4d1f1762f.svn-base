@extends('layouts.app')
@section('content')
<div class="row">

	
		<div id="plan" class="col-md-12">
			<div class="panel panel-default">
	            <div class="panel-heading">
	                Plan details
	            </div>
	            <div class="panel-body">
	            	<div id="picture" class="col-md-2">
	            		<img id="plan-icon" name="plan-icon" src="{{ asset('storage/icons/plan-icon64.png') }}">
	            	</div>

	            	<!-- Name and date -->
	            	<div id="details" class="col-md-4">
	            		<h4>{{$plan->name}}</h4>
	                	<em>{{$plan->date_from}} - {{$plan->date_to}}</em><br>
	            		<span class="label label-info">{{$plan->persons}} persons</span>
	            	</div>

	            	<!-- Persons -->
	            	<div id ="description" class="col-md-4">
	            		<em>{{$plan->description}}</em>
	            	</div>

	 
	            	<div id ="btn" class="col-md-2">
	            	<span id="btn_edit" class="btn btn-default btn-sm pull-right" data-toggle="modal" data-target="#myModal" data-path="{{route('recipes.edit',['id'=>$plan->id])}}"><i class="fa fa-edit fa-fw"></i>&nbsp;Edit</span>

	            	</div>
	            	
	      	       
	            </div>
	           
	        </div>
    	</div>

		
	
		<div class="col-md-12">
			<div class="panel panel-info">
				<div class="panel-heading"><p><b>Today</b></p></div>

	            <div class="panel-body">

	            	 <!---p class="btn btn-default btn-circle btn-sm"><i class="glyphicon glyphicon-cutlery"></i></p>
	            	 <hr>
	            	 <p class="btn btn-default btn-circle btn-sm"><i class="glyphicon glyphicon-shopping-cart"></i></p>
	            	 <hr>
	            	 <p class="btn btn-default btn-circle btn-sm"><i class="glyphicon glyphicon-glass"></i></p-->

	            	 <h5><i class="glyphicon glyphicon-cutlery"> Meals</i></h5>
	            	 <span class="badge badge badge-danger badge-lg"> Jaja na oko</span>
	            	 <span class="badge badge badge-danger badge-lg"> Slatki kupus</span>
	            	 <span class="badge badge badge-danger badge-lg"> Kvasenice</span>
	            	 <hr>
	            	 <h5><i class="glyphicon glyphicon-shopping-cart"> Groceries</i></h5>
	            	 <span class="badge badge badge-danger badge-lg"> Hleb</span>
	            	 <hr>
	            	 <h5><i class="glyphicon glyphicon-glass"> Activities</i></h5>
	            	 <span class="badge badge badge-danger badge-lg"> Kafa u actorsu</span>
	            	 <hr>
	            	<!--span class="badge badge badge-success badge-lg"><i class="glyphicon glyphicon-cutlery"> Slatki kupus</i></span>
					<span class="badge badge badge-danger badge-lg"><i class="glyphicon glyphicon-shopping-cart"> Prasak za ves</i></span>
					<span class="badge badge badge-warning badge-lg"><i class="glyphicon glyphicon-shopping-cart"> Kafa u Actorsu</i></span-->
				
	            	<span id="btn_see_all" class="btn btn-default btn-sm pull-right"><i class="fa fa-edit fa-fw"></i>&nbsp;See all</span>

	            		            	
	            </div><!-- panel body - ends -->
	            
			</div>	
		</div>
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading"><p class="fa fa-calendar"><b>&nbsp;Calendar</b></p></div>
	            <div class="panel-body">

	            	<!-- Load items -->
	            	<div id="items" name="items" class="col-md-12"></div>
	            	
	            </div><!-- panel body - ends -->
			</div>	
		</div>		
		

	

</div>	<!-- row - ends -->



<script type="text/javascript">

$(document).ready(function(){


		$('#btn_edit').on('click',function(){
			showModal("{{ route('plans.edit',['plan_id' => $plan->id]) }}",'m_edit_plan');
		});

	    // Load plan items
	    loadDivData('{{ route("plans.items",["id" => $plan->id]) }}','items');
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
            $('#details > span').text(persons);
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