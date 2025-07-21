{{-- <li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" role="button" id="dropdownSubMenu{{ $menu->id }}"
                data-bs-toggle="dropdown" aria-expanded="false">
        {{ $menu->name }}
    </a>
    <ul class="dropdown-menu">
        @foreach($menu->submenus as $submenu)
            @if(auth()->user()->hasPermissions($submenu->permission->permissionModule->name.".index"))
                <li>
                    <a class="dropdown-item {{ Request::routeIs($submenu->permission->permissionModule->name.'.index') ? 'active' : '' }}"
                    href="{{ route($submenu->permission->permissionModule->name.'.index') }}">
                        {{ $submenu->name }}
                    </a>
                </li>
            @endif
        @endforeach
    </ul>
</li> --}}

<li class="dropdown-submenu">
    <a class="list-group-item my-1 p-3  dropdown-toggle" href="#" id="dropdownSubMenu{{ $menu->id }}" role="button"
       data-bs-toggle="dropdown" aria-expanded="false">
        {{ $menu->name }}
    </a>
    <ul class="dropdown-menu" aria-labelledby="dropdownSubMenu{{ $menu->id }}">
        @foreach($menu->submenus as $submenu)
            @if(auth()->user()->hasPermissions($submenu->permission->permissionModule->name.".index"))
                <li class="">
                    <a class="p-3 dropdown-item {{ Request::routeIs($submenu->permission->permissionModule->name.'.index') ? 'active' : '' }}"
                       href="{{ route($submenu->permission->permissionModule->name.'.index') }}">
                        {{ $submenu->name }}
                    </a>
                </li>
            @endif
        @endforeach
    </ul>
</li>
