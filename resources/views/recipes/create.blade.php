@extends('layouts.app')
@section('content')

<div class="row">
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">Create new recipe</div>
            <div class="panel-body">

            		<!-- Checking for errors -->
            		@if ($errors->any())
					    <div class="alert alert-danger">
					        <ul>
					            @foreach ($errors->all() as $error)
					                <li>{{ $error }}</li>
					            @endforeach
					        </ul>
					    </div>
					@endif

                   <form role="form" enctype="multipart/form-data" method="POST" action="{{ route('recipes.store') }}">
                             {{ csrf_field() }}

                                <!-- Name -->
                                <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                                    <label for="name">Name</label>
                                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>
                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                            {{ $errors->first('name') }}
                                        </span>
                                    @endif
                                </div>

                                <!-- Category -->
                                 <div class="form-group">
                                        <label>Category</label>
                                        <select name="category" class="form-control">
                                            @if(isset($categories))
                                                @foreach($categories as $category) 
                                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                </div>

                                <!-- Description -->
                                <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                                	<label>Description</label>
                                	<textarea id="description" class="form-control" name="description"  value="{{ old('description') }}" rows="8">
                                		
                                	</textarea>
                                	@if ($errors->has('description'))
                                        <span class="help-block">
                                            {{ $errors->first('description') }}
                                        </span>
                                    @endif
                                </div>



                                <div class="form-group">
                                	<label>Chose photos for your recipe</label>
		                             <input type="file" name="photos[]" multiple />
		                        </div>
                            
                             	<!-- Register btn -->
                                <div class="form-group">
                                        <button type="submit" class="btn btn-md btn-success">
                                            Save
                                        </button>
                                </div>
                        </form>
            </div>
        </div>
    </div>
</div>

@endsection
