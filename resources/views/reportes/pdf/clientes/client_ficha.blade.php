<!DOCTYPE html>
<html>
<head>
    <title>Ficha de Cliente: {{ $client->nombre_empresa }}</title>
    <style>
        @page {
            margin: 140px 40px 80px 40px; 
            font-family: sans-serif;
        }

        body { 
            font-size: 12px; 
            color: #333; 
            line-height: 1.6; 
        }

        header {
            position: fixed;
            top: -100px;
            left: 0; right: 0; height: 90px;
        }

        .logo { position: absolute; left: 0; top: 0; height: 70px; }

        .company-info {
            text-align: right;
            position: absolute;
            right: 0; top: 10px;
            font-size: 10px; color: #555;
            line-height: 1.3;
        }

        footer {
            position: fixed;
            bottom: -50px;
            left: 0; right: 0; height: 60px; 
            text-align: center;
            font-size: 11px;
            color: #777;
            border-top: 1px solid #ddd;
            padding-top: 10px;
            line-height: 1.4;
        }

        .container { 
            width: 85%; 
            margin: 0 auto;
            
            border: 1px solid #ddd; 
            padding: 20px 30px;
            border-radius: 8px; 
            background-color: #fff;
            box-shadow: 0px 2px 5px rgba(0,0,0,0.05);
        }

        .card-header { 
            text-align: center; 
            border-bottom: 2px solid #055038; 
            padding-bottom: 15px; 
            margin-bottom: 25px; 
        }

        .card-header h1 { 
            color: #055038; margin: 0; font-size: 22px; text-transform: uppercase; letter-spacing: 1px;
        }

        .card-header p {
            margin: 5px 0 0 0; color: #666; font-size: 12px;
        }

        .details-table {
            width: 100%;
            border-collapse: collapse;
        }

        .details-table td {
            padding: 8px 5px;
            vertical-align: middle;
        }

        .label-col {
            width: 30%; 
            font-weight: bold;
            color: #055038;
            text-align: left;
        }

        .value-col {
            width: 70%;
            color: #000;
        }

        .address-box {
            padding: 10px;
            background: #f9f9f9;
            border: 1px solid #eee;
            border-radius: 4px;
            font-size: 11px;
        }
    </style>
</head>
<body>

    <header>
        <img src="{{ public_path('img/logo_df.jpg') }}" class="logo" alt="Logo">
        <div class="company-info">
            <strong>Díaz Frontado, S.A.</strong><br>
            RIF: J-00042721-6<br>
            Caracas, Venezuela
        </div>
    </header>

    <footer>
        <p>
            <strong>Díaz Frontado, S.A.</strong> - Av. Ppal. con 1era Transv. Edif. Centro Los Cortijos, PB. Local 3 y 4. Los Cortijos de Lourdes, Caracas. Venezuela.
            <br>
            Teléfono: 04143223416 | Correo: ventas@diazfrontado.com.ve | RIF J-00042721-6
        </p>
    </footer>

    <main>
        <div class="container">
            <div class="card-header">
                <h1>Ficha de Cliente</h1>
                <p>Información detallada registrada en sistema</p>
            </div>

            <table class="details-table">
                <tr>
                    <td class="label-col">Razón Social:</td>
                    <td class="value-col">
                        <strong style="font-size: 14px;">{{ $client->nombre_empresa }}</strong>
                    </td>
                </tr>
                <tr>
                    <td class="label-col">RIF:</td>
                    <td class="value-col">{{ $client->rif }}</td>
                </tr>
                
                <tr>
                    <td colspan="2">
                        <hr style="border: 0; border-top: 1px dashed #ddd; margin: 10px 0;">
                    </td>
                </tr>

                <tr>
                    <td class="label-col">Persona Contacto:</td>
                    <td class="value-col">{{ $client->persona_contacto ?? 'No registrada' }}</td>
                </tr>
                <tr>
                    <td class="label-col">Teléfono:</td>
                    <td class="value-col">{{ $client->telefono ?? 'No registrado' }}</td>
                </tr>
                <tr>
                    <td class="label-col">Correo Electrónico:</td>
                    <td class="value-col">{{ $client->email ?? 'No registrado' }}</td>
                </tr>
                <tr>
                    <td class="label-col" style="vertical-align: top; padding-top: 15px;">Dirección Fiscal:</td>
                    <td class="value-col">
                        <div class="address-box">
                            {{ $client->direccion }}
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </main>

</body>
</html>