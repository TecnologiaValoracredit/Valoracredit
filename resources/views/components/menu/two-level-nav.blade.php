<li class="menu {{ $menu->isParentActive(Request::path()) ? "active" : "" }}">
    <a href="#{{$menu->name}}" data-bs-toggle="collapse" aria-expanded="{{ $menu->isParentActive(Request::path()) ? "true" : "false" }}" class="dropdown-toggle">
        <div class="">
            <span>{{$menu->name}}</span>
        </div>
        <div>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
        </div>
    </a>
    <ul class="collapse submenu list-unstyled {{ $menu->isParentActive(Request::path()) ? 'show' : '' }}" id="{{$menu->name}}" data-bs-parent="#accordionExample">
        @foreach($menu->submenus as $submenu)
            @if(auth()->user()->hasPermissions($submenu->permission->permissionModule->name.".index"))
                <li class="{{ Request::routeIs($submenu->permission->permissionModule->name.'.index') ? 'active' : '' }}">
                    <a href="{{ route($submenu->permission->permissionModule->name.'.index') }}"> {{$submenu->name}} </a>
                </li>
            @endif
        @endforeach
    </ul>
</li>