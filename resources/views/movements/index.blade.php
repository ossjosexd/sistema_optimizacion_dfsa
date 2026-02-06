@extends('dashboard')

@section('contenido')
    
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
        <h2>Historial de Movimientos de Inventario</h2>
        <div>
            <a href="{{ route('movements.create') }}" class="btn btn-primary" style="margin-right: 5px;">
                <i class="fa-solid fa-plus"></i> Nueva Entrada
            </a>
            
            <a href="{{ route('movements.createSalida') }}" class="btn btn-warning" style="margin-right: 5px; background-color: #ffc107; color: #333;">
                <i class="fa-solid fa-minus"></i> Nueva Salida
            </a>

            <a href="{{ route('movements.createAjuste') }}" class="btn" style="background-color: #17a2b8; color: white;"> 
                <i class="fa-solid fa-wrench"></i> Realizar Ajuste
            </a>
        </div>
    </div>
    <p>Registro de todas las entradas, salidas y ajustes del inventario.</p>
    <hr>

    <div class="table-container">
        
        <table class="tabla-moderna">
            <thead>
                <tr>
                    <th style="width: 80px;">Fecha</th>
                    <th style="width: 70px;">Tipo</th>
                    <th class="columna-fija-lg">Producto</th>
                    <th style="width: 70px;">Cantidad</th>
                    <th style="width: 80px;">Usuario</th> 
                    <th class="columna-fija-lg">Cliente</th>
                    <th style="width: 50px;">Notas</th> 
                    <th style="width: 50px;">Acciones</th>
                </tr>
            </thead>
            
            <tbody>
                @forelse ($movements as $movement)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($movement->movement_date)->format('d/m/y') }}</td>
                        <td>
                            <span class="badge movement-{{ $movement->type }}">
                                @switch($movement->type)
                                    @case('entrada') Entrada @break
                                    @case('salida') Salida @break
                                    @case('ajuste_positivo') Ajuste + @break
                                    @case('ajuste_negativo') Ajuste - @break
                                    @default {{ $movement->type }}
                                @endswitch
                            </span>
                        </td>
                        <td class="columna-fija-lg">{{ optional($movement->product)->descripcion ?? 'N/A' }}</td>
                        <td>{{ number_format($movement->quantity, 2) }}</td> 
                        
                        <td>{{ explode(' ', optional($movement->user)->name)[0] ?? 'N/A' }}</td>
                        
                        <td class="columna-fija-lg">{{ optional($movement->client)->nombre_empresa ?? 'N/A' }}</td>
                        
                        <td style="text-align: center;">
                            @if (!empty($movement->notes))
                                <button onclick="showNotes('{{ addslashes($movement->notes) }}')" 
                                        class="btn-icon" 
                                        title="Ver Nota Completa" 
                                        style="color: #007bff;">
                                    <i class="fa-solid fa-file-alt"></i>
                                </button>
                            @else
                                N/A
                            @endif
                        </td>

                        <td>
                            @if ($movement->type == 'entrada' || $movement->type == 'salida')
                                <a href="{{ route('movements.edit', $movement) }}" class="btn-icon btn-edit" title="Editar Movimiento">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                            @endif
                            
                            <form action="{{ route('movements.destroy', $movement) }}" method="POST" style="display: inline-block;" class="delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-icon btn-delete" title="Eliminar Movimiento">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="fila-vacia">
                            No hay movimientos registrados.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div style="margin-top: 20px;">
            {{ $movements->links() }}
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
@endsection