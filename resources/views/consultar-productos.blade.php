@extends('dashboard')

@section('contenido')
    
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
        <h2>Consulta de Productos</h2>
        <a href="{{ route('opcion.agregar') }}" class="btn btn-primary">
            <i class="fa-solid fa-plus"></i> Nuevo Producto
        </a>
    </div>
    <p>Visualización de todos los artículos base registrados en el sistema.</p>

    <form method="GET" action="{{ route('opcion.consultar') }}" class="mb-3">
        <div class="search-bar-group"> 
            <input type="text" name="buscar" class="form-control search-input" placeholder="Buscar por descripción..." value="{{ $searchTerm ?? '' }}">
            <button class="btn btn-primary search-button" type="submit">Buscar</button>
            @if(isset($searchTerm) && $searchTerm)
                <a href="{{ route('opcion.consultar') }}" class="btn btn-secondary clear-button" style="margin-left: 5px;">Limpiar</a>
            @endif
        </div>
    </form>
    
    <hr> 

    <div class="table-container">
        
        <table class="tabla-moderna">
            <thead>
                <tr>
                    <th>Nro.</th>
                    <th>Descripción</th>
                    <th>Modelo</th>
                    <th>Unidad</th>
                    <th>Fecha Registro</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            
            <tbody>
                @forelse ($products as $product)
                    <tr>
                        <td>{{ $product ->numeracion }}</td> 
                        <td>{{ $product ->descripcion }}</td>
                        <td>{{ $product ->modelo }}</td>
                        <td>{{ $product ->unidad_medida }}</td>
                        <td>{{ $product ->fecha }}</td>
                        <td>
                            <a href="{{ route('reportes.pdf.productFichaTecnica', $product) }}" 
                               class="btn-icon btn-pdf" 
                               title="Ficha Técnica PDF" 
                               target="_blank">
                                <i class="fa-solid fa-file-pdf"></i>
                            </a>
                            <a href="{{ route('productos.edit', $product) }}" class="btn-icon btn-edit" title="Editar">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <form action="{{ route('productos.destroy', $product) }}" method="POST" style="display: inline-block;" class="delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-icon btn-delete" title="Eliminar">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="fila-vacia">
                            @if(isset($searchTerm) && $searchTerm)
                                No se encontraron productos que coincidan con "{{ $searchTerm }}".
                            @else
                                No hay productos registrados.
                            @endif
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    </div>
@endsection