@extends('layouts.app')
@section('content')

<div class="row">
    <div class="col-md-3">
        <div class="panel panel-default">
            <div class="panel-heading"> <p class="fa fa-picture-o">&nbsp;Photograph</p></div>
            <div class="panel-body">
                    <!--image src="/uploads/users/{{$user->avatar }}" style="width:120px; height:120px; float:left; border-radius:50%; margin-right:25px"-->
                    <!--h3>{{ $user->name }} 's profile</h3>
                   
                    <h6>e-mail: {{$user->email}}</h6--->

                    <!--form enctype="multipart/form-data" action="{{ route('user.update') }}" method="POST"-->
                    {{ Form::open(array('route'=>'user.update','data-parsley-validate'=>'','files'=>'true')) }}
                   
                        <div class="form-group">
                            <image src="/uploads/users/{{$user->avatar}}" />
                        </div>
                        <div class="form-group">
                            <!--label>Update profile image</label-->
                            {{ Form::label('avatar', 'Update photo') }}
                        </div>

                        <div class="form-group">
                            <!--input type="file" name="avatar"-->
                            {{ Form::file('avatar') }}
                        </div>
                       

                        <!--input type="hidden" name="_token" value="{{ csrf_token() }}"-->
                        <!--input type="submit" class="pull-right btn btn-sm btn-primary"-->
                        {{ Form::submit('Save', array('class' => 'btn btn-md btn-success')) }}

                 
                    {{ Form::close() }}
                    <!--/form -->
            </div>
        </div>
    </div>
</div>

@endsection
