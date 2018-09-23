<!-- Navigation --> 
<nav role="navigation">   

<div class="main-nav">      
              
    <div class="sidebar-header">
            <h3><a href="{{route('home')}}">Survy 1.0</a></h3>
    </div>

    <div class="sidebar-header-small">
            <h3><a href="{{route('home')}}">SR</a></h3>
    </div>

    <ul class="list-unstyled components sidebar">

        <li>
            <a href="{{route('home')}}"><i class="fas fa-home"></i> <span>Dashboard</span></a>
        </li>
        <li>
            <a href="{{route('plans')}}"><i class="fa fa-calendar"></i> <span>Planning</span></a>
        </li>
        <li>
            <a href="{{route('locations')}}"><i class="fa fa-globe"></i> <span>Locations</span></a>
        </li>
        <li>
            <a href="{{ route('recipes') }}"><i class="fa fa-book"></i> <span>Recepies</span></a>
        </li>
        <li>
            <a href="{{ route('groceries') }}"><i class="fas fa-apple-alt"></i> <span>Groceries</span></a>
        </li>

        <li><a><i class="fas fa-toggle-on"></i></a> </li>
      
    </ul>

</div>
   

</nav> <!-- Navigation holder ends -->