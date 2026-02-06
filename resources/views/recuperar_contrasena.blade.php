<!DOCTYPE html>
<html lang="es">
<head>
    <title>Recuperar Contraseña</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="login-box">
        <img src="{{ asset('img/logo_df.jpg') }}" alt="Logo Díaz Frontado, S.A." class="logo">

        <h2>Recuperar Contraseña</h2>
        <p style="font-size: 0.9em; margin-bottom: 20px;">Ingresa tu correo electrónico asociado a la cuenta. Te enviaremos un código de verificación para restablecer tu contraseña.</p>

        @if (session('status'))
            <p class="status-message">{{ session('status') }}</p>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger" style="text-align: left; margin-bottom: 15px; padding: 10px; background-color: #f8d7da; border: 1px solid #f5c6cb; border-radius: 4px;">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            
            <div class="form-group" style="text-align: left;">
                <label for="email">Correo Electrónico:</label>
                <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="tu.correo@ejemplo.com" required autofocus>
                 @error('email')
                    <span class="error-message" style="display: block; margin-top: 5px;">{{ $message }}</span>
                 @enderror
            </div>
            
            <button type="submit" class="btn btn-primary w-100" style="margin-top: 20px;">Enviar Código de Recuperación</button>
        </form>
        
        <a href="{{ route('login') }}" style="margin-top: 25px;">Volver al Inicio de Sesión</a>
    </div>
</body>
</html>
