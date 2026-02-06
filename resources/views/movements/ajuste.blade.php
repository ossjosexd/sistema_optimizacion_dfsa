@extends('dashboard')

@section('contenido')
    
    <h2>Registrar Ajuste de Inventario</h2>
    <p>Utiliza este formulario para corregir el stock por conteo físico, daños u otras razones.</p>
    <hr>

    <div class="form-container" style="max-width: 600px; margin: 0 auto;">
        
        <form action="{{ route('movements.storeAjuste') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="product_id">Producto a Ajustar:</label>
                <select id="product_id" name="product_id" class="form-control" required>
                    <option value="" disabled selected>Selecciona un producto...</option>
                </select>
                @error('product_id')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="adjustment_type">Tipo de Ajuste:</label>
                <select id="adjustment_type" name="adjustment_type" class="form-control" required>
                    <option value="" disabled {{ old('adjustment_type') ? '' : 'selected' }}>Selecciona el tipo...</option>
                    <option value="ajuste_positivo" {{ old('adjustment_type') == 'ajuste_positivo' ? 'selected' : '' }}>Ajuste Positivo (+)</option>
                    <option value="ajuste_negativo" {{ old('adjustment_type') == 'ajuste_negativo' ? 'selected' : '' }}>Ajuste Negativo (-)</option>
                </select>
                 @error('adjustment_type')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="quantity" id="quantity-label">Cantidad a Ajustar:</label>
                <input type="number" step="any" id="quantity" name="quantity" class="form-control" placeholder="Ej: 5 o 1.50" value="{{ old('quantity') }}" required min="0.01">
                @error('quantity')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="movement_date">Fecha del Ajuste:</label>
                <input type="date" id="movement_date" name="movement_date" class="form-control" value="{{ old('movement_date', date('Y-m-d')) }}" required>
                @error('movement_date')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

             <div class="form-group">
                <label for="notes">Razón del Ajuste (Obligatorio):</label>
                <textarea id="notes" name="notes" class="form-control" rows="3" required placeholder="Ej: Conteo físico fin de mes, producto dañado...">{{ old('notes') }}</textarea>
                @error('notes')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group" style="margin-top: 20px;">
                <button type="submit" class="btn btn-primary w-100">
                     <i class="fa-solid fa-wrench"></i> Registrar Ajuste
                </button>
            </div>

        </form>
    </div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const productsData = JSON.parse(@json($productsData)); 
        const productSelect = document.getElementById('product_id');
        const quantityLabel = document.getElementById('quantity-label');

        function populateProductSelect() {
             productSelect.innerHTML = '<option value="" disabled selected>Selecciona un producto...</option>';
             for (const id in productsData) {
                const product = productsData[id];
                const option = document.createElement('option');
                option.value = id;
                option.textContent = `${product.descripcion} (${product.unidad_medida})`; 
                
                if ({{ old('product_id', 0) }} == id) {
                    option.selected = true;
                }
                productSelect.appendChild(option);
            }
        }
        populateProductSelect();

        productSelect.addEventListener('change', function() {
             const selectedProductId = this.value;
             if (selectedProductId && productsData[selectedProductId]) {
                 const unit = productsData[selectedProductId].unidad_medida;
                 quantityLabel.textContent = `Cantidad a Ajustar (${unit}):`;
             } else {
                 quantityLabel.textContent = 'Cantidad a Ajustar:';
             }
        });
        if (productSelect.value) productSelect.dispatchEvent(new Event('change'));

    });
</script>
@endsection