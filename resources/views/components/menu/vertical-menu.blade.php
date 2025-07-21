{{-- 

/**
*
* Created a new component <x-menu.vertical-menu/>.
* 
*/

--}}

        <div class="sidebar-wrapper sidebar-theme">

            <nav id="sidebar">

                <div class="navbar-nav theme-brand flex-row  text-center">
                    <div class="nav-logo">
                        <div class="nav-item theme-logo">
                            <a href="{{getRouterValue();}}/dashboard">
                                <img src="{{Vite::asset('resources/images/logo.svg')}}" class="navbar-logo logo-light" alt="logo">
                            </a>
                        </div>
                        <div class="nav-item theme-text">
                            <a href="{{getRouterValue();}}/dashboard" class="nav-link"> VALORA </a>
                        </div>
                    </div>
                    <div class="nav-item theme-toggle sidebar-toggle">
                        <div class="btn-toggle sidebarCollapse">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevrons-left"><polyline points="11 17 6 12 11 7"></polyline><polyline points="18 17 13 12 18 7"></polyline></svg>
                        </div>
                    </div>
                </div>
                <ul class="list-unstyled menu-categories" id="accordionExample">
                    @foreach ($menus as $menu)
                        <!-- Revisar si tiene permisos -->
                        @if($menu->hasSubmenus())
                            @if($menu->showSubmenus())
                                @include("components.menu.two-level-nav", $menu)
                            @endif
                        @else
                            @if(auth()->user()->hasPermissions($menu->permission->permissionModule->name.".index"))
                                @if ($menu->parent_id == null)
                                    @include("components.menu.one-level-nav", $menu)
                                @endif
                            @endif
                        @endif
                    @endforeach
                    


                <li class="menu ">
                    <a href="#account" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        <div class="">
                            <span>Cuenta</span>
                        </div>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                        </div>
                    </a>
                    <ul class="collapse submenu list-unstyled" id="account" data-bs-parent="#accordionExample">
                        <li>
                            <div class="media-body row m-3">
                                    <p class="col-12 mb-0">{{ auth()->user()->name }}</p>
                                    <p class="col-12 mb-0 text-muted">{{ auth()->user()->role->name }}</p>
                            </div>
                        </li>
                        <div class="dropdown-divider"></div>
                        <li class="d-flex justify-content-start">
                            <a href="{{ route('users.changePassword', auth()->user()->id) }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="me-2" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                                <p>Cambiar contraseña</p>
                            </a>
                        </li>
                        <li class="d-flex justify-content-start">
                            <form class=""id="logout-form" action="{{ route('logout') }}" method="POST">
                                @csrf
                                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="me-2" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                                    <p class="">Cerrar sesión</p>
                                </a>
                            </form>
                        </li>
                    </ul>
                </li>




                </ul>

                


                
            </nav>
        </div>