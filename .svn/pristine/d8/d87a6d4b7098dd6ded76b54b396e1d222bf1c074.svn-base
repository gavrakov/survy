@if (isset($plans))
	@foreach ($plans as $plan)

	
    <div id="{{$plan->id}}" class="row">


        <div id="plan_name" class="col-md-4">
            <h4>
                <img id="plan-icon" name="plan-icon" src="{{ asset('storage/icons/plan-icon24.png') }}">
                {{$plan->name}}
            </h4>
            <em>{{$plan->dateFrom()}} - {{$plan->dateTo()}}</em> 
        </div>

        <!--div id="dates" class="col-md-3">
            
        </div-->

        <div id="status" class="col-md-4">
            <p class="text-warning">Status: <em>Next</em></p> 
        </div>

        <div id="edit" class="col-md-4">
       
            <span id="btn_edit" class="btn btn-default btn-sm pull-right"  onClick="window.location.replace('{{route('plans.show',['id' => $plan->id])}}');"><i class="fa fa-edit fa-fw"></i>&nbsp;edit</span>

        </div>
    </div>

    <hr> 
	@endforeach

    <div class="row">
        <div id="pagination" class="col-md-8 col-md-offset-4">{{ $plans->links() }}</div>  <!-- Ovo srediti -->
    </div>    

@endif


<script type="text/javascript">
    
// Pagination
$(function() {
    $('#pagination').on('click', '.pagination a', function(e) {
        e.preventDefault();
        var url = $(this).attr('href');  
        getPlans(url);
        window.history.pushState("", "", url);
    });


    function getPlans(url) {
        $.ajax({
            type: 'get',
            url : url ,
            dataType: 'html' 
        }).done(function (data) {
            $('#plans').html(data);  
        }).fail(function () {
            alert('Plans could not be loaded.');
        });
    }
});

</script>