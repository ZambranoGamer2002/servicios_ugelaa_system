@extends('layouts.template')

@section('contentLogin')
    <div class="ugelaa-split">
        {{-- Left Panel --}}
        <div class="ugelaa-panel-left" style="background-image: url({{ url('storage/images/bg-52.jpeg') }})">
            <div class="ugelaa-panel-logo">
                <img src="{{ url('storage/images/LOGO_UGELAA.png') }}" alt="UGEL Alto Amazonas" />
            </div>
            <div class="ugelaa-panel-branding">
                <h2>Verificación Requerida</h2>
                <p>UGEL Alto Amazonas — Para acceder al sistema, primero debe verificar su correo electrónico.</p>
            </div>
        </div>

        {{-- Right Panel --}}
        <div class="ugelaa-panel-right">
            <div class="ugelaa-form-container">
                <div class="ugelaa-form-header text-center">
                    <h1>Verifique su Correo Electrónico</h1>
                    <p>Se requiere verificación para continuar.</p>
                </div>

                @if (session('resent'))
                    <div class="ugelaa-alert ugelaa-alert--success">
                        Se ha enviado un nuevo enlace de verificación a su correo.
                    </div>
                @endif

                <p style="color: #6c757d; font-size: 15px; margin-bottom: 20px; line-height: 1.5;">
                    Antes de continuar, por favor revise su correo por el enlace de verificación. (Tiene 10 minutos antes de que el enlace expire).
                    Si no recibió el correo, puede solicitar otro enlace usando el botón de abajo.
                </p>

                <form class="ugelaa-form" method="POST" action="{{ route('verification.resend') }}">
                    @csrf
                    <div class="ugelaa-btn-wrapper">
                        <button type="submit" class="ugelaa-btn-submit" style="width: 100%;">
                            Haga clic aquí para solicitar otro enlace
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
