<!-- Modal create recipe -->
<div id="m_edit_plan" class="modal fade" tabindex="-1">
  <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit plan</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">

                <form id="edit_f" class="main-form needs-validation" role="form" enctype="multipart/form-data" method="POST" action="{{ route('plans.update', ['id' => $plan->id]) }}">

                    <!-- Name -->
                    <div id="f_name" class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                        
                            <label for="name">Plan name</label>
                            <input id="name" type="text" class="form-control" name="name" value="{{ $plan->name }}" required autofocus >
                            @if ($errors->has('name'))
                                <span class="invalid-feedback">
                                    {{ $errors->first('name') }}
                                </span>
                            @endif
                    </div>

                    <!-- Date -->
                    <div id="f_dates" class="form_group">

                        <div class="row">
                            <div class="col">
                                <div id="f_date_from" class= class="form-group {{ $errors->has('date_from') ? ' has-error' : '' }}">
                                    <label for="date_from">Date from</label>
                                    <input id="date_from" type="text" class="form-control" name="date_from" value="{{ $plan->date_from }}" placeholder="MM/DD/YYYY" autocomplete="off" required autofocus disabled="">
                                    @if ($errors->has('date_from'))
                                    <span class="invalid-feedback">
                                        {{ $errors->first('date_from') }}
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col">
                                <div id="f_date_to" class="form-group {{ $errors->has('date_to') ? ' has-error' : '' }}">
                                    <label for="date_to">Date to</label>
                                    <input id="date_to" type="text" class="form-control" name="date_to" value="{{ $plan->date_to }}" placeholder="MM/DD/YYYY" autocomplete="off" required autofocus disabled>
                                    @if ($errors->has('date_to'))
                                    <span class="invalid-feedback">
                                        {{ $errors->first('date_to') }}
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div> <!-- Row ends -->

                    </div> 


                    <!-- Number of persons -->
                    <div id="f_persons" class="form-group {{ $errors->has('persons') ? ' has-error' : '' }}">
                        <label for="persons">Number of persons</label>
                        <input id="persons" type="text" class="form-control" name="persons" value="{{$plan->persons}}" autocomplete="off" required autofocus >
                        @if ($errors->has('persons'))
                            <span class="invalid-feedback">
                                {{ $errors->first('persons') }}
                            </span>
                        @endif
                    </div>
                 
                    
                    <!-- Description -->
                    <div id="f_description" class="form-group {{ $errors->has('description') ? ' has-error' : '' }}">
                        
                            <label for="description">Description</label>
                             <textarea id="description" class="form-control" name="description" rows="10">{{$plan->description}}</textarea>
                            @if ($errors->has('description'))
                                <span class="invalid-feedback">
                                    {{ $errors->first('description') }}
                                </span>
                            @endif
                    </div>
                       
                </form>

            </div> <!-- modal-body end -->

            <div class="modal-footer">
                <button id="btn_close" data-dismiss="modal" type="button" name="btn_close" class="btn btn-md btn-secondary">Close</button>
                <button id="btn_insert" onClick="UpdatePlan('m_edit_plan');" type="button" name="btn_edit" class="btn btn-md btn-info">Save</button>
            </div>

        </div>
  </div>  
</div>

<script type="text/javascript">
    
/* 
* Update plan 
*/

function UpdatePlan(modal_id) {

    var form = $(".needs-validation");

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

            $('#name > h5').html('<img id="plan-icon" class="mr-3" name="plan-icon" src="{{ asset('storage/icons/plan-icon32.png') }}">' + name);
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