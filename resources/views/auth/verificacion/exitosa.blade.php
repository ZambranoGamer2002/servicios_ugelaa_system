@extends('layouts.template')

@section('contentLogin')
    <div class="ugelaa-split">

        {{-- Left Panel --}}
        <div class="ugelaa-panel-left" style="background-image: url({{ url('storage/images/bg-52.jpeg') }})">
            <div class="ugelaa-panel-logo">
                <img src="{{ url('storage/images/LOGO_UGELAA.png') }}" alt="UGEL Alto Amazonas" />
            </div>
            <div class="ugelaa-panel-branding">
                <h2>Sistema de Trámite</h2>
                <p>UGEL Alto Amazonas — Portal para el registro, seguimiento y gestión de trámites documentarios.</p>
            </div>
            <div class="ugelaa-panel-footer">
                <p class="ugelaa-panel-footer-copy">&copy; 2026 UGEL Alto Amazonas</p>
                <div class="ugelaa-panel-footer-links">
                    <a href="#">Soporte</a>
                    <a href="#">Legal</a>
                    <a href="#">Contacto</a>
                </div>
            </div>
        </div>

        {{-- Right Panel --}}
        <div class="ugelaa-panel-right">
            <div class="ugelaa-form-container">

                {{-- Icono de éxito --}}
                <div class="ugelaa-result-icon ugelaa-result-icon--success">
                    <svg xmlns="http://www.w3.org/2000/svg" width="56" height="56" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                        <polyline points="22 4 12 14.01 9 11.01" />
                    </svg>
                </div>

                <div class="ugelaa-form-header">
                    <h1>¡Registro Completado!</h1>
                    <p>Su cuenta ha sido verificada y creada exitosamente en el sistema de trámite documentario de la UGEL Alto Amazonas.</p>
                </div>

                <div class="ugelaa-result-details">
                    <div class="ugelaa-result-detail-item">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                            <polyline points="22 4 12 14.01 9 11.01" />
                        </svg>
                        <span>Email verificado correctamente</span>
                    </div>
                    <div class="ugelaa-result-detail-item">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                            <polyline points="22 4 12 14.01 9 11.01" />
                        </svg>
                        <span>Cuenta creada en el sistema</span>
                    </div>
                    <div class="ugelaa-result-detail-item">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                            <polyline points="22 4 12 14.01 9 11.01" />
                        </svg>
                        <span>Ya puede iniciar sesión</span>
                    </div>
                </div>

                <div class="ugelaa-btn-wrapper">
                    <a href="{{ url('login') }}" class="ugelaa-btn-submit" style="text-decoration: none; text-align: center;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4" />
                            <polyline points="10 17 15 12 10 7" />
                            <line x1="15" y1="12" x2="3" y2="12" />
                        </svg>
                        <span>Ir a Iniciar Sesión</span>
                    </a>
                </div>

            </div>

            <div class="ugelaa-right-footer">
                <p>Sistema de Trámite Documentario — UGEL Alto Amazonas</p>
            </div>
        </div>
    </div>
@endsection
