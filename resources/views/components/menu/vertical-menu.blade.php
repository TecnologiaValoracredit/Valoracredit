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
                    <div class="nav-item sidebar-toggle">
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
                  
                </ul>
            </nav>
        </div>