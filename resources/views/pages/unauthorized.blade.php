
<!-- resources/views/pages/page/unauthorized.blade.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    
    <meta charset="UTF-8">
    <title>{{ $title }}</title>
</head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<div class="p-0 mb-0 bg-dark-subtle" style="min-height: 100vh;">
<body>
    <div class="nav-item theme-text d-flex align-items-center">
        <img src="{{ Vite::asset('resources/images/logo.svg') }}" class="navbar-logo logo-light" alt="logo" style="width: 100px; height: auto;">
        <a href="{{ getRouterValue() }}/dashboard" class="nav-link fw-bold">VALORA</a>
    </div>
    
    <div class = "container mt-5">
        <div class = "row justify-content-center">
            <div class= "col-md-4">
            <div class="card">
                <div class="card-header bg-danger">
                    <h4> Error: No cuenta con los permisos</h4>
                    
                    <div class="card-body bg-light">
                        <h6> No tiene los permisos necesarios para acceder a esta página, favor de contactar con algun administrador </h6>
                        <a href="{{route('dashboard.index')}}" class="btn btn-dark">Volver al inicio</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</body>
</html>
