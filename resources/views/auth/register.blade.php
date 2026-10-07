@extends('layouts.template')

@section('contentLogin')
    <div class="ugelaa-split">

        {{-- Left Panel (Blue Branding) --}}
        <div class="ugelaa-panel-left" style="background-image: url({{ url('storage/images/bg-52.jpeg') }})">
            <div class="ugelaa-panel-logo">
                <img src="{{ url('storage/images/LOGO_UGELAA.png') }}" alt="UGEL Alto Amazonas" />
            </div>
            <div class="ugelaa-panel-branding">
                <h2>Registro de Usuario</h2>
                <p>UGEL Alto Amazonas — Crea tu cuenta para acceder al sistema de trámite documentario.</p>
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

        {{-- Right Panel (Form Area) --}}
        <div class="ugelaa-panel-right ugelaa-panel-right--registro">

            <div class="ugelaa-form-container ugelaa-form-container--registro">

                {{-- Header --}}
                <div class="ugelaa-form-header">
                    <h1>Crear Cuenta</h1>
                    <p>Complete los datos para registrarse en el sistema</p>
                </div>

                {{-- Formulario de registro --}}
                <form class="ugelaa-form" id="formRegistro" autocomplete="off">
                    @csrf

                    {{-- Paso 1: Búsqueda por DNI --}}
                    <div class="ugelaa-registro-step" id="stepDni">
                        <div class="ugelaa-step-badge">
                            <span class="ugelaa-step-num">1</span>
                            <span class="ugelaa-step-text">Consulta de DNI</span>
                        </div>

                        <div class="ugelaa-input-group">
                            <label class="ugelaa-input-label" for="reg_dni">N° de DNI</label>
                            <div class="ugelaa-input-wrap ugelaa-input-wrap--with-btn">
                                <svg class="ugelaa-input-icon" xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="2" y="4" width="20" height="16" rx="2" />
                                    <path d="M7 15h0M2 9.5h20" />
                                </svg>
                                <input type="text" class="ugelaa-input" id="reg_dni" name="dni"
                                    placeholder="Ingrese su DNI de 8 dígitos" maxlength="8"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')" required />
                                <button type="button" class="ugelaa-btn-buscar" id="btnBuscarDni">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <circle cx="11" cy="11" r="8" />
                                        <line x1="21" y1="21" x2="16.65" y2="16.65" />
                                    </svg>
                                    <span class="ugelaa-btn-buscar__text">Buscar</span>
                                    <span class="ugelaa-btn-buscar__loading" style="display:none;">
                                        <span class="ugelaa-spinner-sm"></span>
                                    </span>
                                </button>
                                <button type="button" class="ugelaa-btn-buscar" id="btnCambiarDni" style="display:none; background:#64748b;">
                                    <span>Cambiar</span>
                                </button>
                            </div>
                        </div>

                        {{-- Alerta de error DNI --}}
                        <div id="alertaDni" class="ugelaa-alert ugelaa-alert--danger" style="display: none;"></div>
                        <div id="avisoDni" class="ugelaa-alert ugelaa-alert--info" style="display: none; margin-top: 10px;"></div>
                    </div>

                    {{-- Datos autocompletados (aparecen tras buscar DNI) --}}
                    <div class="ugelaa-registro-step ugelaa-registro-step--hidden" id="stepDatos">
                        <div class="ugelaa-step-badge">
                            <span class="ugelaa-step-num">2</span>
                            <span class="ugelaa-step-text">Datos Personales</span>
                        </div>

                        {{-- Datos de RENIEC --}}
                        <div class="ugelaa-datos-reniec">
                            <div class="ugelaa-datos-reniec__badge">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                                    <polyline points="22 4 12 14.01 9 11.01" />
                                </svg>
                                Datos verificados por RENIEC
                            </div>

                            <div class="ugelaa-input-row">
                                <div class="ugelaa-input-group ugelaa-input-group--half">
                                    <label class="ugelaa-input-label">Apellidos</label>
                                    <input type="text" class="ugelaa-input" id="reg_apellidos"
                                        name="apellidos" placeholder="Apellidos" required />
                                </div>
                                <div class="ugelaa-input-group ugelaa-input-group--half">
                                    <label class="ugelaa-input-label">Nombres</label>
                                    <input type="text" class="ugelaa-input" id="reg_nombres"
                                        name="nombres" placeholder="Nombres" required />
                                </div>
                            </div>
                        </div>

                        {{-- Paso 3: Datos manuales --}}
                        <div class="ugelaa-step-badge" style="margin-top: 20px;">
                            <span class="ugelaa-step-num">3</span>
                            <span class="ugelaa-step-text">Datos de Acceso</span>
                        </div>

                        <div class="ugelaa-input-group">
                            <label class="ugelaa-input-label" for="reg_correo">Correo Electrónico</label>
                            <div class="ugelaa-input-wrap">
                                <svg class="ugelaa-input-icon" xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                                    <polyline points="22,6 12,13 2,6" />
                                </svg>
                                <input type="email" class="ugelaa-input" id="reg_correo" name="correo"
                                    placeholder="ejemplo@correo.com" required />
                            </div>
                            <div class="ugelaa-input-error" id="error_correo"></div>
                        </div>

                        <div class="ugelaa-input-group">
                            <label class="ugelaa-input-label" for="reg_nickname">Nombre de Usuario (Nickname)</label>
                            <div class="ugelaa-input-wrap">
                                <svg class="ugelaa-input-icon" xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                                    <circle cx="12" cy="7" r="4" />
                                </svg>
                                <input type="text" class="ugelaa-input" id="reg_nickname" name="nickname"
                                    placeholder="Ingrese un nombre de usuario" required />
                            </div>
                            <div class="ugelaa-input-error" id="error_nickname"></div>
                        </div>

                        <div class="ugelaa-input-group">
                            <label class="ugelaa-input-label" for="reg_password">Contraseña</label>
                            <div class="ugelaa-input-wrap">
                                <svg class="ugelaa-input-icon" xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                                </svg>
                                <input type="password" class="ugelaa-input" id="reg_password" name="password"
                                    placeholder="Mínimo 6 caracteres" required />
                                <button type="button" class="ugelaa-pw-toggle" onclick="togglePassword('reg_password', this)">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                        <circle cx="12" cy="12" r="3" />
                                    </svg>
                                </button>
                            </div>
                            <div class="ugelaa-input-error" id="error_password"></div>
                        </div>

                        <div class="ugelaa-input-group">
                            <label class="ugelaa-input-label" for="reg_password_confirmation">Confirmar Contraseña</label>
                            <div class="ugelaa-input-wrap">
                                <svg class="ugelaa-input-icon" xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                                </svg>
                                <input type="password" class="ugelaa-input" id="reg_password_confirmation"
                                    name="password_confirmation" placeholder="Repita su contraseña" required />
                                <button type="button" class="ugelaa-pw-toggle"
                                    onclick="togglePassword('reg_password_confirmation', this)">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                        <circle cx="12" cy="12" r="3" />
                                    </svg>
                                </button>
                            </div>
                            <div class="ugelaa-input-error" id="error_password_confirmation"></div>
                            {{-- Indicador de coincidencia --}}
                            <div class="ugelaa-password-match" id="passwordMatch" style="display: none;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                                    <polyline points="22 4 12 14.01 9 11.01" />
                                </svg>
                                <span>Las contraseñas coinciden</span>
                            </div>
                        </div>

                        {{-- Alerta general --}}
                        <div id="alertaRegistro" class="ugelaa-alert ugelaa-alert--danger" style="display: none;"></div>

                        {{-- Botón Registrarse --}}
                        <div class="ugelaa-btn-wrapper">
                            <button type="submit" id="btnRegistrarse" class="ugelaa-btn-submit">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                                    <circle cx="8.5" cy="7" r="4" />
                                    <line x1="20" y1="8" x2="20" y2="14" />
                                    <line x1="23" y1="11" x2="17" y2="11" />
                                </svg>
                                <span class="indicator-label">Registrarse</span>
                                <span class="indicator-progress" style="display: none;">Enviando...
                                    <span class="ugelaa-spinner" style="display: inline-block;"></span>
                                </span>
                            </button>
                        </div>
                    </div>
                </form>

                {{-- Confirmación de verificación enviada --}}
                <div class="ugelaa-verificacion-modal" id="modalVerificacion" style="display: none;">
                    <div class="ugelaa-verificacion-card">
                        <div class="ugelaa-verificacion-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                                <polyline points="22,6 12,13 2,6" />
                            </svg>
                        </div>

                        <h2 class="ugelaa-verificacion-title">Verificación Enviada</h2>

                        <p class="ugelaa-verificacion-text">
                            Hemos enviado un enlace de verificación al correo:
                        </p>

                        <p class="ugelaa-verificacion-correo" id="correoEnviado"></p>

                        <p class="ugelaa-verificacion-text" style="margin-top: 10px;">
                            Revise su bandeja de entrada y siga el enlace recibido para completar su registro.
                        </p>

                        <p class="ugelaa-verificacion-timer">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10" />
                                <polyline points="12 6 12 12 16 14" />
                            </svg>
                            Expira en: <strong id="timerCountdown">10:00</strong>
                        </p>

                        <div class="ugelaa-verificacion-divider"></div>

                        <p class="ugelaa-verificacion-hint">
                            ¿No recibió el correo? Puede reenviar el enlace de verificación usando los datos ya registrados.
                        </p>

                        <div class="ugelaa-reenvio-form" id="reenvioForm">
                            <div id="alertaReenvio" class="ugelaa-alert ugelaa-alert--danger" style="display: none;"></div>

                            <button type="button" class="ugelaa-btn-submit ugelaa-btn-submit--secondary" id="btnReenviar">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <polyline points="23 4 23 10 17 10" />
                                    <path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10" />
                                </svg>
                                <span>Reenviar Verificación</span>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Link para volver al login --}}
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
    const formRegistro = document.getElementById('formRegistro');
    const btnBuscarDni = document.getElementById('btnBuscarDni');
    const stepDatos = document.getElementById('stepDatos');
    const modalVerificacion = document.getElementById('modalVerificacion');
    let registroId = null;
    let countdownInterval = null;

    // ─── Buscar DNI ───
    btnBuscarDni.addEventListener('click', function() {
        const dni = document.getElementById('reg_dni').value.trim();
        const alertaDni = document.getElementById('alertaDni');

        alertaDni.style.display = 'none';

        if (dni.length !== 8) {
            alertaDni.textContent = 'El DNI debe tener exactamente 8 dígitos.';
            alertaDni.style.display = 'block';
            return;
        }

        // Mostrar loading
        btnBuscarDni.querySelector('.ugelaa-btn-buscar__text').style.display = 'none';
        btnBuscarDni.querySelector('.ugelaa-btn-buscar__loading').style.display = 'inline-flex';
        btnBuscarDni.disabled = true;

        axios.post('/registro/buscar-dni', { dni: dni })
            .then(function(response) {
                const data = response.data;

                if (data.success || data.encontrado) {
                    const apellidos = ((data.datos.aPa || '') + ' ' + (data.datos.aMa || '')).trim();
                    document.getElementById('reg_apellidos').value = apellidos;
                    document.getElementById('reg_nombres').value = data.datos.nom || '';
                    document.getElementById('reg_dni').readOnly = true;

                    // Cambiar botón a 'Cambiar'
                    btnBuscarDni.style.display = 'none';
                    const btnCambiarDni = document.getElementById('btnCambiarDni');
                    if (btnCambiarDni) btnCambiarDni.style.display = 'inline-flex';

                    // Si hay aviso
                    const avisoDni = document.getElementById('avisoDni');
                    if (data.ya_registrado && avisoDni) {
                        avisoDni.innerHTML = '<strong>Aviso:</strong> Este DNI ya está registrado en el sistema. Puedes completar el formulario para re-probar y actualizar tus datos, o <a href="/login" style="font-weight:600; text-decoration:underline; color:#0260cc;">Iniciar Sesión</a>.';
                        avisoDni.style.display = 'block';
                    } else if (avisoDni) {
                        avisoDni.style.display = 'none';
                    }

                    // Mostrar paso 2
                    stepDatos.classList.remove('ugelaa-registro-step--hidden');
                    stepDatos.style.display = 'block';
                    stepDatos.style.animation = 'fadeInUp 0.5s ease forwards';

                    // Scroll suave
                    stepDatos.scrollIntoView({ behavior: 'smooth', block: 'start' });
                } else {
                    alertaDni.textContent = data.message || 'Error al buscar el DNI.';
                    alertaDni.style.display = 'block';
                }
            })
            .catch(function(error) {
                alertaDni.textContent = error.response?.data?.message || 'Error de conexión. Intente nuevamente.';
                alertaDni.style.display = 'block';
            })
            .finally(function() {
                btnBuscarDni.querySelector('.ugelaa-btn-buscar__text').style.display = 'inline';
                btnBuscarDni.querySelector('.ugelaa-btn-buscar__loading').style.display = 'none';
                btnBuscarDni.disabled = false;
            });
    });

    // ─── Botón Cambiar DNI ───
    const btnCambiarDni = document.getElementById('btnCambiarDni');
    if (btnCambiarDni) {
        btnCambiarDni.addEventListener('click', function() {
            const inputDni = document.getElementById('reg_dni');
            inputDni.readOnly = false;
            inputDni.focus();
            btnBuscarDni.style.display = 'inline-flex';
            this.style.display = 'none';
            stepDatos.classList.add('ugelaa-registro-step--hidden');
            stepDatos.style.display = 'none';
            const avisoDni = document.getElementById('avisoDni');
            if (avisoDni) avisoDni.style.display = 'none';
        });
    }

    // ─── Verificar coincidencia de contraseñas en tiempo real ───
    const passInput = document.getElementById('reg_password');
    const passConfirm = document.getElementById('reg_password_confirmation');
    const matchIndicator = document.getElementById('passwordMatch');

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

    // ─── Enviar formulario de registro ───
    formRegistro.addEventListener('submit', function(e) {
        e.preventDefault();

        // Limpiar errores previos
        document.querySelectorAll('.ugelaa-input-error').forEach(el => el.textContent = '');
        document.querySelectorAll('.ugelaa-input').forEach(el => el.classList.remove('is-invalid'));
        document.getElementById('alertaRegistro').style.display = 'none';

        const btnRegistrarse = document.getElementById('btnRegistrarse');
        btnRegistrarse.querySelector('.indicator-label').style.display = 'none';
        btnRegistrarse.querySelector('.indicator-progress').style.display = 'inline-flex';
        btnRegistrarse.disabled = true;

        const formData = new FormData(formRegistro);

        axios.post('/registro', formData)
            .then(function(response) {
                const data = response.data;

                if (data.success) {
                    registroId = data.registro_id;

                    // Mostrar modal de verificación
                    document.getElementById('correoEnviado').textContent = data.correo;
                                        formRegistro.style.display = 'none';
                    modalVerificacion.style.display = 'block';

                    // Iniciar countdown
                    startCountdown(10 * 60);
                }
            })
            .catch(function(error) {
                const resp = error.response;

                if (resp && resp.data) {
                    if (resp.data.errores) {
                        // Errores de validación
                        Object.entries(resp.data.errores).forEach(function([campo, mensajes]) {
                            const input = formRegistro.querySelector('[name="' + campo + '"]');
                            if (input) {
                                input.classList.add('is-invalid');
                            }
                            const errorDiv = document.getElementById('error_' + campo);
                            if (errorDiv) {
                                errorDiv.innerHTML = mensajes[0];
                            }
                        });
                    }

                    if (resp.data.message) {
                        const alertaRegistro = document.getElementById('alertaRegistro');
                        alertaRegistro.innerHTML = resp.data.message;
                        alertaRegistro.style.display = 'block';
                    }
                }
            })
            .finally(function() {
                btnRegistrarse.querySelector('.indicator-label').style.display = 'inline';
                btnRegistrarse.querySelector('.indicator-progress').style.display = 'none';
                btnRegistrarse.disabled = false;
            });
    });

    // ─── Reenviar verificación ───
    document.getElementById('btnReenviar').addEventListener('click', function() {
        const correo = document.getElementById('reg_correo').value;
        const password = document.getElementById('reg_password').value;
        const passwordConfirm = document.getElementById('reg_password_confirmation').value;
        const alertaReenvio = document.getElementById('alertaReenvio');
        const btnReenviar = this;

        alertaReenvio.style.display = 'none';
        alertaReenvio.classList.remove('ugelaa-alert--success');
        alertaReenvio.classList.add('ugelaa-alert--danger');

        btnReenviar.disabled = true;

        axios.post('/registro/reenviar', {
            registro_id: registroId,
            correo: correo,
            password: password,
            password_confirmation: passwordConfirm,
        })
        .then(function(response) {
            if (response.data.success) {
                document.getElementById('correoEnviado').textContent = response.data.correo || correo;

                alertaReenvio.classList.remove('ugelaa-alert--danger');
                alertaReenvio.classList.add('ugelaa-alert--success');
                alertaReenvio.textContent = response.data.message || 'El enlace de verificación fue reenviado correctamente.';
                alertaReenvio.style.display = 'block';

                startCountdown(10 * 60);
            }
        })
        .catch(function(error) {
            const msg = error.response?.data?.message || 'No se pudo reenviar el enlace. Intente nuevamente.';
            alertaReenvio.classList.remove('ugelaa-alert--success');
            alertaReenvio.classList.add('ugelaa-alert--danger');
            alertaReenvio.textContent = msg;
            alertaReenvio.style.display = 'block';
        })
        .finally(function() {
            btnReenviar.disabled = false;
        });
    });

    // ─── Countdown Timer ───
    function startCountdown(seconds) {
        if (countdownInterval) clearInterval(countdownInterval);

        let remaining = seconds;
        const display = document.getElementById('timerCountdown');

        function updateDisplay() {
            const min = Math.floor(remaining / 60);
            const sec = remaining % 60;
            display.textContent = min.toString().padStart(2, '0') + ':' + sec.toString().padStart(2, '0');
        }

        updateDisplay();

        countdownInterval = setInterval(function() {
            remaining--;
            updateDisplay();

            if (remaining <= 0) {
                clearInterval(countdownInterval);
                display.textContent = 'EXPIRADO';
                display.style.color = '#f31260';
            }
        }, 1000);
    }
});

// Toggle password visibility
function togglePassword(inputId, btn) {
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
