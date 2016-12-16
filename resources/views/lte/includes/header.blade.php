<header class="main-header">
    <!-- Logo -->
    <a href="{{url('/home')}}" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>LPG</b></span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>LP Generator</b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="{{URL::asset('images/dist/user.jpg')}}" class="user-image" alt="User Image">
                        <span class="hidden-xs">
                             @if (Auth::guest())
                                Guest
                            @else
                                {{Auth::user()->name}}
                            @endif
                        </span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="{{URL::asset('images/dist/user.jpg')}}" class="img-circle" alt="User Image">

                            <p>
                                @if (Auth::guest())
                                    Guest
                                @else
                                    {{Auth::user()->name}}
                                    <small>Member since {{Auth::user()->created_at}}</small>
                                @endif
                            </p>
                        </li>
                        <li class="user-footer">
                            <div class="pull-left">
                                @if (Auth::check())
                                    <a href="{{url('home')}}" class="btn btn-default btn-flat">Profile</a>
                                @endif
                            </div>
                            <div class="pull-right">
                                @if (Auth::guest())
                                    <a href="{{url('/login')}}" class="btn btn-default btn-flat">Log in</a>
                                @else
                                    <a href="{{ url('/logout') }}" class="btn btn-default btn-flat"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        Log out
                                    </a>

                                    <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                @endif
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>