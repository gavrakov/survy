<!-- Modal create recipe -->
<div id="create" class="modal fade">
  <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create recipe</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                    <form id="create_f" role="form" enctype="multipart/form-data" method="POST" action="{{ route('recipes.store') }}">
             

                        <!-- Name -->
                        <div id="f_name" class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name">Name</label>
                            <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus >
                            @if ($errors->has('name'))
                                <span class="help-block">
                                    {{ $errors->first('name') }}
                                </span>
                            @endif
                        </div>

                        <!-- Categories -->
                        <div id="f_categories" class="form-group">
                                <label>Categories</label>
                                <!--select id="categories" name="categories[]" class="form-group" multiple="multiple">
                                    @if(isset($categories))
                                        @foreach($categories as $category) 
                                            <option value="{{$category->id}}">{{$category->name}}</option>
                                        @endforeach
                                    @endif
                                </select-->
                                <select style="width:100%;" id="categories" name="categories[]" class="form-group {{ $errors->has('name') ? ' has-error' : '' }}" multiple="multiple">
                                    @if(isset($categories))
                                        @foreach($categories as $category) 
                                            <option value="{{$category->id}}">{{$category->name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                        </div>

                        <!-- Number of persons -->
                        <div id="f_persons" class="form-group {{ $errors->has('persons') ? ' has-error' : '' }}">
                            <label for="persons">Number of persons</label>
                            <input id="persons" type="text" class="form-control" name="persons" value="{{ old('persons') }}" required autofocus >
                            @if ($errors->has('persons'))
                                <span class="help-block">
                                    {{ $errors->first('persons') }}
                                </span>
                            @endif
                        </div>

                              
                    </form>
            </div>
            <div class="modal-footer">
                <button id="btn_close" data-dismiss="modal" type="button" name="btn_close" class="btn btn-md btn-secondary">Close</button>
                <button id="btn_insert" onClick="save('create');" type="button" name="btn_insert" class="btn btn-md btn-info">Save</button>
            </div>
        </div>
  </div>  
</div>


<script type="text/javascript">

$(document).ready(function() {
    $('#categories').select2({
        //placeholder: 'Select categories'
    });
});

</script>
