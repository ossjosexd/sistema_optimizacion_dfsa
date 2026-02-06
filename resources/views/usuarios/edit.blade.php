@extends('dashboard')

@section('contenido')
    
    <h2>Editar Usuario: {{ $user->name }}</h2>
    <p>Modifica los datos del usuario.</p>
    <hr>

    <div class="form-container" style="max-width: 600px; margin: 0 auto;">
        
        <form action="{{ route('usuarios.update', $user) }}" method="POST">
            @csrf
            @method('PUT') 

            <div class="form-group">
                <label for="name">Nombre Completo:</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                @error('name')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Correo Electrónico:</label>
                <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                @error('email')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="role">Rol (Privilegio):</label>
                <select id="role" name="role" class="form-control" required>
                    <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>Usuario (Estándar)</option>
                    <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Administrador (Total)</option>
                </select>
                @error('role')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
            <hr>
            <div class="form-group">
                <label for="password">Nueva Contraseña (Opcional):</label>
                <input type="password" id="password" name="password" class="form-control">
                <small>Dejar en blanco para no cambiar la contraseña actual.</small>
                @error('password')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirmar Nueva Contraseña:</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control">
            </div>

            <div class="form-group" style="margin-top: 20px;">
                <button type="submit" class="btn btn-primary w-100">Actualizar Usuario</button>
            </div>

        </form>
    </div>
@endsection
