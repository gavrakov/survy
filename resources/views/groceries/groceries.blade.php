@extends('layouts.app')
@section('content')

<div name='rowica' class="row">
    <div class="col-md-12">

        <!-- Card - add and search part -->
        <div class="card text-left mb-3">
            <div class="card-body p-0">
                <div class="row p-4">
                    <div class="col">
                        <button id="create_grocery" class="btn btn-info btn-sm"><i class="fas fa-plus"></i>&nbsp; Create new</button>
                    </div>
                    <div class="col">
                        <input type="text" style="width:50%;" id="search" name="search" class="form-control pull-right" placeholder="Search..."> 
                    </div>
                </div>

                <table id="groceries" class="table">
                    <thead>
                        <tr>
                            <th width="10%" class="border-bottom-0">Photo</th>
                            <th width="20%" class="border-bottom-0">Name</th>
                            <th width="20%" class="border-bottom-0">Category</th>
                            <th width="10%" class="border-bottom-0">Unite</th>
                            <th width="10%" class="border-bottom-0">Quantity</th>
                            @if (LocationManager::isActive())
                                <th width="15%" class="border-bottom-0">Price <small class='text-danger'>({{LocationManager::country()->currency}})</small></th>
                            @endif
                            <th width="5%" class="border-bottom-0"></th>
                            <th width="5%" class="border-bottom-0"></th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
               
            </div>

        </div>

        
    </div>
</div>



<script type="text/javascript">

    // On document ready 
    $(document).ready(function() {

        // Load all groceries
        loadTableData('{{URL::to('groceries/load')}}');

        // Open modal create recipe 
        $("#create_grocery").on('click', function(){
            showEditModal('{{ route('groceries.create') }}','create'); 
        });

        // Search
        $("#search").on('keyup', function(){
            liveSearch($(this).val(),'{{URL::to('groceries/search')}}');
        });

    });



    // Delete grocery
    function deleteGrocery(url) {
     
        $.ajax({
            headers: {'X-CSRF-TOKEN' : '{{ csrf_token() }}'},
            type: 'get',
            url: url,
            dataType: 'html',

            success: function(response) {

                // Prikaz notifikacije
                showNotification('success', 'The grocery was succcessfully deleted');

                // Load all groceries.
                loadTableData('{{URL::to('groceries/load')}}');

                console.log(response);
            },

            error: function(response) {

                // Prikaz notifikacije
                showNotification('danger', 'The grocery could not be deleted');

                console.log(response);
            }

        });
       
    }


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



// SREDITI UPLOAD FOTOGRAFIJE I FORM VALIDATION SA PRIKAZOM GRESAKA

    /* 
    * Save grocery  
    *   act 0 - create
    *   act 1 - edit
    */
    function save(modal_id) {

        var name = $("#name");
        var category = $("#category");
        var unite = $("#unite");
        var quantity = $("#quantity");
        var form = $("#create_f");

       

        $.ajax({
            headers: {'X-CSRF-TOKEN' : '{{ csrf_token() }}'},
            type: 'post',
            url: form.attr("action"),
            dataType: 'json',
            data: form.serialize(),

            success: function(response) {

                console.log(response);

                // Form reset
                form[0].reset();

                // Load all groceries.
                loadTableData('{{URL::to('groceries/load')}}');

                $("#" + modal_id).modal('hide');  

                showNotification('success', 'The grocery was succcessfully saved');

            },

            error: function(response) {
                console.log(response);
                // Show errores
                showValidationErrors(response);
            }  

        });


    }

</script>





<script type="text/javascript">
    $.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });
</script>


@endsection