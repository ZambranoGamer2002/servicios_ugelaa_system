@extends('layouts.template')

@section('contentLogin')
    <div class="ugelaa-split">

        {{-- Left Panel --}}
        <div class="ugelaa-panel-left" style="background-image: url({{ url('storage/images/bg-52.jpeg') }})">
            <div class="ugelaa-panel-logo">
                <img src="{{ url('storage/images/LOGO_UGELAA.png') }}" alt="UGEL Alto Amazonas" />
            </div>
            <div class="ugelaa-panel-branding">
                <h2>Recuperar Contraseña</h2>
                <p>UGEL Alto Amazonas — Restablezca su acceso al sistema de trámite documentario.</p>
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
                    <h1>Recuperar Contraseña</h1>
                    <p>Ingrese su correo electrónico registrado y le enviaremos un enlace para restablecer su contraseña</p>
                </div>

                {{-- Formulario --}}
                <form class="ugelaa-form" id="formRecuperar" autocomplete="off">
                    @csrf

                    <div class="ugelaa-input-group">
                        <label class="ugelaa-input-label" for="rec_correo">Correo Electrónico</label>
                        <div class="ugelaa-input-wrap">
                            <svg class="ugelaa-input-icon" xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                                <polyline points="22,6 12,13 2,6" />
                            </svg>
                            <input type="email" class="ugelaa-input" id="rec_correo" name="correo"
                                placeholder="ejemplo@correo.com" required />
                        </div>
                        <div class="ugelaa-input-error" id="error_rec_correo"></div>
                    </div>

                    {{-- Alertas --}}
                    <div id="alertaRecuperar" class="ugelaa-alert" style="display: none;"></div>

                    <div class="ugelaa-btn-wrapper">
                        <button type="submit" id="btnEnviarRecuperar" class="ugelaa-btn-submit">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <line x1="22" y1="2" x2="11" y2="13" />
                                <polygon points="22 2 15 22 11 13 2 9 22 2" />
                            </svg>
                            <span class="indicator-label">Enviar Enlace de Recuperación</span>
                            <span class="indicator-progress" style="display: none;">Enviando...
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
    const formRecuperar = document.getElementById('formRecuperar');

    formRecuperar.addEventListener('submit', function(e) {
        e.preventDefault();

        const btn = document.getElementById('btnEnviarRecuperar');
        const alerta = document.getElementById('alertaRecuperar');
        const errorCorreo = document.getElementById('error_rec_correo');

        alerta.style.display = 'none';
        errorCorreo.textContent = '';
        document.getElementById('rec_correo').classList.remove('is-invalid');

        btn.querySelector('.indicator-label').style.display = 'none';
        btn.querySelector('.indicator-progress').style.display = 'inline-flex';
        btn.disabled = true;

        const formData = new FormData(formRecuperar);

        axios.post('/recuperar-password', formData)
            .then(function(response) {
                if (response.data.success) {
                    alerta.className = 'ugelaa-alert ugelaa-alert--success';
                    alerta.innerHTML = '<strong>¡Enlace enviado!</strong> ' + response.data.message;
                    alerta.style.display = 'block';

                    // Deshabilitar el formulario
                    document.getElementById('rec_correo').readOnly = true;
                    btn.style.display = 'none';
                }
            })
            .catch(function(error) {
                const resp = error.response;

                if (resp && resp.data) {
                    if (resp.data.errores && resp.data.errores.correo) {
                        document.getElementById('rec_correo').classList.add('is-invalid');
                        errorCorreo.innerHTML = resp.data.errores.correo[0];
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
</script>
@endsection
