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

                {{-- Icono de error --}}
                <div class="ugelaa-result-icon ugelaa-result-icon--error">
                    <svg xmlns="http://www.w3.org/2000/svg" width="56" height="56" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                        stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10" />
                        <line x1="15" y1="9" x2="9" y2="15" />
                        <line x1="9" y1="9" x2="15" y2="15" />
                    </svg>
                </div>

                <div class="ugelaa-form-header">
                    <h1>{{ $titulo }}</h1>
                    <p>{{ $mensaje }}</p>
                </div>

                <div class="ugelaa-btn-wrapper" style="display: flex; flex-direction: column; gap: 12px;">
                    <a href="{{ url('registro') }}" class="ugelaa-btn-submit" style="text-decoration: none; text-align: center;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                            <circle cx="8.5" cy="7" r="4" />
                            <line x1="20" y1="8" x2="20" y2="14" />
                            <line x1="23" y1="11" x2="17" y2="11" />
                        </svg>
                        <span>Registrarse Nuevamente</span>
                    </a>
                    <a href="{{ url('login') }}" class="ugelaa-btn-submit ugelaa-btn-submit--outline" style="text-decoration: none; text-align: center;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <line x1="19" y1="12" x2="5" y2="12" />
                            <polyline points="12 19 5 12 12 5" />
                        </svg>
                        <span>Volver a Iniciar Sesión</span>
                    </a>
                </div>

            </div>

            <div class="ugelaa-right-footer">
                <p>Sistema de Trámite Documentario — UGEL Alto Amazonas</p>
            </div>
        </div>
    </div>
@endsection
