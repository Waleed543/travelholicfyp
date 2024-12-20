<nav class="navbar navbar-expand-md navbar-dark bg-dark @yield('nav')">
    <a class="navbar-brand" href="{{route('home')}}"><img src="{{asset('img/logowhite.png')}}"></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav float-left">
            <li class="nav-item">
                <a class="nav-link" href="{{route('home')}}">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('blog.index')}}">Blog</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('tour.index')}}">Tour</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('vehicle.index')}}">Vehicle</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('hotel.index')}}">Hotel</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{route('contactus')}}">Contact</a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <!-- Authentication Links -->
            @guest
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                </li>
                @if (Route::has('register'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                    </li>
                @endif
            @else
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->name }} <span class="caret"></span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        @can('isAdmin')
                            <a class="dropdown-item" href="{{ route('admin') }}">
                                {{'Dashboard'}}
                            </a>
                        @elsecan('notAdmin')
                            <a class="dropdown-item" href="{{ route('dashboard') }}">
                                {{'Dashboard'}}
                            </a>
                        @endcan
                        <a class="dropdown-item" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
            @endguest
        </ul>
    </div>
</nav>
