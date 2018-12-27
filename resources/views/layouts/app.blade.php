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
    <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">

    <!-- Metis menu -->
    <link href="{{ asset('css/metisMenu.min.css') }}" rel="stylesheet" type="text/css">

    <!-- Ajax -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>

    <!-- Animate -->
    <link href="{{ asset('css/Animate.css') }}" rel="stylesheet" type="text/css">

    <!-- Select2 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />

    <!-- Bootstrap datepicker -->
    <link href="{{ asset('css/bootstrap-datepicker.css') }}" rel="stylesheet" type="text/css">

    <!-- Croppie - photograph manipulation and croping -->
    <link href="{{ asset('css/croppie.css') }}" rel="stylesheet" type="text/css">


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

        <!-- Top navigation -->
        @include('inc/top-nav')
        
      
            <div id="page-content" class="col-lg-12">
                <h4 class="page-header mb-4">
                  
                    @php
                        $page = explode('.',Route::current()->getName());
                        echo ucfirst($page[0]);
                    @endphp
                </h4>


               
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                @yield('content')
            </div>
        </div>


        
    </div>


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

    <!-- Croppie - photograph manipulation and croping -->
    <script src="{{ asset('js/croppie.js') }}"></script>

    <!-- Infinite Scroll -->
    <script src="{{ asset('js/infinite-scroll.js') }}"></script>

    <!-- Select2 js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>


    <!-- ~~~~~~~~~~~~~~~ -->
    <!-- Survy functions -->
    <!-- ~~~~~~~~~~~~~~~ -->

    <!-- Data loader -->
       <script src="{{ asset('js/survy/loader.js') }}"></script>

   




    <script>
        
        $(document).ready(function(){
            
            // Set plan location
            //setActiveLocation();

        });

    </script>


</body>
</html>
