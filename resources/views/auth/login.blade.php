@extends('layouts.app')
@section('content')
 <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Please Sign In</h3>
                    </div>
                    <div class="panel-body">
                        <form role="form" method="POST" action="{{ route('login') }}">
                             {{ csrf_field() }}

                            <!--fieldset-->
                                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                    <div class="form-group">
                                        <input class="form-control" placeholder="E-mail" name="email" type="email" autofocus>
                                         @if ($errors->has('email'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                    <div class="form-group">
                                        <input class="form-control" placeholder="Password" name="password" type="password" value="">
                                         @if ($errors->has('password'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="checkbox">
                                        <label>
                                            <input name="remember" type="checkbox" value="Remember Me">Remember Me
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-md btn-success btn-block">Login</button>
                                    <a class="btn btn-link" href="{{ route('password.request') }}">Forgot Your Password?</a>
                                </div>
                            <!--/fieldset-->
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection