@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="panel panel-default">
            <div class="panel-heading"><p class="fa fa-location-arrow">&nbsp;Locations</p></div>
            <div class="panel-body">
            	<div class="table-responsive">
                        <form class="form-inline" id="add_location_f" name="add_location_f" role="form" method="post" action="{{ route('locations.store') }}">
                        
                        <div id="f_country" class="form-group {{ $errors->has('country') ? ' has-error' : '' }}">   
                            <div class="input-group mb-2 mr-sm-2">
                                <select id="country" name="country" class="form-control">
                                    @if (isset($countries)) 
                                        @foreach($countries as $country)
                                            <option value="{{$country->id}}"><?php echo $country->country_name; ?></option>
                                        @endforeach 
                                    @endif
                                </select>
                                
                            </div>
                            <button id="add" class="btn btn-default btn-mb-2 btn-sm"><i class="glyphicon glyphicon-plus"></i>&nbsp; Add</button>
                         </div>  
                        </form>
                      
                        <hr>
                        <form id="set_active_f" role="form" method="post" action="">
                            <table id="recipes" class="table">
                                <thead>
                                    <tr>
                                        
                                        <th width="40%">Location</th>
                                        <th width="20%">Currency</th>
                                        <th width="10%">Active</th>
                                        <th></th>
                                       
                                    </tr>
                                </thead>
                                <tbody>
                                    @include('locations/locations_load')
                                </tbody>
                            </table>
                        </form>
                    </div>
                    <!-- /.table-responsive -->
                </div>
            </div>
        </div>
    </div>
</div>



<script type="text/javascript">
    $(document).ready(function() {

        // Load all groceries
        loadTableData('{{URL::to('locations/load')}}');

        // Add location
        $("#add").click(function(){
             event.preventDefault();
            save();
        });
    });


    // Set active location
    function setActive(a_url) {

        var form = $("#set_active_f");
        form.attr('action', a_url);

        $.ajax({
            headers: {'X-CSRF-TOKEN' : '{{ csrf_token() }}'},
            type : 'put',
            url: form.attr('action'),
            dataType: 'json',
            data: form.serialize(),

            success: function(response) {

                console.log(response);

                // Form reset
                form[0].reset();

                // Load all groceries.
                loadTableData('{{URL::to('locations/load')}}');

                // Set active location
                  // OVO NE RADI - TREBA SREDITI
                setActiveLocation();

                // Show notification
                showNotification('success', 'The location successfully changed!');

            },

            error: function(response) {
                
                // Show errores
                //showValidationErrors(response);
                console.log(response);
            }  

        });

    }



/* 
    * Save grocery  
    *   act 0 - create
    *   act 1 - edit
    */
    function save() {

        //var country = $("#f_country");
        var form = $("#add_location_f");
       

        $.ajax({
            headers: {'X-CSRF-TOKEN' : '{{ csrf_token() }}'},
            type: 'post',
            url: form.attr("action"),
            dataType: 'json',
            data: form.serialize(),


            success: function(response) {

                console.log(response);

                // Brise prikaz greske u koliko je odabrana lokacija validna
                $('#f_country').removeClass('has-error');
                $('#f_country' + '> span').remove();

                // Form reset
                form[0].reset();

                // Load all groceries.
                loadTableData('{{URL::to('locations/load')}}');

                // Set active location
                  // OVO NE RADI - TREBA SREDITI
                setActiveLocation();

                // Show notification
                showNotification('success', 'The grocery was succcessfully saved');

            },

            error: function(response) {

                // Show errores
                showValidationErrors(response);
            }  

        });


    }



// Delete grocery
    function deleteLocation(url) {
     
        $.ajax({
            headers: {'X-CSRF-TOKEN' : '{{ csrf_token() }}'},
            type: 'get',
            url: url,
            dataType: 'html',

            success: function(response) {

                // Prikaz notifikacije
                showNotification('success', 'The location was succcessfully deleted');

                // Load all groceries.
                loadTableData('{{URL::to('locations/load')}}');

                // Set active location 
                // OVO NE RADI - TREBA SREDITI
                setActiveLocation();

                console.log(response);
            },

            error: function(response) {

                // Prikaz notifikacije
                showNotification('danger', 'The location could not be deleted');

                console.log(response);
            }

        });
       
    }

</script>


<script type="text/javascript">
    $.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });
 </script>

@endsection
