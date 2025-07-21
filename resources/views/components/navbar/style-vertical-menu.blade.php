
<div class="header-container {{ $classes }} d-block d-lg-none">
    <header class="navbar navbar-expand-lg navbar-light bg-light p-3 overflow-auto"  style="max-height: 80vh; ">
        {{-- Breadcrumbs --}}
        @foreach (breadcrumbs() as $breadcrumb)
            {{-- <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                {{ $breadcrumb['label'] }}
            </a> --}}
            <a class="nav-link" href="#" aria-expanded="false">
                {{ $breadcrumb['label'] }}
            </a>
        @endforeach

        {{-- Botón Hamburguesa para móviles --}}
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        {{-- Contenedor de contenido colapsable --}}
        <div class="collapse navbar-collapse" id="navbarSupportedContent">

            {{-- Menús de navegación (breadcrumbs + menús) --}}
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">

                    {{-- Menú desplegable --}}
                    <ul class="list-unstyled list-group">
                        @foreach ($menus as $menu)
                            @if($menu->hasSubmenus())
                                @if($menu->showSubmenus())
                                    @include("components.navbar.two-level-nav", $menu)
                                @endif
                            @else
                                @if(auth()->user()->hasPermissions($menu->permission->permissionModule->name.".index"))
                                    @if ($menu->parent_id == null)
                                        @include("components.navbar.one-level-nav", $menu)
                                    @endif
                                @endif
                            @endif
                        @endforeach
                    </ul>
                </li>
            </ul>

            {{-- Perfil de usuario --}}
            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown user-profile-dropdown">
                    <a href="javascript:void(0);" class="nav-link dropdown-toggle user" id="userProfileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="avatar">
                            <span class="avatar-title rounded-circle">{{ substr(strtoupper(auth()->user()->name), 0, 2) }}</span>
                        </div>
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end d-block d-none" aria-labelledby="userProfileDropdown">
                        <li class="dropdown-item user-profile-section px-3 pt-2 pb-2">
                            <div class="media">
                                <div class="emoji me-2">&#x1F44B;</div>
                                <div class="media-body">
                                    <h5 class="mb-0">{{ auth()->user()->name }}</h5>
                                    <p class="mb-0 text-muted">{{ auth()->user()->role->name }}</p>
                                </div>
                            </div>
                        </li>

                        <div class="dropdown-divider"></div>

                        <li class="dropdown-item">
                            <a href="{{ route('users.changePassword', auth()->user()->id) }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="me-2" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                                Cambiar contraseña
                            </a>
                        </li>

                        <li class="dropdown-item">
                            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                @csrf
                                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="me-2" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                                    Cerrar sesión
                                </a>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>

        </div> {{-- /collapse --}}
    </header>
</div>
