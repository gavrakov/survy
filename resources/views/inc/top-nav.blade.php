 <nav class="navbar navbar-expand-lg navbar-light bg-light" role="navigation">

                        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">           
                                <span class="sr-only">Toggle navigation</span>
                                <span><i class="fas fa-bars"></i></span>
                         </button> 


                        <div class="container-fluid">

                            <div class="collapse navbar-collapse" id="navbarSupportedContent"> <!-- Podsetnik: sklanja menu kada je prikaz manji -->

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