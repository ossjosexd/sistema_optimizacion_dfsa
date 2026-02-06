<!DOCTYPE html>
<html lang="es">
<head>
    <title>Díaz Frontado - Iniciar Sesión</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="login-box">
        <img src="{{ asset('img/logo_df.jpg') }}" alt="Logo Díaz Frontado, S.A." class="logo">

        @if (session('status'))
            <p class="status-message">{{ session('status') }}</p>
        @endif

        @error('email')
            <p class="error-message" style="background-color: #f8d7da; border: 1px solid #f5c6cb; padding: 10px; border-radius: 4px; margin-bottom: 15px;">
                {{ $message }}
            </p>
        @enderror

        <h2>Bienvenido al Sistema de Inventario</h2>
        
        <form method="POST" action="{{ route('do.login') }}">
            
            @csrf 
            
            <div class="form-group">
                <input type="email" name="email" class="form-control" placeholder="Correo Electrónico" required value="{{ old('email') }}" autofocus>
            </div>
            
            <div class="form-group mb-2" style="position: relative;">
                <input type="password" id="password" name="password" class="form-control" placeholder="Contraseña" required 
                       style="padding-right: 50px;"> 

                <button type="button" id="togglePassword" title="Mostrar/Ocultar Contraseña" 
                        style="position: absolute; right: 0; top: 0; height:50%; width: 40px; background: none; border: none; cursor: pointer; color: #555; 
                                display: flex; align-items: center; justify-content: center; padding: 0;">
                    <i class="fa-solid fa-eye-slash" id="eye-icon" style="font-size: 0.9em;"></i> 
                </button>
            </div>
            
            <button type="submit" class="btn btn-primary w-100">Aceptar</button>
        </form>
        
        <a href="{{ route('crear.cuenta') }}">¿Eres nuevo? Crea una cuenta.</a>
        <a href="{{ route('password.request') }}">Recuperar Contraseña</a>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');

            if (togglePassword) {
                togglePassword.addEventListener('click', function(e) {
                    e.preventDefault(); 
                    
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);

                    if (type === 'text') {
                        eyeIcon.classList.remove('fa-eye-slash');
                        eyeIcon.classList.add('fa-eye');
                    } else {
                        eyeIcon.classList.remove('fa-eye');
                        eyeIcon.classList.add('fa-eye-slash');
                    }
                });
            }
        });
    </script>
</body>
</html>