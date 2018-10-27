<!-- Modal create recipe -->
<div id="description" class="modal fade">
  <div class="modal-dialog modal-lg"">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit description</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="description_f" role="form" enctype="multipart/form-data" method="POST" action="{{ route('recipes.upddescription',['id' => $recipe->id]) }}">
         
                    <!-- Description -->
                    <div id="f_description" class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                        <label>Describe every step in making this recipe</label>
                        <textarea id="description" class="form-control" name="description"  value="{{ old('description') }}" rows="20">@if ($recipe->description != '') {{$recipe->description}} @else '' @endif</textarea>
                        @if ($errors->has('description'))
                            <span class="help-block">
                                {{ $errors->first('description') }}
                            </span>
                        @endif
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                 <button id="btn_close" data-dismiss="modal" type="button" name="btn_close" class="btn btn-md btn-secondary">Close</button>
                 <button id="btn_save" onClick="description();" type="button" name="btn_insert" class="btn btn-md btn-info">Save</button>
            </div>
        </div>
  </div>  
</div>



<script type="text/javascript">

    // Save description
    function description(){

        var description = $('#description');
        var form = $('#description_f');

        $.ajax({
            headers: {'X-CSRF-TOKEN' : '{{ csrf_token() }}'},
            type: 'put',
            url: form.attr('action'),
            dataType: 'json',
            data:
                form.serialize(),

            success: function(response){

                $('#description').modal('hide');
                $('#description_p').text(response.description);
                showNotification('success', 'The description was succcessfully saved');
            },

            error: function(response){
                console.log(response);
                showValidationErrors(response);
            }

        });

    }

</script>