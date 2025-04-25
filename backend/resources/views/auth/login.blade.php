@extends('layouts.app')
@section('title', 'Iniciar Sesión')

@section('content')
    <div class="container mb-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <!-- 🟠 Tarjeta de Inicio de Sesión -->
                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-header bg-warning text-dark fw-bold text-center fs-4 rounded-top-4">
                        <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
                    </div>

                    <div class="card-body p-4">
                        <!-- ✅ Mensaje de error o estado -->
                        @if (session('status'))
                            <div class="alert alert-warning text-center animate__animated animate__fadeIn">
                                <i class="fas fa-exclamation-triangle"></i> {{ session('status') }}
                            </div>
                        @endif

                        <!-- 🔑 Formulario de Login -->
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <!-- 📌 Email -->
                            <div class="mb-4">
                                <label for="email" class="form-label fw-semibold text-brown">
                                    <i class="fas fa-envelope"></i> Correo Electrónico
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-secondary">
                                        <i class="fas fa-envelope"></i>
                                    </span>
                                    <input id="email" type="email"
                                        class="form-control custom-input @error('email') is-invalid @enderror"
                                        name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- 📌 Contraseña -->
                            <div class="mb-4">
                                <label for="password" class="form-label fw-semibold text-brown">
                                    <i class="fas fa-lock"></i> Contraseña
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-secondary">
                                        <i class="fas fa-key"></i>
                                    </span>
                                    <input id="password" type="password"
                                        class="form-control custom-input @error('password') is-invalid @enderror"
                                        name="password" required autocomplete="current-password">
                                    <button type="button" class="btn btn-outline-secondary toggle-password"
                                        data-target="password">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- 📌 Recuérdame (ALINEADO) -->
                            <div class="mb-4 text-center">
                                <div class="form-check d-flex align-items-center justify-content-center">
                                    <input class="form-check-input me-2" type="checkbox" name="remember" id="remember"
                                        {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label fw-semibold" for="remember">
                                        <i class="fas fa-user-check"></i> Recordarme
                                    </label>
                                </div>
                            </div>

                            <!-- 🟡 Botones de Login y Registro alineados -->
                            <div class="d-flex justify-content-center gap-3 mt-3">
                                <!-- 🔹 Botón de Registro (izquierda) -->
                                <a href="{{ route('register') }}"
                                    class="btn btn-outline-dark fw-bold px-4 py-2 rounded-pill shadow-sm">
                                    <i class="fas fa-user-plus"></i> Registrarse
                                </a>

                                <!-- 🟡 Botón de Login (derecha) -->
                                <button type="submit"
                                    class="btn btn-warning text-dark fw-bold px-4 py-2 rounded-pill shadow-sm btn-login">
                                    <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
                                </button>
                            </div>



                            <!-- 🔗 Olvidé mi contraseña -->
                            @if (Route::has('password.request'))
                                <div class="text-center mt-3">
                                    <a class="text-decoration-none text-brown fw-bold"
                                        href="{{ route('password.request') }}">
                                        <i class="fas fa-key"></i> ¿Olvidaste tu contraseña?
                                    </a>
                                </div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 🌟 Estilos Personalizados -->
    <style>
        .custom-input {
            background: #fff;
            border: 2px solid #ced4da;
            border-radius: 10px;
            padding: 12px;
            transition: all 0.3s ease-in-out;
        }

        .custom-input:focus {
            border-color: #ff9800;
            box-shadow: 0 0 10px rgba(255, 152, 0, 0.5);
            outline: none;
        }

        .btn-login {
            transition: all 0.3s ease-in-out;
        }

        .btn-login:hover {
            background: linear-gradient(135deg, #ff9800, #ff5722);
            color: white;
            transform: scale(1.05);
        }

        .form-check-input {
            width: 1.2rem;
            height: 1.2rem;
        }

        .form-check-label {
            font-size: 1rem;
            margin-top: 2px;
        }
    </style>

    <!-- 🟢 Script para Mostrar/Ocultar Contraseña -->
    <script>
        document.querySelectorAll('.toggle-password').forEach(button => {
            button.addEventListener('click', function() {
                const input = document.getElementById(this.dataset.target);
                if (input.type === "password") {
                    input.type = "text";
                    this.innerHTML = '<i class="fas fa-eye-slash"></i>';
                } else {
                    input.type = "password";
                    this.innerHTML = '<i class="fas fa-eye"></i>';
                }
            });
        });
    </script>
@endsection
