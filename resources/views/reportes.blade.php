@extends('dashboard')

@section('contenido')
    
    <h2>Módulo de Reportes</h2>
    <p>Selecciona el tipo de reporte que deseas generar.</p>
    <hr>

    <div class="report-card-container">

        <a href="{{ route('reportes.inventarioGeneral') }}" class="report-card"> 
            <i class="fa-solid fa-boxes-stacked card-icon"></i>
            <span class="card-title">Inventario General</span>
            <p class="card-description">Ver un resumen completo de todos los productos y su stock actual.</p>
        </a>

        <a href="{{ route('reportes.entradasPorFecha') }}" class="report-card">
            <i class="fa-solid fa-calendar-plus card-icon"></i>
            <span class="card-title">Reporte de Entradas</span>
            <p class="card-description">Generar un listado de productos ingresados en un rango de fechas.</p>
        </a>

        <a href="{{ route('reportes.salidasPorFecha') }}" class="report-card">
            <i class="fa-solid fa-truck-fast card-icon"></i>
            <span class="card-title">Reporte de Salidas</span>
            <p class="card-description">Ver todos los materiales despachados a clientes en un rango de fechas.</p>
        </a>

        <a href="{{ route('reportes.formCliente') }}" class="report-card">
            <i class="fa-solid fa-boxes-stacked card-icon"></i>
            <span class="card-title">Reporte por Cliente</span>
            <p class="card-description">Ver el historial de compras y productos despachados para un cliente específico.</p>
        </a>
        <a href="{{ route('reportes.stockCritico') }}" class="report-card">
            <i class="fa-solid fa-triangle-exclamation card-icon" style="color: #dc3545;"></i> 
            <span class="card-title">Reporte de Stock Crítico</span>
            <p class="card-description">Listar productos cuyo stock actual es igual o inferior al mínimo definido.</p>
        </a>


    </div>

@endsection