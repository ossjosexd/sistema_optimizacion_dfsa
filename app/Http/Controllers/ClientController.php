<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{

    public function index(Request $request)
    {
        $searchTerm = $request->input('buscar');
        $query = Client::orderBy('nombre_empresa');

        if ($searchTerm) {
            $query->where(function($q) use ($searchTerm) {
                $q->where('nombre_empresa', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('rif', 'LIKE', "%{$searchTerm}%");
            });
        }

        $clients = $query->paginate(15)->appends($request->query());

        return view('clients.index', compact('clients', 'searchTerm'));
    }

    public function create()
    {
        return view('clients.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre_empresa' => 'required|string|max:255',
            'rif'            => 'required|string|max:20|unique:clients,rif',
            'persona_contacto' => 'nullable|string|max:255', 
            'direccion'      => 'required|string',
            'telefono'       => 'nullable|string|max:20',
            'email'          => 'nullable|email|max:255', 
        ]);

        Client::create($validated);

        return redirect()->route('clients.index')
                         ->with('success', '¡Cliente creado exitosamente!');
    }

    public function edit(Client $client) 
    {
        return view('clients.edit', ['client' => $client]);
    }

    public function update(Request $request, Client $client)
    {
         $validated = $request->validate([
            'nombre_empresa' => 'required|string|max:255',
            'rif'            => 'required|string|max:20|unique:clients,rif,' . $client->id, 
            'persona_contacto' => 'nullable|string|max:255', 
            'direccion'      => 'required|string',
            'telefono'       => 'nullable|string|max:20',
            'email'          => 'nullable|email|max:255',
        ]);

        $client->update($validated);

        return redirect()->route('clients.index')
                         ->with('success', '¡Cliente actualizado exitosamente!');
    }

    public function destroy(Client $client)
    {
        try {
             $client->delete();
             return redirect()->route('clients.index')
                         ->with('success', '¡Cliente eliminado exitosamente!');
        } catch (\Illuminate\Database\QueryException $e) {
             return redirect()->route('clients.index')
                         ->with('error', 'No se puede eliminar el cliente porque tiene movimientos de inventario asociados.');
        }
    }
}