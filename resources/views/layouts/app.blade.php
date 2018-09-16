<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Survy') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css_bs4/bootstrap.css') }}" rel="stylesheet">

    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">


    <link href="{{ asset('css/survy.css') }}" rel="stylesheet">


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

    <!-- Bootstrap atepicker -->
    <link href="{{ asset('css_bs4/bootstrap-datepicker.css') }}" rel="stylesheet" type="text/css">


    

    
    
</head>
<body>

    @guest

        @yield('content')

    @else

    <!-- App -->
    <div id="wrapper">

       <!-- Nav -->
       @include('inc/nav')

        <!-- Page -->
        <div id="page-wrapper">
            <div class="row">
                <div id="page_content" class="col-lg-12">

                    <!-- Page name -->
                    <h1 class="page-header">
                        @php
                            $page = explode('.',Route::current()->getName());
                            echo ucfirst($page[0]);
                        @endphp
                    </h1>

                    <!-- Status message -->
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                </div> <!-- /.col-lg-12 -->

            </div>  

            @yield('content')

        </div>

    </div>
    <!-- Wrapper end -->

    @endguest


    <!-- Scripts -->
    <!--script src="{{ asset('js/app.js') }}"></script--> <!-- asset ucitava sve iz public foldera -->


    <!-- Metis Menu Plugin JavaScript -->
    <script src="{{ asset('js_bs4/metisMenu.min.js') }}"></script>

    <!-- Global functions -->
    <script src="{{ asset('js_bs4/functions.js') }}"></script>

    <!-- Survy js -->
    <script src="{{ asset('js_bs4/bootstrap.min.js') }}"></script>

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
