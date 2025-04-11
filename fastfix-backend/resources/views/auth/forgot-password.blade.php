@extends('layouts.app')
@section('title', 'Recuperar Contraseña')

@section('content')
    <div class="container mb-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <!-- 🟠 Tarjeta de Restablecimiento -->
                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-header bg-warning text-dark fw-bold text-center fs-4 rounded-top-4">
                        <i class="fas fa-key"></i> Recupera tu Acceso
                    </div>

                    <div class="card-body p-4">
                        <!-- ✅ Mensaje de Enlace Enviado -->
                        @if (session('status'))
                            <div class="alert alert-success text-center animate__animated animate__fadeIn">
                                <i class="fas fa-envelope"></i> {{ session('status') }}
                            </div>
                        @endif

                        <p class="text-center text-muted fs-5">
                            ¿Olvidaste tu contraseña? No hay problema. Ingresa tu correo y te enviaremos un enlace
                            para que puedas restablecerla.
                        </p>

                        <!-- 🔑 Formulario de Restablecimiento -->
                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf

                            <!-- 📧 Correo Electrónico -->
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

                            <!-- 🔘 Botón de Enviar -->
                            <div class="text-center">
                                <button type="submit"
                                    class="btn btn-warning text-dark fw-bold px-4 py-2 rounded-pill shadow-sm btn-reset">
                                    <i class="fas fa-paper-plane"></i> Enviar Enlace
                                </button>
                            </div>

                            <!-- 🔗 Volver al Login -->
                            <div class="text-center mt-3">
                                <a class="text-decoration-none text-brown fw-bold" href="{{ route('login') }}">
                                    <i class="fas fa-arrow-left"></i> Volver al Inicio de Sesión
                                </a>
                            </div>
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

        .btn-reset {
            transition: all 0.3s ease-in-out;
        }

        .btn-reset:hover {
            background: linear-gradient(135deg, #ff9800, #ff5722);
            color: white;
            transform: scale(1.05);
        }
    </style>
@endsection
