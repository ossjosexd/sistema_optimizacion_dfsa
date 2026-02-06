<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Client;
use App\Models\InventoryMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ProductoController extends Controller
{
    public function dashboardIndex()
    {
        $totalProductos = Product::count();
        $totalClientes = Client::count();
        $movimientosHoy = InventoryMovement::whereDate('created_at', today())->count();

        // Cálculo de productos con stock crítico
        $stockActual = DB::table('inventory_movements')
            ->select('product_id', DB::raw('
                SUM(CASE WHEN type IN ("entrada", "ajuste_positivo") THEN quantity ELSE 0 END) - 
                SUM(CASE WHEN type IN ("salida", "ajuste_negativo") THEN quantity ELSE 0 END) as stock_total
            '))
            ->groupBy('product_id')
            ->pluck('stock_total', 'product_id');

        $productosCriticosCount = Product::where('stock_minimo', '>', 0)
            ->get()
            ->filter(function ($producto) use ($stockActual) {
                $stock = $stockActual[$producto->id] ?? 0;
                return $stock <= $producto->stock_minimo;
            })
            ->count();

        return view('dashboard', compact(
            'totalProductos', 
            'totalClientes', 
            'movimientosHoy', 
            'productosCriticosCount'
        ));
    }

    public function index(Request $request)
    {
        $search = $request->input('buscar');
        
        $query = Product::orderBy('numeracion');

        if ($search) {
            $query->where('descripcion', 'LIKE', "%{$search}%");
        }

        $products = $query->get();

        // Cálculo de stock para la vista
        $stockData = DB::table('inventory_movements')
            ->select('product_id', DB::raw('
                SUM(CASE WHEN type IN ("entrada", "ajuste_positivo") THEN quantity ELSE 0 END) - 
                SUM(CASE WHEN type IN ("salida", "ajuste_negativo") THEN quantity ELSE 0 END) as stock_total
            '))
            ->whereIn('product_id', $products->pluck('id'))
            ->groupBy('product_id')
            ->pluck('stock_total', 'product_id');

        return view('consultar-productos', compact('products', 'stockData', 'search'));
    }

    public function create()
    {
        return view('agregar-producto');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'descripcion'   => 'required|string',
            'modelo'        => 'nullable|string',
            'unidad_medida' => 'required',
            'fecha'         => 'required|date',
            'stock_minimo'  => 'required|numeric|min:0',
            'imagen'        => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', 
        ]);

        $product = new Product($request->except('imagen'));

        if ($request->hasFile('imagen')) {
            $file = $request->file('imagen');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('img/productos'), $filename);
            
            $product->imagen = 'img/productos/' . $filename;
        }

        $product->save();

        return redirect()->route('opcion.consultar')
            ->with('success', '¡Producto guardado exitosamente!');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id); 
        return view('editar-producto', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id); 

        $validated = $request->validate([
            'descripcion'      => 'required|string',
            'modelo'           => 'nullable|string',
            'unidad_medida'    => 'required',
            'fecha'            => 'required|date',
            'stock_minimo'     => 'required|numeric|min:0',
            'ficha_fabricante' => 'nullable|url',
            'imagen'           => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', 
        ]);

        $product->fill($request->except('imagen'));

        if ($request->hasFile('imagen')) {
            // Eliminar imagen anterior si existe
            if ($product->imagen && File::exists(public_path($product->imagen))) {
                File::delete(public_path($product->imagen));
            }

            $file = $request->file('imagen');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('img/productos'), $filename);

            $product->imagen = 'img/productos/' . $filename;
        }

        $product->save();

        return redirect()->route('opcion.consultar')
            ->with('success', '¡Producto actualizado exitosamente!');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        
        // Opcional: Eliminar la imagen física al borrar el producto
        if ($product->imagen && File::exists(public_path($product->imagen))) {
            File::delete(public_path($product->imagen));
        }
        
        $product->delete();
        
        return redirect()->route('opcion.consultar')
            ->with('success', '¡Producto eliminado exitosamente!');
    }

    public function reportes()
    {
        return view('reportes');
    }
}