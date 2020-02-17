{{--<nav class="navbar navbar-expand-md navbar-light bg-white shadow-bg">--}}
{{--    <div class="container">--}}
{{--        <a class="navbar-brand" href="{{ url('/') }}">--}}
{{--            {{ config('app.name', 'Home') }}--}}
{{--        </a>--}}
{{--        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">--}}
{{--            <span class="navbar-toggler-icon"></span>--}}
{{--        </button>--}}

{{--        <div class="collapse navbar-collapse" id="navbarSupportedContent">--}}
{{--            <ul class="navbar-nav mr-auto">--}}
{{--            </ul>--}}

{{--            <ul class="navbar-nav ml-auto">--}}
{{--                @guest--}}
{{--                    <li class="nav-item">--}}
{{--                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>--}}
{{--                    </li>--}}
{{--                    @if (Route::has('register'))--}}
{{--                        <li class="nav-item">--}}
{{--                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>--}}
{{--                        </li>--}}
{{--                    @endif--}}
{{--                @else--}}
{{--                    <li class="nav-item dropdown">--}}
{{--                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>--}}
{{--                            {{ Auth::user()->name }} <span class="caret"></span>--}}
{{--                        </a>--}}

{{--                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">--}}
{{--                            <a class="dropdown-item" href="{{ route('logout') }}"--}}
{{--                               onclick="event.preventDefault();--}}
{{--                                                     document.getElementById('logout-form').submit();">--}}
{{--                                {{ __('Logout') }}--}}
{{--                            </a>--}}

{{--                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">--}}
{{--                                @csrf--}}
{{--                            </form>--}}
{{--                        </div>--}}
{{--                    </li>--}}
{{--                @endguest--}}
{{--            </ul>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</nav>--}}
<nav class="container-fluid mt-2 navContainer navContainerExpand">
    <div class="toggleButtonContainer fullWidth">
        <button id="toggleButton" class="hamburger hamburger--3dx is-active" type="button" >
          <span class="hamburger-box">
            <span class="hamburger-inner"></span>
          </span>
        </button>
        <div class="navItemsContainer">
            <a class="navItem navStart showNavItem" href="{{ url('/') }}">
                <div class="navAuth">
                    Home
                </div>
                <i class="material-icons navIcons materialIcons">
                    home
                </i>
            </a>
            @guest
                <div class="navItem navAuthContainer navAuthStart showNavItem" onclick="toggleLogin()">
                    <div class="navAuth">
                        {{ __('Login') }}
                    </div>
                    <i class="material-icons navIcons materialIcons">
                        input
                    </i>
                </div>
                <a class="navItem navAuthContainer showNavItem" href="{{ route('register')}}">
                    <div class="navAuth">
                        {{ __('Register') }}
                    </div>
                    <i class="material-icons navIcons materialIcons">
                        assignment
                    </i>
                </a>
            @else
                <div class="navItem navName showNavItem" onclick="toggleDetailsBox()">
                    <div class="userProfilePictureContainer">
                        @if(Auth::user()->profile_picture)
                            <img class="profilePicture" src="{{ asset('storage/profilePictures/'.Auth::user()->profile_picture) }}" alt="picture">
                        @else
                            <img class="profilePicture" src="{{ asset('storage/profilePictures/default.png') }}" alt="picture">
                        @endif
                    </div>
                    <div class="navAuth">
                        {{ Auth::user()->name }}
                    </div>
                    <i class="material-icons materialIcons">
                        keyboard_arrow_down
                    </i>
                    <div id="userDetailBox" class="navDetailsBox">
                        <div class="navDetailsBoxItem">
                            <i class="material-icons materialIcons mr-2">edit</i>
                            <div class="navDetailsBoxItemTitle">Edit Profile</div>
                        </div>
                        <a class="navDetailsBoxItem" href="{{ route('logout') }}" onclick="event.preventDefault();
document.getElementById('logout-form').submit();">
                            <i class="material-icons materialIcons mr-2">exit_to_app</i>
                            <div class="navDetailsBoxItemTitle">Logout</div>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                        </form>
                    </div>
                </div>
            @endguest
        </div>
    </div>
</nav>

