@extends('layouts.app')
@section('content')


<!-- Modal -->
@include('plans/modals/m_create_plan')


<div class="row">

    <div class="col-md-8">

            <div class="row"> 

                <div class="col-md-12">    

                    <div class="search-holder">  

                        <div class="col-md-8 col-sm-4">
                            <button id="create_plan" class="btn btn-info btn-sm" data-toggle="modal" data-target="#m_create_plan"><i class="fas fa-plus"></i>&nbsp; Create new plan</button>
                        </div>



                        <div class="col-md-4 col-sm-4">
                                 <input type="text" style="width:100%;" id="plansearch" name="plansearch" class="form-control pull-right" placeholder="Search...">     
                        </div>

                    </div>  
                   
                    <div class="table-responsive">

                        <table id="plans" class="table table-survy">
                            <tbody></tbody>
                        </table>

                    </div>

                </div>

            </div>

    </div> <!-- col-md-8 ends -->

     @if (isset($active) and !empty($active))
    <div class="col-md-4 mb-3 col-sm-12">
     
        <div class="card text-left">
            <h6 class="card-header-white">
                Active plan
            </h6>
            <div class="card-body">
            
                <h6 class="card-title"><img id="plan-icon" name="plan-icon" src="{{ asset('storage/icons/plan-icon24.png') }}"> {{$active->name}}</h6>
                <p class="card-text">
                    <em>{{$active->dateFrom()}} - {{$active->dateTo()}}</em>
                </p> 
            
                <button id="btn_edit" class="btn btn-default btn-sm"  onClick="window.location.replace('{{route('plans.show',['id' => $active->id])}}');"><i class="far fa-edit"></i>&nbsp;edit</button>
            </div>
            
        </div> <!-- card-info - ends -->

    </div>
    @endif

</div>





<script type="text/javascript">


$(document).ready(function(){

    // Load all plans
    loadTableData('{{route("plans.load")}}','plans');
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