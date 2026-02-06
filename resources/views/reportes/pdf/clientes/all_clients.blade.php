<!DOCTYPE html>
<html>
<head>
    <title>Listado de Clientes</title>
    <style>
        @page {

            margin: 160px 30px 60px 30px;
            size: letter landscape;
        }

        body {
            font-family: sans-serif;
            font-size: 11px;
            color: #333;
        }

        header { 
            position: fixed; 
            top: -115px; 
            left: 0px; 
            right: 0px; 
            height: 100px; 
        }

        footer { 
            position: fixed; 
            bottom: -40px; 
            left: 0px; 
            right: 0px; 
            height: 40px; 
            text-align: center; 
            font-size: 15px; 
            
            color: #777; 
            border-top: 1px solid #ddd; 
            padding-top: 10px; 
        }

        .logo { 
            position: absolute; 
            left: 0px; 
            top: 0px; 
            height: 90px; 
        }

        .header-text { 
            text-align: center; 
            width: 100%;
            margin-bottom: 20px;
            padding-top: 15px; 
        }
        
        .header-text h2 { 
            margin: 0; 
            font-size: 22px; 
            color: #055038; 
            text-transform: uppercase; 
            font-weight: bold;
        }
        
        .header-text p {
            margin: 5px 0 0 0;
            color: #666;
            font-size: 12px;
        }

        table { width: 100%; border-collapse: collapse; }
        
        th {
            background-color: #f9f9f9;
            color: #333;
            font-weight: bold;
            padding: 8px 5px;
            text-align: left;
            border-bottom: 2px solid #055038; 
        }

        td {
            padding: 8px 5px;
            border-bottom: 1px solid #eee;
            vertical-align: top;
            line-height: 1.4;
        }

        .col-empresa { width: 20%; }
        .col-rif { width: 10%; }
        .col-contacto { width: 15%; }
        .col-telefono { width: 10%; }
        .col-email { width: 15%; }
        .col-direccion { width: 30%; }

        tr:nth-child(even) { background-color: #fcfcfc; }
    </style>
</head>
<body>

    <header>
        <img src="{{ public_path('img/logo_df.jpg') }}" class="logo">
        <div class="header-text">
            <h2>Listado General de Clientes</h2>
            <p>Fecha de Emisión: {{ date('d/m/Y') }}</p>
        </div>
    </header>

    <footer>
        <p>
            <strong>Díaz Frontado, S.A.</strong> - Av. Ppal. con 1era Transv. Edif. Centro Los Cortijos, PB. Local 3 y 4. Los Cortijos de Lourdes, Caracas. Venezuela.
            <br> Teléfono: 04143223416 | Correo: ventas@diazfrontado.com.ve | RIF J-00042721-6
        </p>
    </footer>

    <main>
        <table>
            <thead>
                <tr>
                    <th class="col-empresa">Empresa</th>
                    <th class="col-rif">RIF</th>
                    <th class="col-contacto">Contacto</th>
                    <th class="col-telefono">Teléfono</th>
                    <th class="col-email">Email</th>
                    <th class="col-direccion">Dirección</th>
                </tr>
            </thead>
            <tbody>
                @foreach($clients as $client)
                <tr>
                    <td><strong>{{ $client->nombre_empresa }}</strong></td>
                    <td>{{ $client->rif }}</td>
                    <td>{{ $client->persona_contacto ?? '--' }}</td>
                    <td style="white-space: nowrap;">{{ $client->telefono ?? '--' }}</td>
                    <td style="word-wrap: break-word;">{{ $client->email ?? '--' }}</td>
                    <td style="font-size: 10px;">{{ $client->direccion }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </main>

</body>
</html>