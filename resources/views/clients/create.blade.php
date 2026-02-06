@extends('dashboard')

@section('contenido')
    
    <h2>Crear Nuevo Cliente</h2>
    <p>Completa la información de tu nuevo cliente.</p>
    <hr>
    
        <form action="{{ route('clients.store') }}" method="POST" class="form-layout-dos-columnas">
            @csrf
            
            <div class="form-group">
                <label for="rif">RIF:</label>
                <input type="text" id="rif" name="rif" class="form-control" placeholder="Ej: J-xxxxxxxx-x" value="{{ old('rif') }}" required>
                @error('rif')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="nombre_empresa">Nombre de la Empresa:</label>
                <input type="text" id="nombre_empresa" name="nombre_empresa" class="form-control" placeholder="Ej: Diaz Frontado, S.A." value="{{ old('nombre_empresa') }}" required>
                @error('nombre_empresa')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="persona_contacto">Persona Contacto (Opcional):</label>
                <input type="text" id="persona_contacto" name="persona_contacto" class="form-control" placeholder="Ej: Juan Pérez" value="{{ old('persona_contacto') }}">
                @error('persona_contacto')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="telefono">Teléfono (Opcional):</label>
                <input type="tel" id="telefono" name="telefono" class="form-control" placeholder="Ej: 0414-1234567" value="{{ old('telefono') }}">
                @error('telefono')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Correo Electrónico:</label>
                <input type="email" id="email" name="email" class="form-control" 
                        placeholder="Ej: ventas@polar.com" value="{{ old('email') }}">
                @error('email')
                    <span class="error-message">Este correo ya está registrado.</span>
                @enderror
            </div>

            <div class="form-group form-group-full-width">
                <label for="direccion">Dirección Fiscal (Opcional):</label>
                <textarea id="direccion" name="direccion" class="form-control" rows="3" placeholder="Ej: Av. Principal, Edif. Torre, Piso 1, Oficina 1A, Ciudad">{{ old('direccion') }}</textarea>
                @error('direccion')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group-button form-group-full-width" style="margin-top: 20px;">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fa-solid fa-save"></i> Guardar Cliente
                </button>
            </div>

        </form> 
    </div>
@endsection
