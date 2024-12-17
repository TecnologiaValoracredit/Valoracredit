{{-- 

/**
*
* Created a new component <x-base-layout/>.
* 
*/

--}}

@php
    $isBoxed = layoutConfig()['boxed'];
    $isAltMenu = layoutConfig()['alt-menu']; 
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <meta name="app-url" content="{{env('APP_URL')}}">
    <meta name="csrf-token" content="{{csrf_token()}}">

    <title>{{ $pageTitle }}</title>
    <link rel="icon" type="image/x-icon" href="{{Vite::asset('resources/images/favicon.ico')}}"/>

    @vite(['resources/scss/layouts/modern-light-menu/light/loader.scss'])

    @vite(['resources/layouts/modern-light-menu/loader.js'])
    
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{asset('plugins/bootstrap/bootstrap.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('plugins/table/datatable/datatables.css')}}">
    <link rel="stylesheet" href="{{asset('plugins/sweetalerts2/sweetalerts2.css')}}">
    @vite(['resources/scss/light/plugins/sweetalerts2/custom-sweetalert.scss'])
    <link rel="stylesheet" href="{{asset('plugins/notification/snackbar/snackbar.min.css')}}">
    @vite(['resources/scss/light/plugins/notification/snackbar/custom-snackbar.scss'])
    @vite(['resources/scss/light/assets/elements/alert.scss'])
        
    @vite(['resources/scss/light/assets/main.scss'])

    @if (
            !Request::routeIs('404') &&
            !Request::routeIs('maintenance') &&
            !Request::routeIs('signin') &&
            !Request::routeIs('signup') &&
            !Request::routeIs('lockscreen') &&
            !Request::routeIs('password-reset') &&
            !Request::routeIs('2Step') &&

            // Real Logins
            !Request::routeIs('login')
        )
        @if ($scrollspy == 1) @vite(['resources/scss/light/assets/scrollspyNav.scss']) @endif
        <link rel="stylesheet" type="text/css" href="{{asset('plugins/waves/waves.min.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('plugins/highlight/styles/monokai-sublime.css')}}">
        @vite([ 'resources/scss/light/plugins/perfect-scrollbar/perfect-scrollbar.scss'])

        @vite([
            'resources/scss/layouts/modern-light-menu/light/structure.scss',
        ])
        
    @endif
    
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    {{$headerFiles}}
    <!-- END GLOBAL MANDATORY STYLES -->
</head>
<body @class([
        // 'layout-dark' => $isDark,
        'layout-boxed' => $isBoxed,
        'alt-menu' => ($isAltMenu || Request::routeIs('collapsibleMenu') ? true : false),
        'error' => (Request::routeIs('404') ? true : false),
        'maintanence' => (Request::routeIs('maintenance') ? true : false),
    ]) @if ($scrollspy == 1) {{ $scrollspyConfig }} @else {{''}} @endif   @if (Request::routeIs('fullWidth')) layout="full-width"  @endif >

    <!-- BEGIN LOADER -->
    <x-layout-loader/>
    <!--  END LOADER -->
    <script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('plugins/table/datatable/datatables.js')}}"></script>
    <script src="{{asset('plugins/table/datatable/button-ext/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('plugins/table/datatable/button-ext/buttons.html5.min.js')}}"></script>
    <script src="{{asset('plugins/table/datatable/button-ext/buttons.print.min.js')}}"></script>
    <script src="{{asset('plugins/table/datatable/dt-custom-setting.js')}}"></script>
    <script src="{{asset('plugins/sweetalerts2/sweetalerts2.min.js')}}"></script>
    {{--
        
    /*
    *
    *   Check if the routes are not single pages ( which does not contains sidebar or topbar  ) such as :-
    *   - 404
    *   - maintenance
    *   - authentication
    *
    */

    --}}
        @if (
                !Request::routeIs('404') &&
                !Request::routeIs('maintenance') &&
                !Request::routeIs('signin') &&
                !Request::routeIs('signup') &&
                !Request::routeIs('lockscreen') &&
                !Request::routeIs('password-reset') &&
                !Request::routeIs('2Step') &&
                !Request::routeIs('unauthorized') &&

                // Real Logins
                !Request::routeIs('login')
            )

            @if (auth()->user()->role->is_active && auth()->user()->is_active)


                <x-navbar.style-vertical-menu classes="{{($isBoxed ? 'container-xxl' : '')}}"/>

                <!--  BEGIN MAIN CONTAINER  -->
                <div class="main-container " id="container">
                    <x-layout-overlay/>
                    <x-menu.vertical-menu/>
                    
                    
                    <!--  BEGIN CONTENT AREA  -->
                    <div id="content" class="main-content {{(Request::routeIs('blank') ? 'ms-0 mt-0' : '')}}">
                        @if ($scrollspy == 1)
                            <div class="container">
                                <div class="container">
                                    {{ $slot }}
                                </div>
                            </div>                
                        @else
                            <div class="layout-px-spacing">
                                <div class="middle-content {{($isBoxed ? 'container-xxl' : '')}} p-0">
                                    {{ $slot }}
                                </div>
                            </div>
                        @endif

                        <!--  BEGIN FOOTER  -->
                        <x-layout-footer/>
                        <!--  END FOOTER  -->
                        
                    </div>
                    <!--  END CONTENT AREA  -->

                </div>
                <!--  END MAIN CONTAINER  -->
            @else
                <div class="mt-4">
                    <p class="text-center text-danger">
                        Hola, {{auth()->user()->name}}. Su usuario fue desactivado temporalmente por un administrador.
                    </p>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-flex justify-content-center">
                        @csrf
                        <button class="btn btn-dark" type="submit">Cerrar sesión</button>
                    </form>
                </div>
            @endif
        @else
            {{ $slot }}
        @endif

        @if (
                !Request::routeIs('404') &&
                !Request::routeIs('maintenance') &&
                !Request::routeIs('signin') &&
                !Request::routeIs('signup') &&
                !Request::routeIs('lockscreen') &&
                !Request::routeIs('password-reset') &&
                !Request::routeIs('2Step') &&

                // Real Logins
                !Request::routeIs('login')
            )
            <!-- BEGIN GLOBAL MANDATORY STYLES -->
            <script src="{{asset('plugins/bootstrap/bootstrap.bundle.min.js')}}"></script>
            <script src="{{asset('plugins/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>
            <script src="{{asset('plugins/mousetrap/mousetrap.min.js')}}"></script>
            <script src="{{asset('plugins/waves/waves.min.js')}}"></script>
            <script src="{{asset('plugins/highlight/highlight.pack.js')}}"></script>
            <script src="{{asset('plugins/notification/snackbar/snackbar.min.js')}}"></script>

            @vite(['resources/js/validations.js'])
            @vite(['resources/js/alerts.js'])
            

            @if ($scrollspy == 1) @vite(['resources/assets/js/scrollspyNav.js']) @endif

        
            @vite(['resources/layouts/modern-light-menu/app.js'])
            <!-- END GLOBAL MANDATORY STYLES -->

        @endif
    {{$footerFiles}}
</body>
</html>