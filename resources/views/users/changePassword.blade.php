<form method="POST" action="{{ route('users.setNewPassword', $user->id) }}">
    @csrf
    @method('PUT')


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <div class="p-0 mb-0 bg-dark-subtle" style="min-height: 100vh;">
    <div class="nav-item theme-text d-flex align-items-center">
        <img src="{{ Vite::asset('resources/images/logo.svg') }}" class="navbar-logo logo-light" alt="logo" style="width: 100px; height: auto;">
        <a href="{{ getRouterValue() }}/dashboard" class="nav-link fw-bold">VALORA</a>
    </div>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-dark text-white text-center">
                        <h4>Cambiar Contraseña</h4>
                    </div>
                    <div class="card-body">
                        <!-- Mostrar Errores -->
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Mostrar Mensaje de Éxito -->
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <!-- Contraseña Actual -->
                        <div class="form-group mb-3">
                            <label for="current_password" class="form-label">Contraseña Actual</label>
                            <input 
                                type="password" 
                                id="current_password" 
                                name="current_password" 
                                class="form-control" 
                                placeholder="Ingresa tu contraseña actual" 
                                required>
                        </div>

                        <!-- Nueva Contraseña -->
                        <div class="form-group mb-3">
                            <label for="new_password" class="form-label">Nueva Contraseña</label>
                            <input 
                                type="password" 
                                id="new_password" 
                                name="new_password" 
                                class="form-control" 
                                placeholder="Ingresa tu nueva contraseña" 
                                required>
                        </div>

                        <!-- Confirmar Nueva Contraseña -->
                        <div class="form-group mb-3">
                            <label for="new_password_confirmation" class="form-label">Confirmar Nueva Contraseña</label>
                            <input 
                                type="password" 
                                id="new_password_confirmation" 
                                name="new_password_confirmation" 
                                class="form-control" 
                                placeholder="Confirma tu nueva contraseña" 
                                required>
                        </div>

                        <!-- Botón de Enviar -->
                        <div class="d-grid">
                            <button type="submit" class="btn btn-dark">Cambiar Contraseña</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</form>