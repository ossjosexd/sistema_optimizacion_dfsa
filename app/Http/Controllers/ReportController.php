<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\InventoryMovement; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 

class ReportController extends Controller
{
    public function inventoryGeneral()
    {
        $stockAggregates = DB::table('inventory_movements')
            ->select('product_id', DB::raw('
                SUM(CASE WHEN type IN ("entrada", "ajuste_positivo") THEN quantity ELSE 0 END) - 
                SUM(CASE WHEN type IN ("salida", "ajuste_negativo") THEN quantity ELSE 0 END) as stock_total
            '))
            ->groupBy('product_id');

        $productos = Product::query()
            ->leftJoinSub($stockAggregates, 'stock', function ($join) {
                $join->on('products.id', '=', 'stock.product_id');
            })
            ->select('products.*', 'stock.stock_total as stock_actual')
            ->orderBy('products.numeracion')
            ->get();
        
        $productos->each(function ($producto) {
            $producto->stock_actual = $producto->stock_actual ?? 0.00;
        });

        return view('reportes.inventario-general', compact('productos'));
    }

    public function entriesByDate(Request $request)
    {
        $fechaInicio = $request->input('fecha_inicio', now()->subMonth()->toDateString());
        $fechaFin = $request->input('fecha_fin', now()->toDateString());

        $entradas = InventoryMovement::with(['product', 'user']) 
            ->where('type', 'entrada')
            ->whereBetween('movement_date', [$fechaInicio, $fechaFin])
            ->orderBy('movement_date', 'desc')
            ->orderBy('id', 'desc')
            ->paginate(20)
            ->appends($request->query());

        return view('reportes.entradas-por-fecha', compact('entradas', 'fechaInicio', 'fechaFin'));
    }
    
    public function salesByDate(Request $request)
    {
        $fechaInicio = $request->input('fecha_inicio', now()->subMonth()->toDateString());
        $fechaFin = $request->input('fecha_fin', now()->toDateString());

        $salidas = InventoryMovement::with(['product', 'user', 'client'])
            ->where('type', 'salida')
            ->whereBetween('movement_date', [$fechaInicio, $fechaFin])
            ->orderBy('movement_date', 'desc')
            ->orderBy('id', 'desc')
            ->paginate(20)
            ->appends($request->query());

        return view('reportes.salidas-por-fecha', compact('salidas', 'fechaInicio', 'fechaFin'));
    }

    public function stockCritico()
    {
        $stockAggregates = DB::table('inventory_movements')
            ->select('product_id', DB::raw('
                SUM(CASE WHEN type IN ("entrada", "ajuste_positivo") THEN quantity ELSE 0 END) - 
                SUM(CASE WHEN type IN ("salida", "ajuste_negativo") THEN quantity ELSE 0 END) as stock_actual
            '))
            ->groupBy('product_id');

        $productosCriticos = Product::query()
            ->leftJoinSub($stockAggregates, 'stock', function ($join) {
                $join->on('products.id', '=', 'stock.product_id');
            })
            ->where('products.stock_minimo', '>', 0)
            ->whereRaw('COALESCE(stock.stock_actual, 0.00) <= products.stock_minimo') 
            ->select('products.*', 'stock.stock_actual') 
            ->orderBy('products.numeracion')
            ->get();
        
        return view('reportes.stock-critico', compact('productosCriticos'));
    }
}