<!-- Navigation-->
<nav class="navbar navbar-expand-lg navbar-light bg-primary">
    <a class="navbar-brand" href="{{route('home')}}">{{__('app.name')}}</a>
    @if(Auth::id())
    {{--<span>{{__('players.logged_as')}}: {{Auth::user()->name}}</span>--}}
    @endif
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto topnav">
            @guest
                @if (Route::has('login'))
                    <li class="nav-item my-1 mx-2">
                        <a class="nav-link btn btn-success text-white" type="button" href="{{route('login')}}" >{{__('buttons.login')}}</a>
                    </li>

                @endif

                @if (Route::has('register'))
                    <li class="nav-item my-1 mx-2">
                        <a class="nav-link btn btn-info text-white" type="button"href="{{route('register')}}">{{__('buttons.register')}}</a>
                    </li>
                @endif
            @else
                <li class="nav-item my-1 mx-2">
                    <span class="nav-link btn btn-light text-black font-weight-bold" type="button" >{{__('players.logged_as')}}: {{Auth::user()->name}}</span>
                </li>
                {{--<li class="nav-item my-1 mx-2">
                    <a class="nav-link btn btn-success text-black font-weight-bold" type="button" href="{{route('table.create')}}">{{__('buttons.new_game')}}</a>
                </li>--}}

                <li class="nav-item my-1 mx-2">
                    <a class="nav-link btn btn-info text-black font-weight-bold" type="button" href="{{route('table.index')}}">{{__('buttons.my_games')}}</a>
                </li>

                <li class="nav-item my-1 mx-2">
                    <a class="nav-link btn btn-success text-black font-weight-bold" type="button" href="{{route('table.current')}}">{{__('buttons.current_games')}}</a>
                </li>

                <li class="nav-item my-1 mx-2">
                    <a class="nav-link btn btn-warning text-black font-weight-bold" type="button" href="{{route('user.index')}}">{{__('buttons.my_friends')}}</a>
                </li>

                <li class="nav-item my-1 mx-2">
                    <a class="nav-link btn btn-secondary text-black font-weight-bold" type="button" href="#">{{__('buttons.account')}}</a>
                </li>

                <li class="nav-item my-1 mx-2">
                    <a class="nav-link btn btn-danger text-white" type="button"
                       href="{{route('logout')}}" data-toggle="modal" data-target="#myModal"
                       onclick="event.preventDefault();
                           document.getElementById('logout-form').submit();">{{__('buttons.logout')}}</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>

            @endguest
        </ul>
    </div>

</nav>
