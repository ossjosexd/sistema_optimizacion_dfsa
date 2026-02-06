@extends('dashboard')

@section('contenido')
    
    <h2>Editar Movimiento #{{ $movement->id }} ({{ ucfirst($movement->type) }})</h2>
    <p>Modifica los datos del registro de inventario. El sistema no recalcula el stock automáticamente con la edición, solo actualiza el registro.</p>
    <hr>

    <div class="form-container" style="max-width: 600px; margin: 0 auto;">
        
        <form action="{{ route('movements.update', $movement) }}" method="POST">
            @csrf
            @method('PUT')

            @if ($movement->type == 'salida')
                <div class="form-group">
                    <label for="client_id">Cliente:</label>
                    <select id="client_id" name="client_id" class="form-control" required>
                        <option value="" disabled>Selecciona un cliente...</option>
                        
                        @foreach ($clients as $id => $nombre_empresa)
                            <option value="{{ $id }}" {{ old('client_id', $movement->client_id) == $id ? 'selected' : '' }}>
                                {{ $nombre_empresa }}
                            </option>
                        @endforeach
                    </select>
                    @error('client_id')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
            @endif

            <div class="form-group">
                <label for="product_id">Producto:</label>
                <select id="product_id" name="product_id" class="form-control" required>
                    <option value="" disabled selected>Selecciona un producto...</option>
                    @php 
                        $products = json_decode($productsData);
                    @endphp
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}" {{ old('product_id', $movement->product_id) == $product->id ? 'selected' : '' }}>
                            {{ $product->descripcion }} ({{ $product->unidad_medida }})
                        </option>
                    @endforeach
                </select>
                @error('product_id')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="quantity">Cantidad:</label>
                <input type="number" step="any" id="quantity" name="quantity" class="form-control" placeholder="Ej: 10.50" value="{{ old('quantity', $movement->quantity) }}" required min="0.01">
                @error('quantity')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="movement_date">Fecha:</label>
                <input type="date" id="movement_date" name="movement_date" class="form-control" value="{{ old('movement_date', $movement->movement_date) }}" required>
                @error('movement_date')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

             <div class="form-group">
                <label for="notes">Notas / Observaciones (Opcional):</label>
                <textarea id="notes" name="notes" class="form-control" rows="3">{{ old('notes', $movement->notes) }}</textarea>
                @error('notes')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group" style="margin-top: 20px;">
                <button type="submit" class="btn btn-primary w-100">
                     <i class="fa-solid fa-sync-alt"></i> Actualizar Movimiento
                </button>
            </div>

        </form>
    </div>
@endsection
