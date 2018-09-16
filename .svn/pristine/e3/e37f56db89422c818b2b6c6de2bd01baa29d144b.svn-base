<!-- Modal create recipe -->
<div id="m_create_plan" class="modal fade">
  <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Create new plan</h3>
            </div>

            <div class="modal-body">

                <div class="row">

                    <form id="create_f" class="form" role="form" enctype="multipart/form-data" method="POST" action="{{ route('plans.store') }}">

                        <!-- Name -->
                        <div class="col-md-12">
                        <div id="f_name" class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                            
                                <label for="name">Plan name</label>
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus >
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        {{ $errors->first('name') }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Date -->
                        <div id="f_dates" class="form_group">

                            <div class="col-md-12">
                                <div id="f_plan_period" class= class="form-group {{ $errors->has('date_from') ? ' has-error' : '' }}">
                                </div>
                            </div>

                            <!-- Date from -->
                            <div class="col-md-6">
                                <div id="f_date_from" class= class="form-group {{ $errors->has('date_from') ? ' has-error' : '' }}">
                                    <label for="date_from">Date from</label>
                                    <input id="date_from" type="text" class="form-control" name="date_from" value="{{ old('date_from') }}" placeholder="MM/DD/YYYY" autocomplete="off" required autofocus>
                                    @if ($errors->has('date_from'))
                                    <span class="help-block">
                                        {{ $errors->first('date_from') }}
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <!-- Date to -->
                            <div class="col-md-6">
                                <div id="f_date_to" class="form-group {{ $errors->has('date_to') ? ' has-error' : '' }}">
                                    <label for="date_to">Date to</label>
                                    <input id="date_to" type="text" class="form-control" name="date_to" value="{{ old('date_to') }}" placeholder="MM/DD/YYYY" autocomplete="off" required autofocus >
                                    @if ($errors->has('date_to'))
                                    <span class="help-block">
                                        {{ $errors->first('date_to') }}
                                    </span>
                                    @endif
                                </div>
                            </div>

                        </div> 


                        <!-- Number of persons -->
                        <div class="col-md-12">
                        <div id="f_persons" class="form-group {{ $errors->has('persons') ? ' has-error' : '' }}">
                            
                                <label for="persons">Number of persons</label>
                                <input id="persons" type="text" class="form-control" name="persons" value="{{ old('persons') }}" autocomplete="off" required autofocus >
                                @if ($errors->has('persons'))
                                    <span class="help-block">
                                        {{ $errors->first('persons') }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        
                        <!-- Description -->
                        <div class="col-md-12">
                        <div id="f_description" class="form-group {{ $errors->has('description') ? ' has-error' : '' }}">
                            
                                <label for="description">Description</label>
                                 <textarea id="description" class="form-control" name="description"  value="{{ old('description') }}" rows="10"></textarea>
                                @if ($errors->has('description'))
                                    <span class="help-block">
                                        {{ $errors->first('description') }}
                                    </span>
                                @endif
                            </div>
                        </div>
                              
                    </form>

                </div> <!-- row end -->
            </div> <!-- modal-body end -->

            <div class="modal-footer">
                 <button id="btn_insert" onClick="save('create');" type="button" name="btn_insert" class="btn btn-md btn-success">Save</button>
            </div>

        </div>
  </div>  
</div>




<script type="text/javascript">



$(document).ready(function(){



/* MORAM DA VIDIM STA CU SA OVIM ALI TO SADA SVKAKO NIJE PRIORITET - SVE OSTALO RADI

var nowTemp = new Date();
var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);

// Checkin 
var checkin = $('#f_date_from > #date_from').datepicker({
  onRender: function(date) {
    return date.valueOf() < now.valueOf() ? 'disabled' : '';
  }
}).on('changeDate', function(ev) {
  if (ev.date.valueOf() > checkout.date.valueOf()) {
    var newDate = new Date(ev.date)
    newDate.setDate(newDate.getDate() + 1);
    checkout.setValue(newDate);
  }

  checkin.hide();
  $('#date_to_holder > #date_to')[0].focus();
}).data('datepicker');


// Checkout
var checkout = $('#date_to_holder > #date_to').datepicker({
  onRender: function(date) {
    return date.valueOf() <= checkin.date.valueOf() ? 'disabled' : '';
  }
}).on('changeDate', function(ev) {
  checkout.hide();
}).data('datepicker');

*/

// Date from
$('#f_date_from > #date_from').datepicker({
format: 'mm/dd/yyyy'
});

// Date to
$('#f_date_to > #date_to').datepicker({
format: 'mm/dd/yyyy'
});



});


/* 
* Save recipe  
*/
 function save(modal_id) {
   
    var name = $("#name");
    var date_from = $("#date_from");
    var date_to = $("#date_to");
    var description = $("#description");
    var form = $("#create_f");

    $.ajax({
        headers: {'X-CSRF-TOKEN' : '{{ csrf_token() }}'},
        type: 'post',
        url: form.attr("action"),
        dataType: 'json',
        data: form.serialize(),

        success: function(response) {

            //console.log(response);

            

            // Form reset
            form[0].reset();

            $("#" + modal_id).modal('hide');

            var url_redirect = '{{URL::to('plans/show')}}'; 

            window.location.replace(url_redirect + '/' + response[1]);

            //alert('tu');

       },

        error: function(response) {
            //alert('ovde');
            console.log(response);
            // Show errors
            showValidationErrors(response);
           
        }  

    });

}





</script>