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
                            <img class="profilePicture" src="{{ asset('storage/images/profile/'.Auth::user()->profile_picture) }}" alt="picture">
                        @else
                            <img class="profilePicture" src="{{ asset('storage/images/profile/default.png') }}" alt="picture">
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

