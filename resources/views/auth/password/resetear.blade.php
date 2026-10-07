@extends('layouts.template')

@section('contentLogin')
    <div class="ugelaa-split">

        {{-- Left Panel --}}
        <div class="ugelaa-panel-left" style="background-image: url({{ url('storage/images/bg-52.jpeg') }})">
            <div class="ugelaa-panel-logo">
                <img src="{{ url('storage/images/LOGO_UGELAA.png') }}" alt="UGEL Alto Amazonas" />
            </div>
            <div class="ugelaa-panel-branding">
                <h2>Nueva Contraseña</h2>
                <p>UGEL Alto Amazonas — Establezca una nueva contraseña para su cuenta.</p>
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

                <div class="ugelaa-form-header">
                    <h1>Establecer Nueva Contraseña</h1>
                    <p>Ingrese y confirme su nueva contraseña para la cuenta asociada a <strong>{{ $correo }}</strong></p>
                </div>

                {{-- Formulario de reset --}}
                <form class="ugelaa-form" id="formReset" autocomplete="off">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}" />

                    <div class="ugelaa-input-group">
                        <label class="ugelaa-input-label" for="reset_password">Nueva Contraseña</label>
                        <div class="ugelaa-input-wrap">
                            <svg class="ugelaa-input-icon" xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
                                <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                            </svg>
                            <input type="password" class="ugelaa-input" id="reset_password" name="password"
                                placeholder="Mínimo 6 caracteres" required />
                            <button type="button" class="ugelaa-pw-toggle" onclick="togglePasswordReset('reset_password', this)">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                    <circle cx="12" cy="12" r="3" />
                                </svg>
                            </button>
                        </div>
                        <div class="ugelaa-input-error" id="error_reset_password"></div>
                    </div>

                    <div class="ugelaa-input-group">
                        <label class="ugelaa-input-label" for="reset_password_confirmation">Confirmar Nueva Contraseña</label>
                        <div class="ugelaa-input-wrap">
                            <svg class="ugelaa-input-icon" xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
                                <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                            </svg>
                            <input type="password" class="ugelaa-input" id="reset_password_confirmation"
                                name="password_confirmation" placeholder="Repita la nueva contraseña" required />
                            <button type="button" class="ugelaa-pw-toggle"
                                onclick="togglePasswordReset('reset_password_confirmation', this)">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                    <circle cx="12" cy="12" r="3" />
                                </svg>
                            </button>
                        </div>
                        <div class="ugelaa-input-error" id="error_reset_password_confirmation"></div>
                        {{-- Indicador de coincidencia --}}
                        <div class="ugelaa-password-match" id="resetPasswordMatch" style="display: none;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                                <polyline points="22 4 12 14.01 9 11.01" />
                            </svg>
                            <span>Las contraseñas coinciden</span>
                        </div>
                    </div>

                    {{-- Alertas --}}
                    <div id="alertaReset" class="ugelaa-alert" style="display: none;"></div>

                    <div class="ugelaa-btn-wrapper">
                        <button type="submit" id="btnResetear" class="ugelaa-btn-submit">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
                                <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                            </svg>
                            <span class="indicator-label">Cambiar Contraseña</span>
                            <span class="indicator-progress" style="display: none;">Guardando...
                                <span class="ugelaa-spinner" style="display: inline-block;"></span>
                            </span>
                        </button>
                    </div>
                </form>

                {{-- Links --}}
                <div class="ugelaa-auth-links">
                    <a href="{{ url('login') }}" class="ugelaa-auth-link">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <line x1="19" y1="12" x2="5" y2="12" />
                            <polyline points="12 19 5 12 12 5" />
                        </svg>
                        Volver a Iniciar Sesión
                    </a>
                </div>

            </div>

            <div class="ugelaa-right-footer">
                <p>Sistema de Trámite Documentario — UGEL Alto Amazonas</p>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const formReset = document.getElementById('formReset');
    const passInput = document.getElementById('reset_password');
    const passConfirm = document.getElementById('reset_password_confirmation');
    const matchIndicator = document.getElementById('resetPasswordMatch');

    // Verificar coincidencia en tiempo real
    function checkPasswords() {
        if (passInput.value && passConfirm.value) {
            if (passInput.value === passConfirm.value) {
                matchIndicator.style.display = 'flex';
                matchIndicator.classList.remove('ugelaa-password-match--error');
                matchIndicator.classList.add('ugelaa-password-match--success');
                matchIndicator.querySelector('span').textContent = 'Las contraseñas coinciden';
            } else {
                matchIndicator.style.display = 'flex';
                matchIndicator.classList.remove('ugelaa-password-match--success');
                matchIndicator.classList.add('ugelaa-password-match--error');
                matchIndicator.querySelector('span').textContent = 'Las contraseñas no coinciden';
            }
        } else {
            matchIndicator.style.display = 'none';
        }
    }

    passInput.addEventListener('input', checkPasswords);
    passConfirm.addEventListener('input', checkPasswords);

    // Submit
    formReset.addEventListener('submit', function(e) {
        e.preventDefault();

        const btn = document.getElementById('btnResetear');
        const alerta = document.getElementById('alertaReset');

        alerta.style.display = 'none';
        document.querySelectorAll('.ugelaa-input-error').forEach(el => el.textContent = '');
        document.querySelectorAll('.ugelaa-input').forEach(el => el.classList.remove('is-invalid'));

        btn.querySelector('.indicator-label').style.display = 'none';
        btn.querySelector('.indicator-progress').style.display = 'inline-flex';
        btn.disabled = true;

        const formData = new FormData(formReset);

        axios.post('/reset-password', formData)
            .then(function(response) {
                if (response.data.success) {
                    alerta.className = 'ugelaa-alert ugelaa-alert--success';
                    alerta.innerHTML = '<strong>¡Contraseña actualizada!</strong> ' + response.data.message + ' Redirigiendo...';
                    alerta.style.display = 'block';

                    // Redirect to login after 2 seconds
                    setTimeout(function() {
                        window.location.href = response.data.ruta || '/login';
                    }, 2000);
                }
            })
            .catch(function(error) {
                const resp = error.response;

                if (resp && resp.data) {
                    if (resp.data.errores) {
                        Object.entries(resp.data.errores).forEach(function([campo, mensajes]) {
                            const input = formReset.querySelector('[name="' + campo + '"]');
                            if (input) input.classList.add('is-invalid');

                            const errorDiv = document.getElementById('error_reset_' + campo);
                            if (errorDiv) errorDiv.innerHTML = mensajes[0];
                        });
                    }

                    if (resp.data.message) {
                        alerta.className = 'ugelaa-alert ugelaa-alert--danger';
                        alerta.textContent = resp.data.message;
                        alerta.style.display = 'block';
                    }
                }
            })
            .finally(function() {
                btn.querySelector('.indicator-label').style.display = 'inline';
                btn.querySelector('.indicator-progress').style.display = 'none';
                btn.disabled = false;
            });
    });
});

function togglePasswordReset(inputId, btn) {
    const input = document.getElementById(inputId);
    if (input.type === 'password') {
        input.type = 'text';
        btn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>';
    } else {
        input.type = 'password';
        btn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>';
    }
}
</script>
@endsection
