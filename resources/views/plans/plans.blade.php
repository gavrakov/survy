@extends('layouts.app')
@section('content')


<div class="row">

	<!-- Show active plan -->
    @if (isset($active) and !empty($active))
	<div class="col-lg-12">
     
        <div class="panel panel-info">
            <div class="panel-heading">
                <i class="glyphicon glyphicon-ok-circle"></i> Active plan
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
	            		<h4><img id="plan-icon" name="plan-icon" src="{{ asset('storage/icons/plan-icon24.png') }}"> {{$active->name}}</h4>
	            		<em>{{$active->dateFrom()}} - {{$active->dateTo()}}</em> 
	            	</div>

                    <div class="col-md-4">
                        <!--p><i class="glyphicon glyphicon-cutlery"></i> Slatki kupus</p>
                        <p><i class="glyphicon glyphicon-shopping-cart"></i> Lubenice</p>  
                        <p><i class="glyphicon glyphicon-glass"></i> Kafa u actu</p--> 
                    </div>	

                     
                    <div class="col-md-4">
                         <span id="btn_edit" class="btn btn-default btn-sm pull-right"  onClick="window.location.replace('{{route('plans.show',['id' => $active->id])}}');"><i class="fa fa-edit fa-fw"></i>&nbsp;edit</span>
                    </div>
	            	
             
                </div>
            </div>
        </div> <!-- panel-info - ends -->

    </div>
    @endif


    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading"><p class="fa fa-calendar">&nbsp;My plans</p></div>
            <div class="panel-body">
          
                    <!--span id="create_plan" class="btn btn-default btn"><i class="glyphicon glyphicon-plus"></i>&nbsp; Create new</span-->
                    <div class="row">

                        <div class="col-md-6">
                            <span id="create_plan" class="btn btn-sm btn-default btn" style="margin-bottom: 10px"><i class="glyphicon glyphicon-plus"></i>&nbsp; Create new plan</span>
                        </div>

                        <div class="col-md-6">
                            <div class="input-group custom-search-form  pull-right">
                                    <input width="150px" type="text" id="plansearch" name="plansearch" class="form-control" placeholder="Search...">
                                    <span class="input-group-btn"></span>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <!-- Plans load -->
                    <div id="plans" name="plans" class="col-md-12">&nbsp;</div>


                </div>
            </div>
        </div>
    </div>

</div>


<script type="text/javascript">


$(document).ready(function(){


    // Modal Create/Edit
    $('#create_plan').on('click',function(){
        showEditModal('{{ route('plans.create') }}','m_create_plan'); 
    });


    // Load all plans
    loadDivData('{{route("plans.load")}}','plans');


});




 // Create and Edit grocery

function showEditModal(a_url,modal_id) {

    $.ajax({

        headers: {'X-CSRF-TOKEN' : '{{ csrf_token() }}'},
        type: 'get',
        url: a_url,
        dataType: 'html',

        success: function(response) {
            
            $("#"+modal_id).remove();
            $('#page_content').append(response);
            $("#"+modal_id).modal('show');
            
        },

        error: function(response) {
            //console.log(response);
        }
    });

}


 // Live search 
$('#plansearch').on('keyup',function(){
  
    $value=$(this).val();

    $.ajax({
     
        type : 'get',
        url : "{{ route('plans.search') }}",
        dataType: 'html',
        data:{'search':$value},
        success:function(data){
            console.log(data);
            $('#plans').html(data);      
        }
 
    });
 
});


</script>

@endsection