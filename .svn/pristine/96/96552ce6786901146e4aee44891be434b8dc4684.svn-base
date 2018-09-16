@extends('layouts.app')
@section('content')

<div class="row">
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">Create new grocery</div>
            <div class="panel-body">
                   <form role="form" enctype="multipart/form-data" method="POST" action="{{ route('groceries.store') }}">
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
                                            @if(isset($form_data['categories']))
                                                @foreach($form_data['categories'] as $category) 
                                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                </div>

                                <!-- Unite -->
                                <div class="form-group">
                                        <label>Unite</label>
                                        <select name="unite" class="form-control">
                                             @if(isset($form_data['unites']))
                                                @foreach($form_data['unites'] as $unite) 
                                                    <option value="{{$category->id}}">{{$unite->unite}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                </div>

                             	<!-- Register btn -->
                                <div class="form-group">
                                        <button type="submit" class="btn btn-md btn-success">Save</button>
                                </div>
                        </form>
            </div>
        </div>
    </div>
</div>

@endsection
