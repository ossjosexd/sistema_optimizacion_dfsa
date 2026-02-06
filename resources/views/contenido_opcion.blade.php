@extends('dashboard')

@section('contenido')
    <h2>{{ $titulo ?? 'Opción del Menú' }}</h2>
    <div class="placeholder-box">
        <p>{{ $texto ?? 'Esta es una opción genérica del menú. Aquí se implementará la funcionalidad real.' }}</p>
    </div>
@endsection