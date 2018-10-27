<?php

    if(isset($data['recipe'])) {
        $recipe = $data['recipe'];
    }

    if(isset($data['categories'])) {
        $categories = $data['categories'];
    }


    // Formiram niz id kategorija koje pripadaju receptu
    // kako bih prikazao te kategorije na formi
    $category_arr=[];

    foreach($recipe->categories()->get() as $category) {
        $category_arr[] = $category->id;

    }
 ?>


<!-- Modal create recipe -->
<div id="edit" class="modal fade">
  <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit recipe</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                    <form id="edit_f" role="form" enctype="multipart/form-data" method="POST" action="{{ route('recipes.update',['id' => $recipe->id]) }}">
     

                        <!-- Name -->
                        <div id="f_name" class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name">Name</label>
                            <input id="name" type="text" class="form-control" name="name" value="{{ $recipe->name }}" required autofocus >
                            @if ($errors->has('name'))
                                <span class="help-block">
                                    {{ $errors->first('name') }}
                                </span>
                            @endif
                        </div>

                        <!-- Categories -->
                        <div id="f_category" class="form-group">
                                <label>Category</label>         

                                <select style="width:100%;" id="categories" name="categories[]" class="form-group {{ $errors->has('name') ? ' has-error' : '' }}" multiple="multiple">
                                    @if(isset($categories))
                                        @foreach($categories as $category) 
                                            @if (in_array($category->id, $category_arr)) 
                                                <option selected value="{{$category->id}}"> {{$category->name}}</option>
                                            @else
                                                <option value="{{$category->id}}">{{$category->name}}</option>
                                            @endif
                                        @endforeach
                                    @endif
                                </select>
                
                        </div>

                        <!-- Number of persons -->
                        <div id="f_persons" class="form-group {{ $errors->has('persons') ? ' has-error' : '' }}">
                            <label for="persons">Number of persons</label>
                            <input id="persons" type="text" class="form-control" name="persons" value="{{$recipe->persons}}" required autofocus >
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
                <button id="btn_edit" onClick="save('edit');" type="button" name="btn_edit" class="btn btn-md btn-info">Save</button>
            </div>
        </div>
  </div>  
</div>



<script type="text/javascript">

$(document).ready(function() {
    $('#categories').select2({

    });




});



</script>
