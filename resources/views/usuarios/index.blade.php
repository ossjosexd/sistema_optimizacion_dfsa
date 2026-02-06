@extends('dashboard')

@section('contenido')
    
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
        <h2>Gestión de Usuarios</h2>
        <a href="{{ route('usuarios.create') }}" class="btn btn-primary">
             <i class="fa-solid fa-plus"></i> Crear Nuevo Usuario
        </a>
    </div>
    
    <p>Administra quién puede acceder al sistema y sus privilegios.</p>
    <hr>

    <div class="table-container">
        
        <table class="tabla-moderna">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Rol (Privilegio)</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            
            <tbody>
                @forelse ($users as $usuario) 
                    <tr>
                        <td>{{ $usuario->name }}</td>
                        <td>{{ $usuario->email }}</td>
                        <td>
                            <span class="role-badge role-{{ $usuario->role }}">
                                {{ $usuario->role == 'admin' ? 'Administrador' : 'Usuario' }}
                            </span>
                        </td>
                        
                        <td>
                            <a href="{{ route('usuarios.edit', $usuario) }}" class="btn-icon btn-edit" title="Editar">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            
                            <form action="{{ route('usuarios.destroy', $usuario->id) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('¿Estás seguro de que quieres eliminar a este usuario?');">
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
                        <td colspan="4" class="fila-vacia">
                            No hay usuarios registrados.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    </div>
@endsection
