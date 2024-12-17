{{-- 

/**
*
* Created a new component <x-navbar.style-vertical-menu/>.
* 
*/

--}}

    <div class="header-container {{ $classes }}">
        <header class="header navbar navbar-expand-sm expand-header d-flex justify-content-between">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                @foreach (breadcrumbs() as $breadcrumb)
                    <li class="breadcrumb-item">
                        <a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['label'] }}</a>
                    </li>
                @endforeach
            </ol>
        </nav>

            <ul class="navbar-item flex-row ms-lg-auto ms-0">

                <li class="nav-item dropdown user-profile-dropdown  order-lg-0 order-1">
                    <a href="javascript:void(0);" class="nav-link dropdown-toggle user" id="userProfileDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <div class="avatar">
                            <span class="avatar-title rounded-circle">{{substr(strtoupper(auth()->user()->name), 0, 2)}}</span>
                        </div>
                    </a>

                    <div class="dropdown-menu position-absolute" aria-labelledby="userProfileDropdown">
                        <div class="user-profile-section">
                            <div class="media mx-auto">
                                <div class="emoji me-2">
                                    &#x1F44B;
                                </div>
                                <div class="media-body">
                                    <h5>{{auth()->user()->name}}</h5>
                                    <p>{{auth()->user()->role->name}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="dropdown-item">
                            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                @csrf
                                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-out"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg> <span>Cerrar sesión</span>
                                </a>
                            </form>
                        </div>
                    </div>
                </li>
            </ul>
        </header>
    </div>