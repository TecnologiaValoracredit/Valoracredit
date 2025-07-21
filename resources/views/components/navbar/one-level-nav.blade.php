<li class="nav-item {{ Request::routeIs($menu->permission->permissionModule->name.'.index') ? 'active' : '' }}">
    <a href="{{ route($menu->permission->permissionModule->name.'.index') }}" class="list-group-item my-1 p-3  nav-link">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home me-1">
            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
            <polyline points="9 22 9 12 15 12 15 22"></polyline>
        </svg>
        <span>{{ $menu->name ?? '' }}</span>
    </a>
</li>