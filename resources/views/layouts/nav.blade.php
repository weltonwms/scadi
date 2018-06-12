<nav class="navbar-inverse navbar-default navbar-static-top">
    <div class="container">
        <div class="navbar-header">

            <!-- Collapsed Hamburger -->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <!-- Branding Image -->
            <a class="navbar-brand title-app" href="{{ url('/home') }}">
                SCADI
            </a>
        </div>

        <div class="collapse navbar-collapse" id="app-navbar-collapse">
            <!-- Left Side Of Navbar -->
            <ul class="nav navbar-nav">
                <li class="{{Request::segment(1)=='calculations'?'active':null}}">
                    <a href="{{ route('calculations.index') }}">Apuração</a>
                </li>
                @if(auth()->user()->canManageHistory)
                <li class="{{Request::segment(1)=='historics'?'active':null}}">
                    <a href="{{ route('historics.index') }}">Histórico</a>
                </li>
                @endif

                @if(auth()->user()->isAdm)
                 <li class="{{Request::segment(1)=='indicators'?'active':null}}">
                    <a href="{{ route('indicators.index') }}">Indicadores</a>
                </li>
                @endif
                 @if(auth()->user()->isAdm || auth()->user()->isGestor)
                 <li class="{{Request::segment(1)=='indices'?'active':null}}">
                    <a href="{{ route('indices.index') }}">Índices</a>
                </li>
                @endif;
                
                @if(auth()->user()->isAdm || auth()->user()->isGestor)
                <li class="{{Request::segment(1)=='users'?'active':null}}">
                    <a href="{{ route('users.index') }}">Usuários</a>
                </li>
                @endif
               
                @if(auth()->user()->isAdm)
                <li class="{{Request::segment(1)=='groups'?'active':null}}">
                    <a href="{{ route('groups.index') }}">Grupos</a>
                </li>
                @endif

            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
                <!-- Authentication Links -->
                @if (Auth::guest())
                <li><a href="{{ route('login') }}">Login</a></li>

                @else
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                        {{ Auth::user()->posto }} {{ Auth::user()->guerra }} <span class="caret"></span>
                    </a>

                    <ul class="dropdown-menu" role="menu">
                        <li>
                            <a href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                       document.getElementById('logout-form').submit();">
                                Sair
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                    </ul>
                </li>
                @endif
            </ul>
        </div>
    </div>
</nav>