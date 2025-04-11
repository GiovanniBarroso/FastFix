@extends('layouts.app')
@section('title', 'Verificar Correo Electrónico')

@section('content')
    <div class="container mb-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <!-- 🟠 Tarjeta de Verificación de Email -->
                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-header bg-warning text-dark fw-bold text-center fs-4 rounded-top-4">
                        <i class="fas fa-envelope"></i> Verificación de Correo Electrónico
                    </div>

                    <div class="card-body text-center p-4">
                        <!-- ✅ Mensaje de éxito si se reenvía el correo -->
                        @if (session('resent'))
                            <div class="alert alert-success animate__animated animate__fadeIn">
                                <i class="fas fa-check-circle"></i> Un nuevo enlace de verificación ha sido enviado a tu
                                correo.
                            </div>
                        @endif

                        <!-- 📩 Mensaje Principal -->
                        <p class="fs-5 text-muted">
                            Antes de continuar, revisa tu correo electrónico para confirmar tu cuenta.
                        </p>

                        <p class="text-muted">
                            Si no recibiste el correo, puedes solicitar otro haciendo clic en el botón a continuación.
                        </p>

                        <!-- 🟡 Formulario para reenviar verificación -->
                        <form class="d-inline" method="POST" action="{{ route('verification.send') }}">
                            @csrf
                            <button type="submit"
                                class="btn btn-warning text-dark fw-bold px-4 py-2 rounded-pill shadow-sm btn-resend">
                                <i class="fas fa-paper-plane"></i> Reenviar Verificación
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 🌟 Estilos Personalizados -->
    <style>
        .btn-resend {
            transition: all 0.3s ease-in-out;
        }

        .btn-resend:hover {
            background: linear-gradient(135deg, #ff9800, #ff5722);
            color: white;
            transform: scale(1.05);
        }
    </style>
@endsection
