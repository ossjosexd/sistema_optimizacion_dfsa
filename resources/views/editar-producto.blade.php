@extends('dashboard')

@section('contenido')
    
    <h2>Editar Producto: #{{ $product->numeracion }}</h2>
    <p>Modifica los datos de identificación del artículo. Las cantidades se manejan en el módulo de Movimientos.</p>
    <hr>

    <form action="{{ route('productos.update', ['producto' => $product->id]) }}" method="POST" class="form-layout-dos-columnas" enctype="multipart/form-data">
        @csrf
        @method('PUT') 

        <div class="form-group">
            <label for="numeracion">Numeración (Código):</label>
            <input type="text" id="numeracion" name="numeracion" class="form-control" value="{{ $product->numeracion }}" readonly disabled style="background-color: #e9ecef;">
        </div>

        <div class="form-group">
            <label for="modelo">Modelo:</label>
            <input type="text" id="modelo" name="modelo" class="form-control" placeholder="Ej: X-500" value="{{ old('modelo', $product->modelo) }}">
            @error('modelo')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="form-group form-group-full-width">
            <label for="descripcion">Nombre o Descripción:</label>
            <input type="text" id="descripcion" name="descripcion" class="form-control" placeholder="Ej: Banda transportadora Lisa" value="{{ old('descripcion', $product->descripcion) }}" required>
            @error('descripcion')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="unidad_medida">Unidad de Medida:</label>
            <select id="unidad_medida" name="unidad_medida" class="form-control" required>
                <option value="m2" {{ old('unidad_medida', $product->unidad_medida) == 'm2' ? 'selected' : '' }}>m2 (Metros cuadrados)</option>
                <option value="unid" {{ old('unidad_medida', $product->unidad_medida) == 'unid' ? 'selected' : '' }}>unid. (Unidades)</option>
            </select>
             @error('unidad_medida')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="fecha">Fecha de Creación (Artículo):</label>
            <input type="date" id="fecha" name="fecha" class="form-control" value="{{ old('fecha', $product->fecha) }}" required> 
             @error('fecha')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="stock_minimo">Stock Mínimo:</label>
            <input type="number" step="any" id="stock_minimo" name="stock_minimo" class="form-control" placeholder="Ej: 10.00" value="{{ old('stock_minimo', $product->stock_minimo ?? 0) }}" min="0" required>
            <small>Cantidad mínima antes de alerta.</small>
             @error('stock_minimo')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="ficha_fabricante">URL Ficha Técnica Fabricante (Opcional):</label>
            <input type="url" id="ficha_fabricante" name="ficha_fabricante" class="form-control" placeholder="Ej: https://fabricante.com/ficha.pdf" value="{{ old('ficha_fabricante', $product->ficha_fabricante ?? '') }}">
            @error('ficha_fabricante')
                  <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group form-group-full-width">
            <label for="imagen">Imagen del Producto (Opcional):</label>
            
            @if($product->imagen)
                <div style="margin: 10px 0;">
                    <p style="font-size: 12px; margin-bottom: 5px; color: #666;">Imagen Actual:</p>
                    <img src="{{ asset($product->imagen) }}" alt="Imagen actual" style="max-height: 100px; border: 1px solid #ddd; padding: 4px; border-radius: 4px;">
                </div>
            @endif

            <input type="file" id="imagen" name="imagen" class="form-control" accept="image/*">
            <small style="color: #666;">Deja este campo vacío si deseas mantener la imagen actual.</small>
            
            @error('imagen')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group-button form-group-full-width" style="margin-top: 20px;">
            <button type="submit" class="btn btn-primary w-100">
                <i class="fa-solid fa-sync-alt"></i> Actualizar Artículo
            </button>
        </div>

    </form>
    
@endsection