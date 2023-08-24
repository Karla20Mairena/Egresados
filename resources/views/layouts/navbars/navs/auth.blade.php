<!-- Top navbar -->
<nav class="navbar navbar-top navbar-expand-md navbar-dark header bg-gradient-info  py-7 py-lg-3" 
id="navbar-main">
    <div style="text-align: left;margin-left: 5px;width: 50%">
        <h1 style="color: white" >@yield('title')</h1>
    </div>
    <div class="container-fluid">
        <!-- Form -->
        <form class="navbar-search navbar-search-dark form-inline mr-3 d-none d-md-flex ml-lg-auto">
            
        </form>
        <!-- User -->
        <ul class="navbar-nav align-items-center d-none d-md-flex">
            <li class="nav-item dropdown">
                <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="media align-items-center">
                        <span class="avatar avatar-sm rounded-circle">
                            <img alt="Image placeholder" src="{{ asset( '/imagen/usuario.png') }}">
                        </span>
                        <div class="media-body ml-2 d-none d-lg-block">
                            <span class="mb-0 text-sm  font-weight-bold">{{ auth()->user()->name }}</span>
                        </div>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
                    <div class=" dropdown-header noti-title">
                    </div>
                    <a href="{{ route('usuario.datos') }}" class="dropdown-item">
                        <i class="ni ni-single-02"></i>
                        <span>Perfil</span>
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
    </div>
</nav>
<br><br><br><br>
