@extends('dashboard')

@section('contenido')
    
    <h2>Registrar Nueva Salida de Inventario</h2>
    <p>Completa los datos para registrar un despacho de producto a un cliente. El stock disponible se verifica automáticamente.</p>
    <hr>

    <div class="form-container" style="max-width: 600px; margin: 0 auto;">
        
        <form action="{{ route('movements.storeSalida') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="client_id">Cliente:</label>
                <select id="client_id" name="client_id" class="form-control" required>
                    <option value="" disabled selected>Selecciona un cliente...</option>
                    @foreach ($clients as $id => $nombre_empresa)
                        <option value="{{ $id }}" {{ old('client_id') == $id ? 'selected' : '' }}>
                            {{ $nombre_empresa }}
                        </option>
                    @endforeach
                </select>
                @error('client_id')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="product_id">Producto:</label>
                <select id="product_id" name="product_id" class="form-control" required>
                    <option value="" disabled selected>Selecciona un producto...</option>
                </select>
                @error('product_id')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div id="stock-info" style="display: none; border: 1px dashed #ccc; padding: 15px; margin-bottom: 15px; border-radius: 4px;">
                <p style="margin-top: 0; font-weight: bold; color: #555;">Stock Disponible: <span id="current-stock" style="color: #055038;">--</span></p>
            </div>

            <div class="form-group">
                <label for="quantity" id="quantity-label">Cantidad que Sale:</label>
                <input type="number" step="any" id="quantity" name="quantity" class="form-control" placeholder="Ej: 10 (Unid.) o 5.50 (m²)" value="{{ old('quantity') }}" required min="0.01">
                @error('quantity')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="movement_date">Fecha de Salida:</label>
                <input type="date" id="movement_date" name="movement_date" class="form-control" value="{{ old('movement_date', date('Y-m-d')) }}" required>
                @error('movement_date')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

             <div class="form-group">
                <label for="notes">Notas / Observaciones (Opcional):</label>
                <textarea id="notes" name="notes" class="form-control" rows="3">{{ old('notes') }}</textarea>
                @error('notes')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group" style="margin-top: 20px;">
                <button type="submit" class="btn btn-primary w-100">
                     <i class="fa-solid fa-truck-fast"></i> Registrar Salida
                </button>
            </div>

        </form>
    </div>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        const productsData = JSON.parse(@json($productsData)); 
        const stockData = JSON.parse(@json($stockData)); 
        const productSelect = document.getElementById('product_id');
        const quantityInput = document.getElementById('quantity');
        const stockInfo = document.getElementById('stock-info');
        const currentStockSpan = document.getElementById('current-stock');
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

        function actualizarStockInfo() {
            const selectedProductId = productSelect.value;
            
            if (selectedProductId && productsData[selectedProductId]) {
                stockInfo.style.display = 'block';
                const stock = stockData[selectedProductId] || 0.00;
                const unit = productsData[selectedProductId].unidad_medida;

                currentStockSpan.textContent = `${parseFloat(stock).toFixed(2)} ${unit}`;
                quantityLabel.textContent = `Cantidad que Sale (${unit}):`;
            } else {
                stockInfo.style.display = 'none';
                currentStockSpan.textContent = '--';
                quantityLabel.textContent = 'Cantidad que Sale:';
            }

            validarStockEnVivo(); 
        }


        function validarStockEnVivo() {
            const selectedProductId = productSelect.value;
            const requestedQuantity = parseFloat(quantityInput.value);
            
            if (selectedProductId) {
                const availableStock = stockData[selectedProductId] || 0.00;
                
                if (requestedQuantity > availableStock) {
                    quantityInput.setCustomValidity(`La cantidad solicitada excede el stock disponible (${availableStock.toFixed(2)}).`);
                } else {
                    quantityInput.setCustomValidity(''); 
                }
            } else {
                 quantityInput.setCustomValidity('');
            }
        }

        productSelect.addEventListener('change', actualizarStockInfo);
        quantityInput.addEventListener('input', validarStockEnVivo); 

        actualizarStockInfo(); 
        validarStockEnVivo();
    });
</script>
@endsection
