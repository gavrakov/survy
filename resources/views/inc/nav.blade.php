<!-- Navigation -->
<!--nav class="navbar-light bg-lite col-2" role="navigation" -->  
<nav class="navbar navbar-expand-lg navbar-light bg-light">

                <!--div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    
                </div-->
              
                    <a class="navbar-brand" href="{{route('home')}}">Survy 1.0</a>
            

          

                    <ul class="nav flex-column">

                        <li class="nav-item">
                            <a href="{{route('home')}}"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('plans')}}"><i class="fa fa-calendar"></i> Planning</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('locations')}}"><i class="fa fa-globe"></i> Locations</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('recipes') }}"><i class="fa fa-book"></i> Recepies</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('groceries') }}"><i class="fa fa-lemon-o"></i> Groceries</a>
                        </li>
                      
                    </ul>

             
    



        <!--/div-->
        <!-- Navigation end -->

</nav> <!-- Navigation holder ends -->