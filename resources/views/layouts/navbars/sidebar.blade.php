<nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-white"  style="box-shadow:none !important" id="sidenav-main">
    <div class="container-fluid">
        <!-- Toggler -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Brand -->
        <a class="navbar-brand pt-0" href="{{ route('home') }}">
            <img src="{{asset('imagen/logo.png')}}" class="navbar-brand-img" alt="...">
            <strong>Cosme García C</strong>
        </a>
        <!-- User -->
        <ul class="nav align-items-center d-md-none">
            <li class="nav-item dropdown">
                <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="media align-items-center">
                        <span class="avatar avatar-sm rounded-circle">
                        <img alt="Image placeholder" src="{{asset('imagen/logo.png')}}">
                        </span>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
                    <div class=" dropdown-header noti-title">
                        <h6 class="text-overflow m-0">{{ __('Welcome!') }}</h6>
                    </div>
                    <a href="{{ route('usuario.datos') }}" class="dropdown-item">
                        <i class="ni ni-single-02"></i>
                        <span>Mi perfil</span>
                    </a>
                    <a href="{{ route('contrasenia.cambiar') }}" class="dropdown-item">
                        <i class="ni ni-settings-gear-65"></i>
                        <span>Cambiar Contraseña</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                        <i class="ni ni-user-run"></i>
                        <span>Cerrar Sesion</span>
                    </a>
                </div>
            </li>
        </ul>
        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="sidenav-collapse-main">
            <!-- Navigation -->
            <ul class="navbar-nav">
            <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}">
                    <i class="fa fa-home text-info" ></i> <strong>Inicio</strong>
                    </a>
                </li>
            
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('egresado.index') }}">
                        <i class="fa fa-graduation-cap text-info"></i><strong>Egresados</strong>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('carreras.index') }}">
                        <i class="fa fa-university text-info"></i><strong> Carreras</strong>
                    </a>
                </li>
                @can('index_usuario')
                <li class="nav-item ">
                    <a class="nav-link" href="{{ route('usuario.listado') }}">
                    <i class="fa fa-user text-info" aria-hidden="true"></i> <strong>Usuario</strong>
                    </a>
                </li>
                @endcan
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('ayuda.index') }}">
                    <i class="fa fa-info-circle text-info" aria-hidden="true"></i><strong> Ayuda</strong>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
