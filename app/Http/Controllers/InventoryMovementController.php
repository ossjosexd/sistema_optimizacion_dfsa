<?php

namespace App\Http\Controllers;

use App\Models\InventoryMovement;
use App\Models\Product;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 

class InventoryMovementController extends Controller
{
    public function index()
    {
        $movements = InventoryMovement::with(['product', 'user', 'client'])
            ->latest('movement_date')
            ->latest('id')
            ->paginate(15); 

        return view('movements.index', compact('movements'));
    }

    public function create()
    {
        $productsData = Product::orderBy('descripcion')
            ->get(['id', 'descripcion', 'unidad_medida'])
            ->keyBy('id')
            ->toJson();

        return view('movements.create', [
            'productsData'  => $productsData,
            'movement_type' => 'entrada' 
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id'    => 'required|exists:products,id', 
            'quantity'      => 'required|numeric|min:0.01',
            'movement_date' => 'required|date',
            'notes'         => 'nullable|string',
        ]);

        InventoryMovement::create([
            ...$validated,
            'user_id' => Auth::id(),
            'type'    => 'entrada',
        ]);
        
        return redirect()->route('movements.index')
            ->with('success', '¡Entrada de inventario registrada exitosamente!');
    }

    public function createSalida()
    {
        $productsData = Product::orderBy('descripcion')
            ->get(['id', 'descripcion', 'unidad_medida'])
            ->keyBy('id')
            ->toJson();

        $stockData = DB::table('inventory_movements')
            ->select('product_id', DB::raw('
                SUM(CASE WHEN type IN ("entrada", "ajuste_positivo") THEN quantity ELSE 0 END) - 
                SUM(CASE WHEN type IN ("salida", "ajuste_negativo") THEN quantity ELSE 0 END) as stock_total
            '))
            ->groupBy('product_id')
            ->pluck('stock_total', 'product_id')
            ->toJson();
        
        $clients = Client::orderBy('nombre_empresa')->pluck('nombre_empresa', 'id');

        return view('movements.salida', compact('productsData', 'stockData', 'clients'));
    }

    public function storeSalida(Request $request)
    {
        $validated = $request->validate([
            'product_id'    => 'required|exists:products,id', 
            'client_id'     => 'required|exists:clients,id',
            'quantity'      => 'required|numeric|min:0.01',
            'movement_date' => 'required|date',
            'notes'         => 'nullable|string',
        ]);

        $stockTotal = DB::table('inventory_movements')
            ->where('product_id', $validated['product_id'])
            ->select(DB::raw('
                SUM(CASE WHEN type IN ("entrada", "ajuste_positivo") THEN quantity ELSE 0 END) - 
                SUM(CASE WHEN type IN ("salida", "ajuste_negativo") THEN quantity ELSE 0 END) as stock_total
            '))
            ->value('stock_total');

        if ($validated['quantity'] > $stockTotal) {
            return back()
                ->withErrors(['quantity' => "La cantidad solicitada ({$validated['quantity']}) excede el stock disponible ({$stockTotal})."])
                ->withInput();
        }
        
        InventoryMovement::create([
            ...$validated,
            'user_id' => Auth::id(),
            'type'    => 'salida',
        ]);
        
        return redirect()->route('movements.index')
            ->with('success', '¡Salida registrada y cliente asignado exitosamente!');
    }

    public function createAjuste()
    {
        $productsData = Product::orderBy('descripcion')
            ->get(['id', 'descripcion', 'unidad_medida'])
            ->keyBy('id')
            ->toJson();

        return view('movements.ajuste', compact('productsData'));
    }

    public function storeAjuste(Request $request)
    {
        $validated = $request->validate([
            'product_id'      => 'required|exists:products,id', 
            'quantity'        => 'required|numeric|min:0.01',
            'movement_date'   => 'required|date',
            'adjustment_type' => 'required|in:ajuste_positivo,ajuste_negativo', 
            'notes'           => 'required|string|min:5', 
        ]);

        if ($validated['adjustment_type'] == 'ajuste_negativo') {
            $stockTotal = DB::table('inventory_movements')
                ->where('product_id', $validated['product_id'])
                ->select(DB::raw('
                    SUM(CASE WHEN type IN ("entrada", "ajuste_positivo") THEN quantity ELSE 0 END) - 
                    SUM(CASE WHEN type IN ("salida", "ajuste_negativo") THEN quantity ELSE 0 END) as stock_total
                '))
                ->value('stock_total');

            if ($validated['quantity'] > $stockTotal) {
                return back()
                    ->withErrors(['quantity' => "El ajuste ({$validated['quantity']}) excede el stock disponible ({$stockTotal})."])
                    ->withInput();
            }
        }

        InventoryMovement::create([
            'product_id'    => $validated['product_id'],
            'user_id'       => Auth::id(),
            'type'          => $validated['adjustment_type'], 
            'quantity'      => $validated['quantity'],
            'movement_date' => $validated['movement_date'],
            'notes'         => $validated['notes'],
        ]);
        
        return redirect()->route('movements.index')
            ->with('success', '¡Ajuste de inventario registrado exitosamente!');
    }

    public function edit(InventoryMovement $movement)
    {
        if (!in_array($movement->type, ['entrada', 'salida'])) {
            return redirect()->route('movements.index')
                ->with('error', 'Solo se pueden editar entradas o salidas.');
        }

        $productsData = Product::orderBy('descripcion')
            ->get(['id', 'descripcion', 'unidad_medida'])
            ->keyBy('id')
            ->toJson();
            
        $clients = Client::orderBy('nombre_empresa')->pluck('nombre_empresa', 'id');

        return view('movements.edit', compact('movement', 'productsData', 'clients'));
    }

    public function update(Request $request, InventoryMovement $movement)
    {
        $validated = $request->validate([
            'product_id'    => 'required|exists:products,id', 
            'client_id'     => 'nullable|exists:clients,id',
            'quantity'      => 'required|numeric|min:0.01',
            'movement_date' => 'required|date',
            'notes'         => 'nullable|string',
        ]);
        
        $movement->update($validated);
        
        return redirect()->route('movements.index')
            ->with('success', '¡Movimiento actualizado exitosamente!');
    }

    public function destroy(InventoryMovement $movement)
    {
        $movement->delete();
        
        return redirect()->route('movements.index')
            ->with('success', '¡Movimiento eliminado exitosamente!');
    }
    
    public function show(InventoryMovement $inventoryMovement)
    {
        //
    } 
    
    public function reportes()
    {
        return view('reportes');
    } 
}