@if (isset($plans))
	@foreach ($plans as $plan)
    <tr>
        <td class="p-4 align-middle">
            <h6>
                <img id="plan-icon" name="plan-icon" src="{{ asset('storage/icons/plan-icon24.png') }}">&nbsp;
                {{$plan->name}}
            </h6>
        </td>
        <td class="align-middle"><em>{{$plan->dateFrom()}} - {{$plan->dateTo()}}</em></td>
        <td class="align-middle">
            <a href="{{route('plans.show',['id'=>$plan->id])}}" class="btn btn-light btn-sm"><i class="fa fa-edit fa-fw"></i>&nbsp; Edit</a>
        </td>
    </tr>
	@endforeach

    <tr>
        <td  id="pagination" colspan="3">{{ $plans->links() }}</td>
    </tr>

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