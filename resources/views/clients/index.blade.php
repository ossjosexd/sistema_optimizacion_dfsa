@extends('dashboard')

@section('contenido')
    
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
        <h2>Gestión de Clientes</h2>
        
        <div>
            <a href="{{ route('reportes.pdf.allClients') }}" class="btn btn-secondary" target="_blank" title="Reporte General PDF">
                <i class="fa-solid fa-list-alt"></i> Reporte General
            </a>
            <a href="{{ route('clients.create') }}" class="btn btn-primary" style="margin-left: 5px;">
                <i class="fa-solid fa-plus"></i> Nuevo Cliente
            </a>
        </div>
        </div>
    <p>Administra la información de contacto y RIF de tus clientes.</p>
    
    <form method="GET" action="{{ route('clients.index') }}" class="mb-3">
        <div class="search-bar-group"> 
            <input type="text" name="buscar" class="form-control search-input" placeholder="Buscar por Nombre o RIF..." value="{{ $searchTerm ?? '' }}">
            <button class="btn btn-primary search-button" type="submit">Buscar</button>
            @if(isset($searchTerm) && $searchTerm)
                <a href="{{ route('clients.index') }}" class="btn btn-secondary clear-button" style="margin-left: 5px;">Limpiar</a>
            @endif
        </div>
    </form>

    <hr> 

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>

        @push('styles')
        <style>.alert-danger { background-color: #f8d7da; border-color: #f5c6cb; color: #721c24; padding: .75rem 1.25rem; margin-bottom: 1rem; border: 1px solid transparent; border-radius: .25rem; }</style>
        @endpush
    @endif


    <div class="table-container">
        
        <table class="tabla-moderna">
            <thead>
                <tr>
                    <th class="columna-fija-lg">Nombre Empresa</th> 
                    <th>RIF</th>
                    <th>Teléfono</th>
                    <th>Email</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            
            <tbody>
                @forelse ($clients as $client)
                    <tr>
                        <td class="columna-fija-lg">{{ $client->nombre_empresa }}</td>
                        <td>{{ $client->rif }}</td>
                        <td>{{ $client->telefono ?? 'N/A' }}</td>
                        <td>{{ $client->email ?? 'N/A' }}</td>
                        
                        <td>
                            <a href="{{ route('reportes.pdf.clientFicha', $client) }}" class="btn-icon btn-pdf" title="Ver Ficha PDF" target="_blank">
                                <i class="fa-solid fa-file-pdf"></i>
                            </a>

                            <a href="{{ route('clients.edit', $client) }}" class="btn-icon btn-edit" title="Editar Cliente">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>


                            <form action="{{ route('clients.destroy', $client) }}" method="POST" style="display: inline-block;" class="delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-icon btn-delete" title="Eliminar Cliente">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="fila-vacia">
                            @if(isset($searchTerm) && $searchTerm)
                                No se encontraron clientes que coincidan con "{{ $searchTerm }}".
                            @else
                                No hay clientes registrados.
                            @endif
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div style="margin-top: 20px;">
            {{ $clients->appends(request()->query())->links() }} 
        </div>

    </div>
@endsection