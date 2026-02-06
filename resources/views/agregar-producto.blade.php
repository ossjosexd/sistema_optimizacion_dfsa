@extends('dashboard')

@section('contenido')
    
    <h2>Gestión de Inventario: Agregar Nuevo Producto</h2>
    <p>Completa la información del artículo base. Las cantidades se manejan en el módulo de Movimientos.</p>
    <hr>

    <form action="{{ route('productos.store') }}" method="POST" class="form-layout-dos-columnas" enctype="multipart/form-data">
        @csrf

        <div class="form-group form-group-full-width">
            <label for="descripcion">Nombre o Descripción:</label>
            <input type="text" id="descripcion" name="descripcion" class="form-control" placeholder="Ej: Banda transportadora Lisa" value="{{ old('descripcion') }}" required>
            @error('descripcion')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="modelo">Modelo:</label>
            <input type="text" id="modelo" name="modelo" class="form-control" placeholder="Ej: X-500" value="{{ old('modelo') }}">
            @error('modelo')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="unidad_medida">Unidad de Medida:</label>
            <select id="unidad_medida" name="unidad_medida" class="form-control" required>
                <option value="" disabled {{ old('unidad_medida') ? '' : 'selected' }}>Selecciona una unidad</option>
                <option value="m2" {{ old('unidad_medida') == 'm2' ? 'selected' : '' }}>m2 (Metros cuadrados)</option>
                <option value="unid" {{ old('unidad_medida') == 'unid' ? 'selected' : '' }}>unid. (Unidades)</option>
            </select>
             @error('unidad_medida')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="fecha">Fecha de Creación (Artículo):</label>
            <input type="date" id="fecha" name="fecha" class="form-control" value="{{ old('fecha', date('Y-m-d')) }}" required>
             @error('fecha')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="stock_minimo">Stock Mínimo:</label>
            <input type="number" step="any" id="stock_minimo" name="stock_minimo" class="form-control" placeholder="Ej: 10.00" value="{{ old('stock_minimo') }}" min="0" required>
            <small>Cantidad mínima antes de alerta.</small>
             @error('stock_minimo')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group form-group-full-width">
            <label for="imagen">Imagen del Producto (Opcional):</label>
            <input type="file" id="imagen" name="imagen" class="form-control" accept="image/*">
            @error('imagen')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group-button form-group-full-width" style="margin-top: 20px;">
            <button type="submit" class="btn btn-primary w-100">
                <i class="fa-solid fa-save"></i> Guardar Artículo
            </button>
        </div>

    </form>
    
@endsection