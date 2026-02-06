<!DOCTYPE html>
<html lang="es">
<head>
    <title>Díaz Frontado - Registro de Cuenta</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="login-box" style="width: 450px;"> 
        
        <img src="{{ asset('img/logo_df.jpg') }}" alt="Logo Díaz Frontado, S.A." class="logo">

        <h2>Registro de Nueva Cuenta</h2>
        <p>Define tus credenciales de acceso al sistema de inventario.</p>
        
        @if ($errors->any())
            <div class="alert alert-danger" style="text-align: left; margin-bottom: 15px; padding: 10px; background-color: #f8d7da; border: 1px solid #f5c6cb; border-radius: 4px;">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('do.crear') }}" method="POST">
            @csrf
            
            <h3 style="text-align: left; border-bottom: 2px solid #055038; padding-bottom: 5px; margin-top: 30px; font-size: 1.2em;">
                Información de la Cuenta
            </h3>
            
            <div class="form-group" style="text-align: left;">
                <label for="name">Nombre Completo:</label>
                <input type="text" id="name" name="name" class="form-control" placeholder="Ej: Oswaldo Infante" value="{{ old('name') }}" required>
                @error('name')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group" style="text-align: left;">
                <label for="email">Correo Electrónico:</label>
                <input type="email" id="email" name="email" class="form-control" placeholder="Ej: oinfante@diazfrontado.com.ve" value="{{ old('email') }}" required>
                @error('email')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group" style="text-align: left;">
                <label for="password">Crear Contraseña:</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="Crea una Contraseña (mín. 8 caracteres)" required>
                <small>La contraseña debe tener al menos 8 caracteres.</small>
                @error('password')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group" style="text-align: left;">
                <label for="password_confirmation">Confirmar Contraseña:</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
            </div>

            <div class="form-group" style="margin-top: 30px;">
                <button type="submit" class="btn btn-primary w-100">Registrarse</button>
            </div>

        </form>
        
        <a href="{{ route('login') }}" style="margin-top: 25px;">Volver al Inicio de Sesión</a>
    </div>
    <script src="{{ asset('js/scripts.js') }}"></script>
</body>
</html>
