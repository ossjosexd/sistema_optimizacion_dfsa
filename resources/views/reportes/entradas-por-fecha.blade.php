@extends('dashboard')

@section('contenido')
    
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
        <h2>Reporte de Entradas por Fecha</h2>
        <div>
            <a href="{{ route('opcion.reportes') }}" class="btn btn-secondary">Volver al Menú de Reportes</a>
        </div>
    </div>
    <p>Filtra los movimientos de entrada de inventario registrados en un rango de fechas específico.</p>
    <hr>

    <form method="GET" action="{{ route('reportes.entradasPorFecha') }}" class="form-layout-dos-columnas" style="margin-bottom: 30px;">

        <div class="form-group">
            <label for="fecha_inicio">Fecha Desde:</label>
            <input type="date" id="fecha_inicio" name="fecha_inicio" class="form-control" value="{{ $fechaInicio }}" required>
        </div>

        <div class="form-group">
            <label for="fecha_fin">Fecha Hasta:</label>
            <input type="date" id="fecha_fin" name="fecha_fin" class="form-control" value="{{ $fechaFin }}" required>
        </div>

        <div class="form-group-button form-group-full-width">
            <button type="submit" class="btn btn-primary">
                <i class="fa-solid fa-filter"></i> Filtrar Entradas
            </button>
        </div>
    </form>

    <div class="table-container">
        <p style="font-weight: bold;">Mostrando entradas desde {{ \Carbon\Carbon::parse($fechaInicio)->format('d/m/Y') }} hasta {{ \Carbon\Carbon::parse($fechaFin)->format('d/m/Y') }}</p>
        
        <table class="tabla-moderna">
            <thead>
                <tr>
                    <th style="width: 100px;">Fecha Entrada</th>
                    <th class="columna-fija-lg">Producto</th>
                    <th style="width: 80px;">Cantidad</th>
                    <th style="width: 100px;">Usuario Registró</th>
                    <th>Notas</th>
                </tr>
            </thead>
            
            <tbody>
                @forelse ($entradas as $entrada)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($entrada->movement_date)->format('d/m/y') }}</td>
                        <td class="columna-fija-lg">{{ optional($entrada->product)->descripcion ?? 'N/A' }}</td>
                        <td>{{ number_format($entrada->quantity, 2) }}</td>
                        <td>{{ explode(' ', optional($entrada->user)->name)[0] ?? 'N/A' }}</td>
                        <td class="columna-corta" title="{{ $entrada->notes }}"> 
                            @if (!empty($entrada->notes))
                                <button onclick="showNotes('{{ addslashes($entrada->notes) }}')" 
                                        class="btn-icon" 
                                        title="Ver Nota Completa" 
                                        style="color: #007bff; padding: 0; margin: 0;">
                                    <i class="fa-solid fa-file-alt"></i>
                                </button>
                                {{ Str::limit($entrada->notes, 30) }} 
                            @else
                                N/A
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="fila-vacia">
                            No se encontraron entradas en el rango de fechas seleccionado.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div style="margin-top: 20px;">
            {{ $entradas->links() }}
        </div>

    </div>

<script>
function showNotes(notes) {
    Swal.fire({
        title: 'Nota del Movimiento',
        html: `<p style="text-align: left; white-space: pre-wrap;">${notes}</p>`, 
        icon: 'info',
        confirmButtonText: 'Cerrar',
        width: 600, 
    });
}
</script>
@php use Illuminate\Support\Str; @endphp

@endsection

@push('styles')
<style>
.btn-secondary { display: inline-block; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; text-align: center; text-decoration: none; background-color: #6c757d; color: white; transition: background-color 0.2s ease; }
.btn-secondary:hover { background-color: #5a6268; color: white; }
.columna-corta { cursor: help; } 
</style>
@endpush