@extends('dashboard')

@section('contenido')
    <h2>Reporte de Historial por Cliente</h2>
    <p>Selecciona un cliente para generar un listado de todos los productos que ha comprado (salidas de inventario).</p>
    
    <hr>

    <div class="form-container">
        <form method="GET" action="{{ route('reportes.pdf.historialCliente') }}" target="_blank">
            
            <div class="form-group">
                <label for="client_id">Cliente:</label>
                <select name="client_id" id="client_id" class="form-control" required>
                    <option value="">-- Seleccione un cliente --</option>
                    @foreach($clients as $client)
                        <option value="{{ $client->id }}">
                            {{ $client->nombre_empresa }} ({{ $client->rif }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group" style="text-align: right; margin-top: 20px;">
                
                <a href="{{ route('opcion.reportes') }}" class="btn btn-secondary">Cancelar</a>
                
                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-file-pdf"></i> Generar Reporte
                </button>
            </div>

        </form>
    </div>
@endsection