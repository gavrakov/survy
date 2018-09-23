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

    <!-- Font awesome icons -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">



    
</head>
<body>

    <!-- App -->
    <div id="wrapper">

    @guest

        @yield('content')

    @else


           <!-- Nav -->
           @include('inc/nav')

            <div id="page-wrapper">

              
                    <nav class="navbar navbar-expand-lg navbar-light bg-light" role="navigation">

                        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">           
                                <span class="sr-only">Toggle navigation</span>
                                <span><i class="fas fa-bars"></i></span>
                         </button> 


                        <div class="container-fluid"> <!-- OVDE SAM STIGAO -->


                            <!--button type="button" id="btnnavCollapse" class="btn btn-info">
                                <span><i class="fas fa-align-left"></i> Toggle Sidebar</span>
                            </button-->

                            <!-- Navbar toggler -->   
                           
                            <!--button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"> </button-->

                            <div class="collapse navbar-collapse" id="navbarSupportedContent">

                                <ul class="navbar-nav ml-auto">

                                    <li class="nav-item">
                                         <div class="nav-border text-center" url="{{route('locations.country')}}" onClick="window.location.replace('{{route('locations')}}');">
                                      
                                            <!--image id="img_loc" width="16px;" src="{{asset('storage/icons/earth.png')}}"-->
                                            <i class="fa fa-globe"></i>&nbsp;<br>
                                                @if(LocationManager::isActive())
                                                    {{LocationManager::country()->country_name}}
                                                @else
                                                    No location selected
                                                @endif
                                            
                                       
                                      
                                        </div> 
                                    </li>

                                    <li class="nav-item">
                                         <div class="nav-border text-center" url="{{route('locations.country')}}" onClick="window.location.replace('{{route('plans')}}');">
                                      
                                            <!--image id="img_loc" width="16px;" src="{{asset('storage/icons/earth.png')}}"-->
                                            <i class="fa fa-calendar"></i>&nbsp;<br>
                                                @if(PlanManager::isActive() != null)
                                                    {{PlanManager::getActive()->name}}
                                                @else
                                                    No plan selected
                                                @endif
                                            
                                       
                                      
                                        </div> 
                                    </li>

                                    <li class="nav-item">
                                       
                                        <div class="btn-group nav-border text-center" style="border:0;">
                                            <!--a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true" align="center">
                                                
                                                <img src="/uploads/users/{{ Auth::user()->avatar}}" style="width:40px; width:40px; position:relative; border-radius:50%; border:1px #888888 solid">
                                            </a-->

                                            <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button">
                                                <i class="fa fa-user fa-fw"></i><br>
                                                {{Auth::user()->name}}
                                            </a>


                                            <ul class="dropdown-menu dropdown-user">
                                                <li class="dropdown-item">
                                                    <a href="{{ route('user.profile') }}"><i class="fa fa-user fa-fw"></i>&nbsp;User Profile</a>
                                                </li>
                                                <li class="dropdown-item">
                                                    <a href="#"><i class="fas fa-cog"></i>&nbsp;Settings</a>
                                                </li>
                                                <li class="dropdown-divider"></li>
                                                <li class="dropdown-item">
                                                    <a href="{{ route('logout') }}"
                                                                onclick="event.preventDefault();
                                                                         document.getElementById('logout-form').submit();">
                                                                <i class="fas fa-sign-out-alt"></i>&nbsp;Logout
                                                    </a>

                                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                        {{ csrf_field() }}
                                                    </form>
                                                </li>
                                            </ul>

                                        </div>
                                        <!-- Dropdown-user end -->
                                    </li>
                                    
                                </ul>
                            </div>

                        </div>

                    </nav>
                
                <div class="row">
                    <div id="page-content" class="col-lg-12">
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




          

                

         
           
                <!--div class="row">
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

                {{--@yield('content') --}}


            </div-->

        

        <!--/div--> <!-- row ends -->

   


    @endguest

    </div>


    <!-- Scripts -->
    <!--script src="{{ asset('js/app.js') }}"></script--> <!-- asset ucitava sve iz public foldera -->


    <!-- Metis Menu Plugin JavaScript -->
    <script src="{{ asset('js/metisMenu.min.js') }}"></script>

    <!-- Global functions -->
    <script src="{{ asset('js/functions.js') }}"></script>

    <!-- Survy js -->
    <!--script src="{{ asset('js_bs4/bootstrap.min.js') }}"></script-->
    <script src="{{ asset('bs4/js/bootstrap.min.js') }}"></script>

    <!-- Survy bundle -->
    <!--script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script-->

    <!-- Popup notifications -->
    <script src="{{ asset('js/notify/bootstrap-notify.js') }}"></script>
    <!--script src="{{ asset('js/notify/Gruntfile.js') }}"></script-->

    <!-- Upload files plugin -->
    <script src="{{ asset('js/file/jquery.ui.widget.js') }}"></script>
    <script src="{{ asset('js/file/jquery.iframe-transport.js') }}"></script>
    <script src="{{ asset('js/file/jquery.fileupload.js') }}"></script>

       <!-- Bootstrap datepicker -->
    <script src="{{ asset('js/bootstrap-datepicker.js') }}"></script>

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
