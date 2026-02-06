<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\InventoryMovementController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\PdfReportController;

// RUTAS DE AUTENTICACIÓN
Route::controller(AuthController::class)->group(function () {
    Route::get('/', 'showLogin')->name('login');
    Route::post('/login', 'doLogin')->name('do.login');
    Route::get('/crear-cuenta', 'showCrearCuenta')->name('crear.cuenta');
    Route::post('/crear-cuenta', 'doCrearCuenta')->name('do.crear');
    
    // Rutas de Recuperación (por código)
    Route::get('/recuperar-contrasena', 'showRecuperar')->name('password.request');
    Route::post('/recuperar-contrasena', 'sendRecoveryCode')->name('password.email');
    Route::get('/reset-password', 'showResetForm')->name('password.reset.form');
    Route::post('/reset-password', 'doResetPassword')->name('password.update');
    
    // RUTA PARA CERRAR SESIÓN
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// RUTAS DEL SISTEMA (Protegidas por Auth)
Route::middleware(['auth'])->prefix('sistema')->group(function () {
    
    // Dashboard (Home)
    Route::get('/dashboard', [ProductoController::class, 'dashboardIndex'])->name('dashboard');

    // --- RUTAS DE PRODUCTOS (CRUD) ---
    Route::resource('productos', ProductoController::class)
        ->except(['show'])
        ->names([
            'index'   => 'opcion.consultar',
            'create'  => 'opcion.agregar',
            'store'   => 'productos.store',
            'edit'    => 'productos.edit',
            'update'  => 'productos.update',
            'destroy' => 'productos.destroy'
        ]);

    // --- RUTAS DE CLIENTES (CRUD) ---
    Route::resource('clients', ClientController::class)
        ->except(['show'])
        ->parameters(['clients' => 'client'])
        ->names('clients');

    // --- RUTAS DE USUARIOS (CRUD) ---
    Route::resource('usuarios', UserController::class)
        ->except(['show'])
        ->parameters(['usuarios' => 'usuario'])
        ->names('usuarios');

    // --- RUTAS DE MOVIMIENTOS ---
    Route::resource('movements', InventoryMovementController::class)
        ->except(['show'])
        ->names('movements');

    // Rutas Adicionales de Movimientos
    Route::get('movements/salida/create', [InventoryMovementController::class, 'createSalida'])->name('movements.createSalida');
    Route::post('movements/salida', [InventoryMovementController::class, 'storeSalida'])->name('movements.storeSalida');
    Route::get('movements/ajuste/create', [InventoryMovementController::class, 'createAjuste'])->name('movements.createAjuste');
    Route::post('movements/ajuste', [InventoryMovementController::class, 'storeAjuste'])->name('movements.storeAjuste');

    // --- RUTAS DE REPORTES ---
    Route::get('/reportes', [ProductoController::class, 'reportes'])->name('opcion.reportes');
    Route::get('/reportes/inventario-general', [ReportController::class, 'inventoryGeneral'])->name('reportes.inventarioGeneral');
    Route::get('/reportes/entradas-por-fecha', [ReportController::class, 'entriesByDate'])->name('reportes.entradasPorFecha');
    Route::get('/reportes/salidas-por-fecha', [ReportController::class, 'salesByDate'])->name('reportes.salidasPorFecha');
    Route::get('/reportes/stock-critico', [ReportController::class, 'stockCritico'])->name('reportes.stockCritico');
    Route::get('/reportes/historial-cliente/{cliente}', [ReportController::class, 'generarHistorialCliente'])->name('reporte.historial.cliente');

    // RUTA PARA VER LOS MOVIMIENTOS DE UN PRODUCTO (recibe el ID del producto)
    Route::get('/reportes/movimientos-producto/{product}', [ReportController::class, 'generarMovimientosProducto'])->name('reporte.movimientos.producto');

    // --- REPORTES PDF ---
    Route::get('/reportes/pdf/clientes', [PdfReportController::class, 'allClients'])->name('reportes.pdf.allClients');
    Route::get('/reportes/pdf/clientes/{client}', [PdfReportController::class, 'clientFicha'])->name('reportes.pdf.clientFicha');

    // Ruta para mostrar el formulario de selección de cliente
    Route::get('/reportes/seleccionar-cliente', [PdfReportController::class, 'showFormCliente'])->name('reportes.formCliente');

    // Ruta que generará el PDF 
    Route::get('/reportes/pdf/historial-cliente', [PdfReportController::class, 'generarHistorialCliente'])->name('reportes.pdf.historialCliente');

    // Ruta PDF ficha técnica de producto
    Route::get('/reportes/pdf/productos/{product}/ficha', [PdfReportController::class, 'productFichaTecnica'])->name('reportes.pdf.productFichaTecnica');
});
