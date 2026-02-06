<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Historial de Cliente - {{ $client->nombre_empresa }}</title>
    <style>
        body { font-family: sans-serif; margin: 25px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { margin: 0; }
        .header p { margin: 5px 0 20px; font-size: 14px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; font-size: 12px; }
        th { background-color: #f2f2f2; }
        .info-cliente { margin-bottom: 20px; font-size: 14px; }
        .text-danger { color: #dc3545; }
    </style>
</head>
<body>

    <div class="header">
        <h1>Historial de salidas por Cliente</h1>
        <p>Fecha de Emisión: {{ now()->format('d/m/Y') }}</p>
    </div>

    <div class="info-cliente">
        <strong>Cliente:</strong> {{ $client->nombre_empresa }}<br>
        <strong>RIF:</strong> {{ $client->rif }}<br>
        <strong>Contacto:</strong> {{ $client->nombre_contacto }}<br>
        <strong>Teléfono:</strong> {{ $client->telefono }}
    </div>

    <hr>
    
    <table>
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Producto</th>
                <th>Modelo</th>
                <th>Cantidad</th>
                <th>Observación</th>
            </tr>
        </thead>
        <tbody>
            @forelse($salidas as $salida)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($salida->movement_date)->format('d/m/Y') }}</td>

                    @if($salida->product)
                        <td>{{ $salida->product->descripcion }}</td>
                        <td>{{ $salida->product->modelo ?? '-' }}</td>
                    @else
                        <td class="text-danger">
                            <em>Producto Eliminado (ID: {{ $salida->product_id }})</em>
                        </td>
                        <td>-</td>
                    @endif

                    <td>{{ number_format($salida->quantity, 2) }}</td>

                    <td>{{ $salida->notes ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center;">Este cliente no tiene historial de compras registrado.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>