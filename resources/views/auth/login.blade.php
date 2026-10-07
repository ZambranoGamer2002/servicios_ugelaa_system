@extends('layouts.template')

@section('contentLogin')
    <div class="ugelaa-split">

        <!--begin::Left Panel (Blue Branding)-->
        <div class="ugelaa-panel-left" style="background-image: url({{ url('storage/images/bg-52.jpeg') }})">

            <!--begin::Logo-->
            <div class="ugelaa-panel-logo">
                <img src="{{ url('storage/images/LOGO_UGELAA.png') }}" alt="UGEL Alto Amazonas" />
            </div>
            <!--end::Logo-->

            <!--begin::Branding Text-->
            <div class="ugelaa-panel-branding">
                <h2>Sistema de Trámite</h2>
                <p>UGEL Alto Amazonas — Portal para el registro, seguimiento y gestión de trámites documentarios.</p>
            </div>
            <!--end::Branding Text-->

            <!--begin::Footer-->
            <div class="ugelaa-panel-footer">
                <p class="ugelaa-panel-footer-copy">&copy; 2026 UGEL Alto Amazonas</p>
                <div class="ugelaa-panel-footer-links">
                    <a href="#">Soporte</a>
                    <a href="#">Legal</a>
                    <a href="#">Contacto</a>
                </div>
            </div>
            <!--end::Footer-->

        </div>
        <!--end::Left Panel-->

        <!--begin::Right Panel (Form Area)-->
        <div class="ugelaa-panel-right">

            <!--begin::Form Container-->
            <div class="ugelaa-form-container">

                <!--begin::Header-->
                <div class="ugelaa-form-header">
                    <h1>Iniciar Sesión</h1>
                    <p>Ingresa tus credenciales para acceder al sistema</p>
                </div>
                <!--end::Header-->

                <!--begin::Alert status-->
                @if(session('status'))
                    <div class="ugelaa-alert ugelaa-alert--danger" style="margin-bottom: 18px;">
                        {{ session('status') }}
                    </div>
                @endif
                <!--end::Alert status-->

                <!--begin::Form-->
                <form class="ugelaa-form" method="POST" action="{{ route('login') }}">
                    @csrf
                    <!--begin::Usuario Input-->
                    <div class="ugelaa-input-group">
                        <label class="ugelaa-input-label" for="ugelaa_usuario">Usuario</label>
                        <div class="ugelaa-input-wrap">
                            <svg class="ugelaa-input-icon" xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                            <input type="text" class="ugelaa-input" id="nickname" name="nickname"
                                placeholder="Ingresa tu usuario" autocomplete="off" required />
                        </div>
                    </div>
                    <!--end::Usuario Input-->

                    <!--begin::Contraseña Input-->
                    <div class="ugelaa-input-group">
                        <label class="ugelaa-input-label" for="ugelaa_password">Contraseña</label>
                        <div class="ugelaa-input-wrap">
                            <svg class="ugelaa-input-icon" xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                            </svg>
                            <input type="password" class="ugelaa-input" id="password" name="password"
                                placeholder="Ingresa tu contraseña" autocomplete="off" required />
                            <button type="button" class="ugelaa-pw-toggle" id="ugelaa_pw_toggle"
                                aria-label="Mostrar contraseña">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" id="ugelaa_eye_icon">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <!--end::Contraseña Input-->

                    <!--begin::Forgot Password Link-->
                    <div class="ugelaa-forgot-link-wrapper">
                        <a href="{{ url('recuperar-password') }}" class="ugelaa-forgot-link">¿Olvidaste tu contraseña?</a>
                    </div>
                    <!--end::Forgot Password Link-->

                    <!--begin::Submit Button-->
                    <div class="ugelaa-btn-wrapper">
                        <button type="submit" id="kt_sign_in_submit" class="ugelaa-btn-submit">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path>
                                <polyline points="10 17 15 12 10 7"></polyline>
                                <line x1="15" y1="12" x2="3" y2="12"></line>
                            </svg>
                            <span class="indicator-label">Ingresar</span>
                            <span class="indicator-progress" style="display: none;">Verificando...
                                <span class="ugelaa-spinner" style="display: inline-block;"></span>
                            </span>
                        </button>
                    </div>
                    <!--end::Submit Button-->

                </form>
                <!--end::Form-->

                <!--begin::Register Link-->
                <div class="ugelaa-auth-links ugelaa-auth-links--center">
                    <span class="ugelaa-auth-text">¿No tienes cuenta?</span>
                    <a href="{{ url('registro') }}" class="ugelaa-auth-link ugelaa-auth-link--primary">
                        Registrarse
                    </a>
                </div>
                <!--end::Register Link-->

            </div>
            <!--end::Form Container-->

            <!--begin::Right Footer-->
            <div class="ugelaa-right-footer">
                <p>Sistema de Trámite Documentario — UGEL Alto Amazonas</p>
            </div>
            <!--end::Right Footer-->

        </div>
        <!--end::Right Panel-->

    </div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const toggleBtn = document.getElementById('ugelaa_pw_toggle');
    const pwInput = document.getElementById('password');

    if (toggleBtn && pwInput) {
        toggleBtn.addEventListener('click', function() {
            if (pwInput.type === 'password') {
                pwInput.type = 'text';
                toggleBtn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>';
            } else {
                pwInput.type = 'password';
                toggleBtn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>';
            }
        });
    }

    const form = document.querySelector('.ugelaa-form');
    if (form) {
        form.addEventListener('submit', function() {
            const btn = document.getElementById('kt_sign_in_submit');
            if (btn) {
                const label = btn.querySelector('.indicator-label');
                const progress = btn.querySelector('.indicator-progress');
                if (label) label.style.display = 'none';
                if (progress) progress.style.display = 'inline-flex';
            }
        });
    }
});
</script>
@endsection

