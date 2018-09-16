@extends('layouts.app')
@section('content')

<div name='rowica' class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading"><p class="glyphicon glyphicon-book">&nbsp;Groceries</p></div>
            <div class="panel-body">
            	<div class="table-responsive">
                        <span id="create_grocery" class="btn btn-default btn-sm"><i class="glyphicon glyphicon-plus"></i>&nbsp; Create new</span>
                        <!--/a-->
                        <div class="input-group custom-search-form pull-right" align="center" style="width:15%;">
                                <input width="150px" type="text" id="search" name="search" class="form-control" placeholder="Search...">
                                <span class="input-group-btn">
                                <button class="btn btn-default" type="button">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                        </div>
                        <hr>
                        <table id="groceries" class="table">
                            <thead>
                                <tr>
                                    <th width="10%">Photo</th>
                                    <th width="20%">Name</th>
                                    <th width="20%">Category</th>
                                    <th width="10%">Unite</th>
                                    <th width="10%">Quantity</th>
                                    @if ($form_data['location'] !== null)   
                                        <th width="15%">Price <small class='text-danger'>({{$form_data['location']->currency}})</small></th>
                                    @endif
                                    <th width="5%"></th>
                                    <th width="5%"></th>
                                </tr>
                            </thead>
                            <tbody>
                              
                            </tbody>
                        </table>
                    </div>
                    <!-- /.table-responsive -->
                </div>
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