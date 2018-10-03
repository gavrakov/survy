@if (isset($plans))
	@foreach ($plans as $plan)
    <tr>
        <td>
            <h6>
                <img id="plan-icon" name="plan-icon" src="{{ asset('storage/icons/plan-icon24.png') }}">&nbsp;
                {{$plan->name}}
            </h6>
        </td>
        <td><em>{{$plan->dateFrom()}} - {{$plan->dateTo()}}</em></td>
    </tr>
	@endforeach

    <tr>
        <td  id="pagination" colspan="100%" align="center">{{ $plans->links() }}</td>
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