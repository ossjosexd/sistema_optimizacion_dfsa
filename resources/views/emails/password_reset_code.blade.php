<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Código de Recuperación</title>
    <style>
        body { font-family: sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 20px auto; padding: 20px; border: 1px solid #eee; border-radius: 8px; }
        .code { font-size: 2em; font-weight: bold; color: #055038; margin: 20px 0; text-align: center; letter-spacing: 5px; }
        .footer { margin-top: 20px; font-size: 0.8em; color: #777; text-align: center; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Recuperación de Contraseña - Díaz Frontado, S.A.</h2>
        <p>Hola,</p>
        <p>Has solicitado restablecer tu contraseña para el Sistema de Inventario. Utiliza el siguiente código de verificación:</p>
        
        <p class="code">{{ $code }}</p>

        <p>Este código expirará en {{ config('auth.passwords.users.expire', 15) }} minutos.</p>
        <p>Si no solicitaste este cambio, puedes ignorar este correo.</p>
        
        <p>Saludos,<br>El equipo de Díaz Frontado, S.A.</p>

        <div class="footer">
            Este es un correo automático, por favor no respondas a esta dirección.
        </div>
    </div>
</body>
</html>