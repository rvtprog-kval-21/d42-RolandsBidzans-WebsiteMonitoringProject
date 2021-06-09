<nav class="main-header navbar
    {{ config('adminlte.classes_topnav_nav', 'navbar-expand') }}
    {{ config('adminlte.classes_topnav', 'navbar-white navbar-light') }}">

    {{-- Navbar left links --}}
    <ul class="navbar-nav">
        {{-- Left sidebar toggler link --}}
        @include('adminlte::partials.navbar.menu-item-left-sidebar-toggler')

        {{-- Configured left links --}}
        @each('adminlte::partials.navbar.menu-item', $adminlte->menu('navbar-left'), 'item')

        {{-- Custom left links --}}
        @yield('content_top_nav_left')
    </ul>

    {{-- Navbar right links --}}
    <ul class="navbar-nav ml-auto">
        {{-- Custom right links --}}
        @yield('content_top_nav_right')

        {{-- Configured right links --}}
        @each('adminlte::partials.navbar.menu-item', $adminlte->menu('navbar-right'), 'item')

        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown"  id="notification">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-bell"></i>
                <span class="badge badge-warning navbar-badge" id="notificationCountLable">0</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right dropdown-notifications">
                <span class="dropdown-header"> {{ __('Invitations') }}</span>
                <div class="dropdown-divider"></div>
                <div class="item-wrapper" id="invitationWrapper">
                    {{-- Here will be automaticaly created items --}}
                </div>
            </div>
        </li>

{{--        <!-- Language Dropdown Menu -->--}}
{{--        <li class="nav-item dropdown Language">--}}
{{--            @if (App::isLocale('en'))--}}
{{--                <a class="nav-link" data-toggle="dropdown" href="#">--}}
{{--                    <span class="flag-icon flag-icon-us"></span>--}}
{{--                </a>--}}

{{--            @elseif (App::isLocale('lv'))--}}
{{--                <a class="nav-link" data-toggle="dropdown" href="#">--}}
{{--                    <span class="flag-icon flag-icon-lv"></span>--}}
{{--                </a>--}}

{{--            @elseif (App::isLocale('ru'))--}}
{{--                <a class="nav-link" data-toggle="dropdown" href="#">--}}
{{--                    <span class="flag-icon flag-icon-ru"></span>--}}
{{--                </a>--}}

{{--            @else--}}
{{--                <a class="nav-link" data-toggle="dropdown" href="#">--}}
{{--                    <span class="flag-icon flag-icon-us"></span>--}}
{{--                </a>--}}
{{--            @endif--}}

{{--            --}}{{-- Languages --}}
{{--            <div class="dropdown-menu dropdown-menu-right p-0">--}}
{{--                @if (App::isLocale(''))--}}
{{--                    <a href="lang/en" class="dropdown-item {{ App::isLocale('') ? 'active' : '' }}">--}}
{{--                        <i class="flag-icon flag-icon-us mr-2"></i> {{ __('English') }}--}}
{{--                    </a>--}}

{{--                @else--}}
{{--                    <a href="lang/en" class="dropdown-item {{ App::isLocale('en') ? 'active' : '' }}">--}}
{{--                        <i class="flag-icon flag-icon-us mr-2"></i> {{ __('English') }}--}}
{{--                    </a>--}}
{{--                @endif--}}

{{--                <a href="lang/lv" class="dropdown-item {{ App::isLocale('lv') ? 'active' : '' }}">--}}
{{--                    <i class="flag-icon flag-icon-lv mr-2"></i> {{ __('Latvian') }}--}}
{{--                </a>--}}

{{--                <a href="lang/ru" class="dropdown-item {{ App::isLocale('ru') ? 'active' : '' }}">--}}
{{--                    <i class="flag-icon flag-icon-ru mr-2"></i> {{ __('Russian') }}--}}
{{--                </a>--}}
{{--            </div>--}}
{{--        </li>--}}

        <li class="nav-item dropdown user-menu show mr-3">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="true">

                @if(file_exists(public_path() . auth()->user()->getUser()->profile_image) && auth()->user()->getUser()->profile_image != '')
                    <img src="{{ asset(auth()->user()->getUser()->profile_image) }}" class="user-image img-circle elevation-2" alt="user_image">
                @else
                    @if(auth()->user()->getUser()->gender == 'Male')
                        <img src="{{ asset('images/256x256/256_1.png') }}" class="user-image img-circle elevation-2" alt="user_image">
                    @else
                        <img src="{{ asset('images/256x256/256_12.png') }}" class="user-image img-circle elevation-2" alt="user_image">
                    @endif
                @endif

                <span class="d-none d-md-inline">{{ auth()->user()->getUser()->name }}</span>

            </a>
            <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right text-shadow" style="left: inherit; right: 0px;">

                <!-- User image -->
                <li class="user-header bg-gradient-orange text-white">

                    @if(file_exists(public_path() . auth()->user()->getUser()->profile_image) && auth()->user()->getUser()->profile_image != '')
                        <img src="{{ asset(auth()->user()->getUser()->profile_image) }}" class="img-circle elevation-2" alt="user_image" style="border-color: rgb(255 255 255) !important;">
                    @else
                        @if(auth()->user()->getUser()->gender == 'Male')
                            <img src="{{ asset('images/256x256/256_1.png') }}" class="img-circle elevation-2" alt="user_image" style="border-color: rgb(255 255 255) !important;">
                        @else
                            <img src="{{ asset('images/256x256/256_12.png') }}" class="img-circle elevation-2" alt="user_image" style="border-color: rgb(255 255 255) !important;">
                        @endif
                    @endif

                    <p>
                        {{ __(auth()->user()->getUser()->roles[0]->display_name) }}
                        <small>{{ __('Member since ') . date('d.m.Y', strtotime(auth()->user()->getUser()->created_at)) }}</small>
                    </p>
                </li>

                <!-- Menu Footer-->
                <li class="user-footer">

                    @if(!(Laratrust::hasRole('userFree')) && !(Laratrust::hasRole('userPro')) && !(Laratrust::hasRole('userWebmaster')))
                        <a href="/admin/settings" class="btn btn-default">
                            {{ __('Settings') }}
                        </a>
                    @else
                        <a href="/user/settings" class="btn btn-default">
                            {{ __('Settings') }}
                        </a>
                    @endif

                    <a href="{{ route('logout') }}" class="btn btn-danger float-right" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        {{ __('Sign out') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>

                </li>
            </ul>
        </li>

{{--        --}}{{-- User menu link --}}
{{--        @if(Auth::user())--}}
{{--            @if(config('adminlte.usermenu_enabled'))--}}
{{--                @include('adminlte::partials.navbar.menu-item-dropdown-user-menu')--}}
{{--            @else--}}
{{--                @include('adminlte::partials.navbar.menu-item-logout-link')--}}
{{--            @endif--}}
{{--        @endif--}}

        {{-- Right sidebar toggler link --}}
        @if(config('adminlte.right_sidebar'))
            @include('adminlte::partials.navbar.menu-item-right-sidebar-toggler')
        @endif
    </ul>

</nav>
