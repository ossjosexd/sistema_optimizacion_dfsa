@extends('dashboard')

@section('contenido')
    
    <h2>Registrar Nueva Entrada de Inventario</h2>
    <p>Completa los datos para registrar un ingreso de producto al stock.</p>
    <hr>

    <div class="form-container" style="max-width: 600px; margin: 0 auto;">
        
        <form action="{{ route('movements.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="search_product">Buscar Producto:</label>
                <input type="text" id="search_product" class="form-control" placeholder="Escribe para buscar un producto..." autofocus>
            </div>
            
            <div class="form-group">
                <label for="product_id">Producto Seleccionado:</label>
                <select id="product_id" name="product_id" class="form-control" required>
                    <option value="" disabled selected>Selecciona un producto...</option>
                </select>
                @error('product_id')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div id="dimensiones-section" style="display: none; border: 1px dashed #ccc; padding: 15px; margin-bottom: 15px; border-radius: 4px;">
                <p style="margin-top: 0; font-weight: bold; color: #555;">Dimensiones (para productos en m²):</p>
                <div class="form-row-grid" style="grid-template-columns: 1fr 1fr;">
                    <div class="form-group">
                        <label for="largo_m">Largo (m):</label>
                        <input type="number" step="any" id="largo_m" name="largo_m" class="form-control dimension-input" placeholder="Ej: 10.5" min="0">
                        @error('largo_m') <span class="error-message">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="ancho_mm">Ancho (mm):</label>
                        <input type="number" step="any" id="ancho_mm" name="ancho_mm" class="form-control dimension-input" placeholder="Ej: 1200" min="0">
                        @error('ancho_mm') <span class="error-message">{{ $message }}</span> @enderror
                    </div>
                </div>
                 <div class="form-group" style="margin-top: 10px;">
                    <label for="metros_cuadrados">Metros Cuadrados Calculados (m²):</label>
                    <input type="text" id="metros_cuadrados" class="form-control" readonly style="background-color: #e9ecef; font-weight: bold;">
                </div>
            </div>

            <div class="form-group">
                <label for="quantity" id="quantity-label">Cantidad que Entra:</label>
                <input type="number" step="any" id="quantity" name="quantity" class="form-control" placeholder="Ej: 50 o 12.60" value="{{ old('quantity') }}" required min="0.01" readonly style="background-color: #e9ecef;">
                @error('quantity') <span class="error-message">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="movement_date">Fecha de Entrada:</label>
                <input type="date" id="movement_date" name="movement_date" class="form-control" value="{{ old('movement_date', date('Y-m-d')) }}" required>
                @error('movement_date') <span class="error-message">{{ $message }}</span> @enderror
            </div>

             <div class="form-group">
                <label for="notes">Notas / Observaciones (Opcional):</label>
                <textarea id="notes" name="notes" class="form-control" rows="3">{{ old('notes') }}</textarea>
                @error('notes') <span class="error-message">{{ $message }}</span> @enderror
            </div>

            <div class="form-group" style="margin-top: 20px;">
                <button type="submit" class="btn btn-primary w-100">
                     <i class="fa-solid fa-save"></i> Registrar Entrada
                </button>
            </div>

        </form>
    </div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        
        const productsData = JSON.parse(@json($productsData)); 
        const originalOptions = [];         
        const productSelect = document.getElementById('product_id');
        const searchInput = document.getElementById('search_product');
        const dimensionesSection = document.getElementById('dimensiones-section');
        const largoInput = document.getElementById('largo_m');
        const anchoInput = document.getElementById('ancho_mm');
        const m2Input = document.getElementById('metros_cuadrados');
        const quantityInput = document.getElementById('quantity');
        const quantityLabel = document.getElementById('quantity-label');
        const dimensionInputs = document.querySelectorAll('.dimension-input');

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
                originalOptions.push(option);
            }
        }
        populateProductSelect();

        searchInput.addEventListener('input', function() {
            const searchTerm = searchInput.value.toLowerCase();

            productSelect.innerHTML = '<option value="" disabled selected>Selecciona un producto...</option>';

            originalOptions.forEach(option => {
                const text = option.textContent.toLowerCase();
                if (text.includes(searchTerm)) {
                    productSelect.appendChild(option);
                }
            });

            if (productSelect.options.length === 2) {
                 productSelect.selectedIndex = 1;
                 actualizarVisibilidadCampos(); 
            } else {
                 actualizarVisibilidadCampos(); 
            }
        });


        function calcularMetrosCuadrados() {
            const largo = parseFloat(largoInput.value) || 0;
            const anchoMM = parseFloat(anchoInput.value) || 0;
            
            if (largo > 0 && anchoMM > 0) {
                const anchoM = anchoMM / 1000;
                const m2 = (largo * anchoM).toFixed(2);
                m2Input.value = m2;
                quantityInput.value = m2;
            } else {
                m2Input.value = '';
                quantityInput.value = ''; 
            }
        }

        function actualizarVisibilidadCampos() {
            const selectedProductId = productSelect.value;
            
            const setRequired = (isRequired) => {
                dimensionInputs.forEach(input => {
                    if (isRequired) {
                        input.setAttribute('required', 'required');
                        input.style.backgroundColor = 'white';
                    } else {
                        input.removeAttribute('required');
                        input.value = ''; 
                    }
                });
            };

            const toggleQuantityReadOnly = (isReadOnly, labelText, backgroundColor) => {
                quantityInput.readOnly = isReadOnly;
                quantityInput.style.backgroundColor = backgroundColor;
                quantityLabel.textContent = labelText;
                if (!isReadOnly) {
                    quantityInput.value = '';
                }
            };


            if (selectedProductId && productsData[selectedProductId]) {
                const selectedProduct = productsData[selectedProductId];
                
                if (selectedProduct.unidad_medida === 'm2') {
                    dimensionesSection.style.display = 'block'; 
                    toggleQuantityReadOnly(true, 'Cantidad que Entra (m² CALCULADOS):', '#e9ecef');
                    setRequired(true);
                    calcularMetrosCuadrados();
                } else {
                    dimensionesSection.style.display = 'none'; 
                    toggleQuantityReadOnly(false, `Cantidad que Entra (Unidades):`, 'white');
                    setRequired(false);
                    largoInput.value = ''; 
                    anchoInput.value = '';
                    m2Input.value = '';
                }
            } else {
                dimensionesSection.style.display = 'none'; 
                toggleQuantityReadOnly(false, 'Cantidad que Entra:', 'white');
                setRequired(false);
            }
        }

        productSelect.addEventListener('change', actualizarVisibilidadCampos);
        largoInput.addEventListener('input', calcularMetrosCuadrados);
        anchoInput.addEventListener('input', calcularMetrosCuadrados);

        actualizarVisibilidadCampos(); 
    });
</script>
@endsection
