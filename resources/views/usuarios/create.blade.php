@extends('dashboard')

@section('contenido')
    
    <h2>Crear Nuevo Usuario</h2>
    <p>Completa los datos para registrar un nuevo usuario en el sistema.</p>
    <hr>

    <div class="form-container" style="max-width: 600px; margin: 0 auto;">
        
        <form action="{{ route('usuarios.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="name">Nombre Completo:</label>
                <input type="text" id="name" name="name" class="form-control" placeholder="Ej: Oswaldo Infante" value="{{ old('name') }}" required>
                @error('name')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Correo Electrónico:</label>
                <input type="email" id="email" name="email" class="form-control" placeholder="Ej: oinfante@diazfrontado.com.ve" value="{{ old('email') }}" required>
                @error('email')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="role">Rol (Privilegio):</label>
                <select id="role" name="role" class="form-control" required>
                    <option value="" disabled selected>Selecciona un rol...</option>
                    <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>Usuario (Estándar)</option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrador (Total)</option>
                </select>
                @error('role')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
            <hr>
            <div class="form-group">
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" class="form-control" required>
                <small>La contraseña debe tener al menos 8 caracteres.</small>
                @error('password')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirmar Contraseña:</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
            </div>


            <div class="form-group" style="margin-top: 20px;">
                <button type="submit" class="btn btn-primary w-100">Guardar Usuario</button>
            </div>

        </form>
    </div>
@endsection