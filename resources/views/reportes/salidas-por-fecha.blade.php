@extends('dashboard')

@section('contenido')
    
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
        <h2>Reporte de Salidas por Fecha</h2>
        <div>
            <a href="{{ route('opcion.reportes') }}" class="btn btn-secondary">Volver al Menú de Reportes</a>
        </div>
    </div>
    <p>Listado de productos despachados a clientes en un rango de fechas específico.</p>
    <hr>

    <form method="GET" action="{{ route('reportes.salidasPorFecha') }}" class="form-layout-dos-columnas" style="margin-bottom: 20px;">
        <div class="form-group">
            <label for="fecha_inicio">Fecha Desde:</label>
            <input type="date" id="fecha_inicio" name="fecha_inicio" class="form-control" value="{{ $fechaInicio }}">
        </div>
        <div class="form-group">
            <label for="fecha_fin">Fecha Hasta:</label>
            <input type="date" id="fecha_fin" name="fecha_fin" class="form-control" value="{{ $fechaFin }}">
        </div>
        <div class="form-group-button" style="text-align: left;">
            <button type="submit" class="btn btn-primary">
                <i class="fa-solid fa-filter"></i> Filtrar Fechas
            </button>
        </div>
    </form>

    <div class="table-container">
        
        <table class="tabla-moderna">
            <thead>
                <tr>
                    <th style="width: 80px;">Fecha</th>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Cliente</th>
                    <th>Usuario</th>
                    <th>Notas</th>
                </tr>
            </thead>
            
            <tbody>
                @forelse ($salidas as $salida)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($salida->movement_date)->format('d/m/y') }}</td>
                        <td>{{ optional($salida->product)->descripcion ?? 'N/A' }}</td>
                        <td>{{ number_format($salida->quantity, 2) }}</td>
                        <td class="columna-fija-lg">{{ optional($salida->client)->nombre_empresa ?? 'N/A' }}</td>
                        <td>{{ explode(' ', optional($salida->user)->name)[0] ?? 'N/A' }}</td>
                        <td style="text-align: center;">
                             @if (!empty($salida->notes))
                                <button onclick="showNotes('{{ addslashes($salida->notes) }}')" 
                                        class="btn-icon" 
                                        title="Ver Nota Completa" 
                                        style="color: #007bff;">
                                    <i class="fa-solid fa-file-alt"></i>
                                </button>
                            @else
                                N/A
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="fila-vacia"> 
                            No hay salidas registradas en el rango de fechas seleccionado.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div style="margin-top: 20px;">
            {{ $salidas->links() }}
        </div>

    </div>

<script>
function showNotes(notes) {
    Swal.fire({
        title: 'Nota de la Salida',
        html: `<p style="text-align: left; white-space: pre-wrap;">${notes}</p>`, 
        icon: 'info',
        confirmButtonText: 'Cerrar',
        width: 600, 
    });
}
</script>
@endsection