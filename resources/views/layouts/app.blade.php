<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Survy') }}</title>

    <!-- Styles bs4 -->
    <link href="{{ asset('bs4/css/bootstrap.min.css') }}" rel="stylesheet">

    <!--link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet"-->

    <!-- Survy css -->
    <link href="{{ asset('bs4/survy.css') }}" rel="stylesheet">


    <!-- Custom Fonts -->
    <link href="{{ asset('css_bs4/font-awesome.min.css') }}" rel="stylesheet" type="text/css">

    <!-- Metis menu -->
    <link href="{{ asset('css_bs4/metisMenu.min.css') }}" rel="stylesheet" type="text/css">

    <!-- Ajax -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>

    <!-- Animate -->
    <link href="{{ asset('css_bs4/Animate.css') }}" rel="stylesheet" type="text/css">

    <!-- Select2 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />

    <!-- Bootstrap datepicker -->
    <link href="{{ asset('css_bs4/bootstrap-datepicker.css') }}" rel="stylesheet" type="text/css">


    

    
    
</head>
<body>

    @guest

        @yield('content')

    @else

    <!-- App -->
    <div class="container-fluid no-gutters">

        <div class="row">

           <!-- Nav -->
           @include('inc/nav')

           <div class="col-10">

                <div class="row">
                    
                    <div class="col-12">

                        <ul class="nav">

                            <li class="nav-item">
                        
                                 <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true" align="center">
                                        
                                        <img src="/uploads/users/{{ Auth::user()->avatar}}" style="width:50px; width:50px; position:relative; border-radius:50%; border:1px #888888 solid">
                                    </a>
                            </li>
                            <li class="nav-item">
                             
                                <div id="location_box" url="{{route('locations.country')}}" class="btn btn-outline btn-default" onClick="window.location.replace('{{route('locations')}}');">
                                    <span id="loc_icon"><image id="img_loc" width="16px;" src="{{asset('storage/icons/earth.png')}}"></span>
                                    <span id="loc_name" ></span>
                                </div>

                            </li>
                           
                            <li class="nav-item">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                    <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-user">
                                    <li><a href="{{ route('user.profile') }}"><i class="fa fa-user fa-fw"></i> User Profile</a>
                                    </li>
                                    <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                                    </li>
                                    <li class="divider"></li>
                                    <li>
                                         <a href="{{ route('logout') }}"
                                                    onclick="event.preventDefault();
                                                             document.getElementById('logout-form').submit();">
                                                    <i class="fa fa-sign-out fa-fw"></i> Logout
                                                </a>

                                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                    {{ csrf_field() }}
                                                </form>
                                    </li>
                                </ul>
                                
                            </li>
                         

                        </ul>

                    </div>

                        
                </div>

         
           
                <div class="row">
                    <div id="page_content" class="col-lg-12">

                      
                        <h1 class="page-header">
                            @php
                                $page = explode('.',Route::current()->getName());
                                echo ucfirst($page[0]);
                            @endphp
                        </h1>

                       
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif

                    </div> 

                </div> 

                @yield('content') 


            </div>

        

        </div> <!-- row ends -->
    </div>

   


    @endguest


    <!-- Scripts -->
    <!--script src="{{ asset('js/app.js') }}"></script--> <!-- asset ucitava sve iz public foldera -->


    <!-- Metis Menu Plugin JavaScript -->
    <script src="{{ asset('js_bs4/metisMenu.min.js') }}"></script>

    <!-- Global functions -->
    <script src="{{ asset('js_bs4/functions.js') }}"></script>

    <!-- Survy js -->
    <!--script src="{{ asset('js_bs4/bootstrap.min.js') }}"></script-->
    <link href="{{ asset('bs4/js/bootstrap.min.js') }}" rel="stylesheet">

    <!-- Survy bundle -->
    <script src="{{ asset('js_bs4/bootstrap.bundle.min.js') }}"></script>

    <!-- Popup notifications -->
    <script src="{{ asset('js_bs4/notify/bootstrap-notify.js') }}"></script>
    <!--script src="{{ asset('js/notify/Gruntfile.js') }}"></script-->

    <!-- Upload files plugin -->
    <script src="{{ asset('js_bs4/file/jquery.ui.widget.js') }}"></script>
    <script src="{{ asset('js_bs4/file/jquery.iframe-transport.js') }}"></script>
    <script src="{{ asset('js_bs4/file/jquery.fileupload.js') }}"></script>

       <!-- Bootstrap datepicker -->
    <script src="{{ asset('js_bs4/bootstrap-datepicker.js') }}"></script>

    <!-- Select2 js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

   




    <script>
        
        $(document).ready(function(){
            
            // Set plan location
            setActiveLocation();

        });

    </script>


</body>
</html>
