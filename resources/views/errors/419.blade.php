<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width:device-width, initial-scale=1">
    <title>Sesión expirada</title>
</head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<div class="p-0 mb-0 bg-dark-subtle" style="min-height: 100vh;">
<body>
    <div class="nav-item theme-text d-flex align-items-center">
        <img src="{{ Vite::asset('resources/images/logo.svg') }}" class="navbar-logo logo-light" alt="logo" style="width: 100px; height: auto;">
        <a href="{{ getRouterValue() }}/dashboard" class="nav-link fw-bold">VALORA</a>
    </div>

    <div class="container mt-5 text-center">
        <div class = "row justify-content-center">
            <div class= "col-md-8">
            <div class="card">
                <div class="card-header bg-warning fw-bolder">
                    <h2 class="mt-1 mb-3">Error: La sesión ha expirado</h2>
                    
                    <div class="card-body bg-light">
                        <h6 class="mb-4 mt-4">La sesión ha expirado despues de un tiempo de inactividad, inicie sesión de nuevo por favor.</h6>
                        <a href="{{route('dashboard.index')}}" class="btn btn-dark">Volver al inicio</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</body>
</html>
