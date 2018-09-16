 <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">

            <!-- Navbar-header -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.html">Survy 1.0</a>
            </div>
            <!-- /.navbar-header -->


            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <!-- Location btn -->
                    <div id="location_box" url="{{route('locations.country')}}" class="btn btn-outline btn-default" onClick="window.location.replace('{{route('locations')}}');">
                        <span id="loc_icon"><image id="img_loc" width="16px;" src="{{asset('storage/icons/earth.png')}}"></span>
                        <span id="loc_name" ></span>
                    </div>

                </li>
                <!-- Dropdown - user -->
                <li class="dropdown">
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
                    <!-- Dropdown-user end -->
                </li>
                <!-- Dropdown end -->

            </ul>
            <!-- Navbar-top-links end -->

            <!-- Sidebar -->
            <div class="navbar-default sidebar" role="navigation">

                <div class="sidebar-nav navbar-collapse">
                    <div class="sidebar-avatar">
                         <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true" align="center">
                                    
                                    <img src="/uploads/users/{{ Auth::user()->avatar}}" style="width:50px; width:50px; position:relative; border-radius:50%; border:1px #888888 solid">
                                </a>
                    </div>

                    <ul class="nav" id="side-menu">

                        <li class="sidebar-search" style="aligne:center;">
                            <div class="input-group custom-search-form">
                                <input type="text" class="form-control" placeholder="Search...">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="button">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div>
                             
                            <!-- /input-group -->
                        </li>
                        <li>
                            <a href="{{route('home')}}"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                        </li>
                        <li>
                            <a href="{{route('plans')}}"><i class="fa fa-calendar"></i> Planning</a>
                        </li>
                        <li>
                            <a href="{{route('locations')}}"><i class="fa fa-globe"></i> Locations</a>
                        </li>
                        <!--li>
                            <a href="tables.html"><i class="fa fa-table fa-fw"></i> Tables</a>
                        </li-->
                        <li>
                            <a href="{{ route('recipes') }}"><i class="fa fa-book"></i> Recepies</a>
                        </li>
                         <li>
                            <a href="{{ route('groceries') }}"><i class="fa fa-lemon-o"></i> Groceries</a>
                        </li>
                        <!--li>
                            <a href="forms.html"><i class="fa fa-edit fa-fw"></i> Forms</a>
                        </li-->
                        <!--li>
                            <a href="#"><i class="fa fa-sitemap fa-fw"></i> Multi-Level Dropdown<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="#">Second Level Item</a>
                                </li>
                                <li>
                                    <a href="#">Second Level Item</a>
                                </li>
                                <li>
                                    <a href="#">Third Level <span class="fa arrow"></span></a>
                                    <ul class="nav nav-third-level">
                                        <li>
                                            <a href="#">Third Level Item</a>
                                        </li>
                                        <li>
                                            <a href="#">Third Level Item</a>
                                        </li>
                                        <li>
                                            <a href="#">Third Level Item</a>
                                        </li>
                                        <li>
                                            <a href="#">Third Level Item</a>
                                        </li>
                                    </ul>
                                    
                                </li>
                            </ul>
                         
                        </li-->
                        <!--li>
                            <a href="#"><i class="fa fa-files-o fa-fw"></i> Sample Pages<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="blank.html">Blank Page</a>
                                </li>
                                <li>
                                    <a href="login.html">Login Page</a>
                                </li>
                            </ul>
                       
                        </li-->
                    </ul>
                </div>


            </div>
            <!-- Sidebar - end -->

        </nav>
        <!-- Navigation end -->