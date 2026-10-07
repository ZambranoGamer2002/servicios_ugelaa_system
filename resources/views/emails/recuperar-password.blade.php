<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña</title>
</head>
<body style="margin:0; padding:0; background-color:#f4f7fb; font-family:Arial, Helvetica, sans-serif; color:#1f2937;">

<table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="width:100%; background-color:#f4f7fb; padding:40px 16px;">
    <tr>
        <td align="center">
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="width:100%; max-width:600px; background-color:#ffffff; border:1px solid #e5e7eb; border-radius:14px; overflow:hidden;">
                <tr>
                    <td style="background-color:#037fff; padding:28px 36px;">
                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td width="52" valign="middle">
                                    <table role="presentation" width="44" height="44" cellpadding="0" cellspacing="0" border="0" style="width:44px; height:44px; background-color:#ffffff; border-radius:12px;">
                                        <tr>
                                            <td align="center" valign="middle">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                    <rect x="6" y="10" width="12" height="9" rx="2" stroke="#037fff" stroke-width="1.8"/>
                                                    <path d="M8.5 10V7.75C8.5 5.68 10.07 4 12 4C13.93 4 15.5 5.68 15.5 7.75V10" stroke="#037fff" stroke-width="1.8" stroke-linecap="round"/>
                                                    <circle cx="12" cy="14.5" r="1.2" fill="#037fff"/>
                                                </svg>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                <td valign="middle">
                                    <h1 style="margin:0; color:#ffffff; font-size:20px; line-height:1.3; font-weight:700;">Sistema UGELAA</h1>
                                    <p style="margin:4px 0 0 0; color:#dbeafe; font-size:12px; line-height:1.5;">Trámite Documentario — UGEL Alto Amazonas</p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td style="padding:36px 36px 32px 36px;">
                        <p style="margin:0 0 8px 0; color:#037fff; font-size:12px; font-weight:700; letter-spacing:.8px; text-transform:uppercase;">Seguridad de cuenta</p>
                        <h2 style="margin:0 0 18px 0; color:#111827; font-size:24px; line-height:1.3; font-weight:700;">Restablece tu contraseña</h2>

                        <p style="margin:0 0 12px 0; color:#4b5563; font-size:14px; line-height:1.7;">Hola <strong style="color:#111827;">{{ $nombreCompleto }}</strong>,</p>
                        <p style="margin:0 0 26px 0; color:#4b5563; font-size:14px; line-height:1.7;">
                            Recibimos una solicitud para restablecer la contraseña de tu cuenta en el
                            <strong style="color:#111827;">Sistema de Trámite Documentario</strong>.
                            Para crear una nueva contraseña, utiliza el siguiente botón.
                        </p>

                        <table role="presentation" cellpadding="0" cellspacing="0" border="0" style="margin:0 0 28px 0;">
                            <tr>
                                <td style="background-color:#037fff; border-radius:9px;">
                                    <a href="{{ $enlaceReset }}" style="display:inline-block; padding:14px 26px; color:#ffffff; font-size:14px; line-height:1; font-weight:700; text-decoration:none;">Restablecer contraseña</a>
                                </td>
                            </tr>
                        </table>

                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="width:100%; background-color:#fffaf0; border:1px solid #fde7b2; border-radius:10px; margin:0 0 26px 0;">
                            <tr>
                                <td width="44" valign="top" style="padding:15px 0 15px 16px;">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                        <circle cx="12" cy="12" r="8.5" stroke="#b7791f" stroke-width="1.8"/>
                                        <path d="M12 7.5V12L15 13.75" stroke="#b7791f" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </td>
                                <td style="padding:14px 16px 14px 8px;">
                                    <p style="margin:0; color:#8a5a12; font-size:13px; line-height:1.6; font-weight:700;">Este enlace expira en 30 minutos.</p>
                                    <p style="margin:3px 0 0 0; color:#8a5a12; font-size:12px; line-height:1.6;">Si no restableces tu contraseña dentro de ese tiempo, deberás solicitar un nuevo enlace.</p>
                                </td>
                            </tr>
                        </table>

                        <p style="margin:0 0 8px 0; color:#6b7280; font-size:12px; line-height:1.6;">Si el botón no funciona, copia y pega este enlace en tu navegador:</p>
                        <p style="margin:0 0 26px 0; padding:12px 14px; background-color:#f8fafc; border:1px solid #e5e7eb; border-radius:8px; color:#037fff; font-size:12px; line-height:1.6; word-break:break-all;">{{ $enlaceReset }}</p>

                        <div style="height:1px; background-color:#e5e7eb; margin:0 0 22px 0;"></div>

                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td width="36" valign="top">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                        <circle cx="12" cy="12" r="8.5" stroke="#9ca3af" stroke-width="1.7"/>
                                        <path d="M12 10.5V16" stroke="#9ca3af" stroke-width="1.7" stroke-linecap="round"/>
                                        <circle cx="12" cy="7.5" r="1" fill="#9ca3af"/>
                                    </svg>
                                </td>
                                <td>
                                    <p style="margin:0; color:#9ca3af; font-size:11px; line-height:1.6;">Si no solicitaste este cambio, puedes ignorar este correo. Tu contraseña no será modificada.</p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td style="background-color:#f8fafc; padding:20px 36px; border-top:1px solid #e5e7eb;">
                        <p style="margin:0; color:#9ca3af; font-size:11px; line-height:1.6; text-align:center;">&copy; {{ date('Y') }} UGEL Alto Amazonas — Sistema de Trámite Documentario</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

</body>
</html>
