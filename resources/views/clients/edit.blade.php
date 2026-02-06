@extends('dashboard')

@section('contenido')
    
    <h2>Editar Cliente: {{ $client->nombre_empresa }} ({{ $client->rif }})</h2>
    <p>Modifica la información del cliente.</p>
    <hr>

    <form action="{{ route('clients.update', $client) }}" method="POST" class="form-layout-dos-columnas">
        @csrf
        @method('PUT') 

        <div class="form-group">
            <label for="rif">RIF:</label>
            <input type="text" id="rif" name="rif" class="form-control" value="{{ old('rif', $client->rif) }}" required>
            @error('rif')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="nombre_empresa">Nombre de la Empresa:</label>
            <input type="text" id="nombre_empresa" name="nombre_empresa" class="form-control" value="{{ old('nombre_empresa', $client->nombre_empresa) }}" required>
            @error('nombre_empresa')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="persona_contacto">Persona Contacto (Opcional):</label>
            <input type="text" id="persona_contacto" name="persona_contacto" class="form-control" value="{{ old('persona_contacto', $client->persona_contacto) }}">
            @error('persona_contacto')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="telefono">Teléfono (Opcional):</label>
            <input type="tel" id="telefono" name="telefono" class="form-control" value="{{ old('telefono', $client->telefono) }}">
             @error('telefono')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="email">Correo Electrónico (Opcional):</label>
            <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $client->email) }}">
            @error('email')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group form-span-2">
            <label for="direccion">Dirección Fiscal (Opcional):</label>
            <textarea id="direccion" name="direccion" class="form-control" rows="3">{{ old('direccion', $client->direccion) }}</textarea>
            @error('direccion')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group-button">
            <button type="submit" class="btn btn-primary">
                <i class="fa-solid fa-sync-alt"></i> Actualizar Cliente
            </button>
        </div>

    </form> 
    
@endsection
