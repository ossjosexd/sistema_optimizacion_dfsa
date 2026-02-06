<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Product;
use App\Models\InventoryMovement;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfReportController extends Controller
{
    public function allClients()
    {
        $clients = Client::orderBy('nombre_empresa')->get();
        
        $pdf = Pdf::loadView('reportes.pdf.clientes.all_clients', compact('clients'))
            ->setPaper('a4', 'landscape');
        
        return $pdf->stream('listado_clientes.pdf');
    }

    public function clientFicha(Client $client)
    {
        $pdf = Pdf::loadView('reportes.pdf.clientes.client_ficha', compact('client'));
        return $pdf->stream("ficha-cliente-{$client->id}.pdf");
    }

    public function showFormCliente()
    {
        $clients = Client::orderBy('nombre_empresa', 'asc')->get();
        return view('reportes.form_cliente', compact('clients'));
    }

    public function generarHistorialCliente(Request $request)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id'
        ]);

        $client = Client::findOrFail($validated['client_id']);

        $salidas = InventoryMovement::where('client_id', $client->id)
            ->where('type', 'salida') 
            ->with('product')
            ->orderBy('created_at', 'desc')
            ->get();

        $pdf = Pdf::loadView('reportes.pdf.clientes.historial_cliente', compact('client', 'salidas'));

        return $pdf->stream("historial-{$client->rif}.pdf");
    }
    
    public function productFichaTecnica(Product $product)
    {
        $pdf = Pdf::loadView('reportes.pdf.ficha_tecnica', compact('product')); 
        
        $filename = 'Ficha_Tecnica_' . ($product->modelo ?? $product->descripcion) . '.pdf';
        
        return $pdf->stream($filename);
    }
}