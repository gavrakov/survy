<?php if(isset($form_data['grocery'])) { $grocery = $form_data['grocery'];} ?>

<div id="edit" class="modal fade">
  <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit grocery</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                    <form id="create_f" role="form" enctype="multipart/form-data" method="POST" action="{{ route('groceries.update',['id' => $grocery->id]) }}'">
                            {{ csrf_field() }}

                                <!-- Name -->
                                <div id="f_name" class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                                    <label for="name">Name</label>
                                    <input id="name" type="text" class="form-control" name="name" value="{{$grocery->name}}" required autofocus>
                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                            {{ $errors->first('name') }}
                                        </span>
                                    @endif
                                </div>

                                <!-- Category -->
                                 <div id="f_category" class="form-group">
                                        <label>Category</label>
                                        <select id="category" name="category" class="form-control">
                                            @if(isset($form_data['categories']))
                                                @foreach($form_data['categories'] as $category) 
                                                    @if($category->id == $grocery->category)
                                                        <option value="{{$category->id}}" selected>{{$category->name}} - {{$category->description}}</option>
                                                    @else
                                                        <option value="{{$category->id}}">{{$category->name}} - {{$category->description}}</option>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </select>
                                </div>

                                <!-- Unite -->
                                <div id="f_unite" class="form-group">
                                        <label>Unite</label>
                                        <select id="unite" name="unite" class="form-control">
                                             @if(isset($form_data['unites']))
                                                @foreach($form_data['unites'] as $unite) 
                                                    @if($unite->id == $grocery->unite)
                                                        <option value="{{$unite->id}}" selected>{{$unite->unite}}</option>
                                                    @else
                                                        <option value="{{$unite->id}}">{{$unite->unite}}</option>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </select>
                                </div>

                                

                                <!-- Quantity -->
                                <div id="f_quantity" class="form-group {{ $errors->has('quantity') ? ' has-error' : '' }}">
                                <label for="quantity">Quantity</label>
                                <input id="quantity" type="text" class="form-control" name="quantity" value="{{$grocery->quantity}}" required autofocus>
                                @if ($errors->has('quantity'))
                                    <span class="help-block">
                                        {{ $errors->first('quantity') }}
                                    </span>
                                @endif
                                </div>

                                @if ($form_data['location'] !== null)

                                    <!-- Price -->
                                    <div id="f_price" class="form-group {{ $errors->has('price') ? ' has-error' : '' }}">
                                    <label for="price">Price in <small class='text-danger'>({{$form_data['location']->currency}})</small></label>
                                    <input id="price" type="text" class="form-control" name="price" value=" {{$grocery->GroceriesPrices()->first()['price']}}" required autofocus>
                                    @if ($errors->has('price'))
                                        <span class="help-block">
                                            {{ $errors->first('price') }}
                                        </span>
                                    @endif
                                    </div>

                                @endif

                        </form>
            </div>
            <div class="modal-footer">
                <button id="btn_close" data-dismiss="modal" type="button" name="btn_close" class="btn btn-md btn-secondary">Close</button>
                <button id="btn_edit" type="button" onClick="save('edit');" name="btn_edit" class="btn btn-md btn-info">Save</button>
            </div>
        </div>
  </div>  
</div>
