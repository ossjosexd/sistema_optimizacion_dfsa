@extends('dashboard')

@section('contenido')
    
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
        <h2>Reporte de Stock Crítico</h2>
        <div>
            <a href="{{ route('opcion.reportes') }}" class="btn btn-secondary">Volver al Menú de Reportes</a>
        </div>
    </div>
    <p>Listado de productos cuyo stock actual es igual o inferior al mínimo definido.</p>
    <hr>

    <div class="table-container">
        
        <table class="tabla-moderna">
            <thead>
                <tr>
                    <th>Numeración</th>
                    <th>Descripción</th>
                    <th>Modelo</th>
                    <th>Unidad</th>
                    <th style="text-align: center; background-color: #fff3cd; color: #856404;">Stock Mínimo</th> 
                    <th style="text-align: center; background-color: #f8d7da; color: #721c24;">Stock Actual</th> 
                </tr>
            </thead>
            
            <tbody>
                @forelse ($productosCriticos as $producto)
                    <tr>
                        <td>{{ $producto->numeracion }}</td>
                        <td>{{ $producto->descripcion }}</td>
                        <td>{{ $producto->modelo }}</td>
                        <td>{{ $producto->unidad_medida }}</td>
                        <td style="text-align: center; font-weight: bold; background-color: #fff9e0;">
                            {{ number_format($producto->stock_minimo, 2) }}
                        </td>
                        <td style="text-align: center; font-weight: bold; background-color: #fde8e9;">
                            {{ number_format($producto->stock_actual, 2) }} 
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="fila-vacia"> 
                            ¡Buenas noticias! No hay productos en nivel de stock crítico.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    </div>
    
@endsection

@push('styles')
<style>
.btn-secondary {
    display: inline-block; 
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-weight: bold;
    text-align: center;
    text-decoration: none;
    background-color: #6c757d; /* Color gris */
    color: white;
    transition: background-color 0.2s ease;
}
.btn-secondary:hover {
    background-color: #5a6268;
    color: white;
}
</style>
@endpush
