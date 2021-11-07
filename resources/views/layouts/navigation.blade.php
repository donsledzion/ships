<!-- Navigation-->
<nav class="navbar navbar-expand-lg navbar-light bg-primary">
    <a class="navbar-brand" href="#">{{config('app.name')}}</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto topnav">
            <li class="nav-item active">
                <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Shop Pre-Owned</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Shop New Cars</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Clearence Event</a>
            </li>


            @guest
                @if (Route::has('login'))
                    <li class="nav-item">
                        <a class="nav-link btn btn-success text-white" type="button" href="{{route('login')}}" >{{__('buttons.login')}}</a>
                    </li>

                @endif

                @if (Route::has('register'))
                    <li class="nav-item">
                        <a class="nav-link btn btn-info text-white" type="button"href="{{route('register')}}">{{__('buttons.register')}}</a>
                    </li>
                @endif
            @else
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{ucfirst(Auth::user()->name)}}
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{route('table.create')}}">{{__('buttons.new_game')}}</a>
                        <a class="dropdown-item" href="#">{{__('buttons.account')}}</a>
                        <a class="dropdown-item" href="#">{{__('buttons.my_games')}}</a>
                        <a class="dropdown-item" href="#">{{__('buttons.my_friends')}}</a>
                        <div class="dropdown-divider"></div>
                        <a class="nav-link btn btn-danger text-white" type="button"
                           href="{{route('logout')}}" data-toggle="modal" data-target="#myModal"
                           onclick="event.preventDefault();
                           document.getElementById('logout-form').submit();">{{__('buttons.logout')}}</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </li>

            @endguest
            <li class="nav-item">
                <a class="nav-link" href="#">About</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Contact</a>
            </li>
        </ul>
    </div>

</nav>
