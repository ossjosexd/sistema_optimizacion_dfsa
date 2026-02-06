<!DOCTYPE html>
<html lang="es">
<head>
    <title>Restablecer Contraseña</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="login-box">
        <img src="{{ asset('img/logo_df.jpg') }}" alt="Logo Díaz Frontado, S.A." class="logo">

        <h2>Restablecer Contraseña</h2>
        <p style="font-size: 0.9em; margin-bottom: 20px;">Ingresa el código de 6 dígitos que recibiste en tu correo y define tu nueva contraseña.</p>

        @if (session('status'))
            <p class="status-message">{{ session('status') }}</p>
        @endif

        @if ($errors->any() && !$errors->has('code') && !$errors->has('password') && !$errors->has('email'))
            <div class="alert alert-danger" style="text-align: left; margin-bottom: 15px; padding: 10px; background-color: #f8d7da; border: 1px solid #f5c6cb; border-radius: 4px;">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            
            <input type="hidden" name="email" value="{{ $email ?? old('email') }}">
             @error('email')
                 <span class="error-message" style="display: block; margin-bottom: 10px;">{{ $message }}</span>
             @enderror


            <div class="form-group" style="text-align: left;">
                <label for="code">Código de Verificación (6 dígitos):</label>
                <input type="text" id="code" name="code" class="form-control" placeholder="123456" required autofocus maxlength="6" pattern="\d{6}">
                 @error('code')
                    <span class="error-message">{{ $message }}</span>
                 @enderror
            </div>

             <hr style="margin: 20px 0;">

            <div class="form-group" style="text-align: left;">
                <label for="password">Nueva Contraseña:</label>
                <input type="password" id="password" name="password" class="form-control" required minlength="8">
                <small>Debe tener al menos 8 caracteres.</small>
                 @error('password')
                    <span class="error-message">{{ $message }}</span>
                 @enderror
            </div>

            <div class="form-group" style="text-align: left;">
                <label for="password_confirmation">Confirmar Nueva Contraseña:</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
            </div>
            
            <button type="submit" class="btn btn-primary w-100" style="margin-top: 20px;">Restablecer Contraseña</button>
        </form>
        
        <a href="{{ route('login') }}" style="margin-top: 25px;">Volver al Inicio de Sesión</a>
    </div>
</body>
</html>