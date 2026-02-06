@extends('dashboard')

@section('contenido')
    
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
        <h2>Reporte de Inventario General</h2>
        <div>
            <a href="{{ route('opcion.reportes') }}" class="btn btn-secondary">Volver al Menú de Reportes</a>
        </div>
    </div>
    <p>Listado completo de productos y su stock actual calculado (Entradas - Salidas + Ajustes).</p>
    <hr>

    <div class="table-container">
        
        <table class="tabla-moderna">
            <thead>
                <tr>
                    <th>Numeración</th>
                    <th>Descripción</th>
                    <th>Modelo</th>
                    <th>Unidad</th>
                    <th style="text-align: center; background-color: #e9f5e9; color: #055038;">Stock Actual</th> 
                </tr>
            </thead>
            
            <tbody>
                @forelse ($productos as $producto)
                    <tr>
                        <td>{{ $producto->numeracion }}</td>
                        <td>{{ $producto->descripcion }}</td>
                        <td>{{ $producto->modelo }}</td>
                        <td>{{ $producto->unidad_medida }}</td>
                        <td style="text-align: center; font-weight: bold; background-color: #f3fdf3;">
                            {{ number_format($producto->stock_actual, 2) }} 
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="fila-vacia"> 
                            No hay productos registrados para mostrar en el inventario.
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
