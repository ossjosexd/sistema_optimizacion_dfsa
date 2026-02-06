<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ficha Técnica - {{ $product->descripcion }}</title>
    <style>
        @page {
            margin: 140px 40px 80px 40px; 
            font-family: sans-serif;
        }

        body {
            font-size: 12px;
            color: #333;
            line-height: 1.4;
        }
        header { position: fixed; top: -100px; left: 0; right: 0; height: 90px; }
        footer { position: fixed; bottom: -50px; left: 0; right: 0; height: 50px; text-align: center; font-size: 10px; color: #777; border-top: 1px solid #ddd; padding-top: 10px; }
        
        .logo { position: absolute; left: 0; top: 0; height: 70px; }
        
        .company-info {
            text-align: right; position: absolute; right: 0; top: 10px;
            font-size: 10px; color: #555;
        }
        .report-title {
            text-align: center;
            border-bottom: 2px solid #055038;
            margin-bottom: 20px;
            padding-bottom: 10px;
        }
        .report-title h1 { margin: 0; font-size: 20px; color: #055038; text-transform: uppercase; }
        .report-title p { margin: 2px 0; font-size: 12px; color: #666; }

        .section-title {
            background-color: #055038; /* Verde corporativo */
            color: white;
            padding: 5px 10px;
            font-weight: bold;
            font-size: 13px;
            margin-top: 20px;
            margin-bottom: 5px;
            border-radius: 4px 4px 0 0;
        }

        .details-grid { width: 100%; border-collapse: collapse; }
        .details-grid td { padding: 6px 10px; border-bottom: 1px solid #eee; vertical-align: top; }
        .label { 
            width: 30%; 
            font-weight: bold; 
            color: #444; 
            background-color: #f8f9fa; 
        }
        .value { width: 70%; color: #000; }

          .top-table { width: 100%; margin-bottom: 10px; border-collapse: collapse; }
        .top-table td { vertical-align: top; }
        
        .product-image-container {
            width: 30%;
            text-align: center;
            border: 1px solid #ddd;
            padding: 5px;
            background: #fff;
            height: 160px; 
        }
        
        .product-image {
            max-width: 95%; 
            max-height: 150px;
            object-fit: contain;
        }

        .summary-container { width: 68%; padding-left: 20px; }
        .link-box {
            display: inline-block;
            background-color: #f0f0f0;
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 11px;
            color: #007bff;
            text-decoration: none;
            border: 1px solid #ccc;
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
            <strong>Díaz Frontado, S.A.</strong> <br>
            Este documento es una especificación técnica generada el {{ now()->format('d/m/Y') }}.
        </p>
    </footer>

    <main>
        <div class="report-title">
            <h1>Ficha Técnica del Producto</h1>
            <p>Especificaciones y Detalles</p>
        </div>

        <table class="top-table">
            <tr>
                <td class="product-image-container">
@if(isset($product->imagen) && file_exists(public_path($product->imagen)))
                        <img src="{{ public_path($product->imagen) }}" class="product-image">
                    @else
                        <img src="{{ public_path('img/logo_df.jpg') }}" 
                            class="product-image" 
                            style="opacity: 0.3; padding: 20px; filter: grayscale(100%);">
                    @endif
                </td>

                <td class="summary-container">
                    <table class="details-grid">
                        <tr>
                            <td class="label">Descripción:</td>
                            <td class="value"><strong>{{ $product->descripcion }}</strong></td>
                        </tr>
                        <tr>
                            <td class="label">Código / Modelo:</td>
                            <td class="value" style="color: #055038; font-weight: bold;">{{ $product->modelo }}</td>
                        </tr>
                        <tr>
                            <td class="label">ID Sistema:</td>
                            <td class="value">{{ $product->id }}</td>
                        </tr>
                        <tr>
                            <td class="label">Fecha Registro:</td>
                            <td class="value">{{ \Carbon\Carbon::parse($product->fecha)->format('d/m/Y') }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <div class="section-title">Especificaciones Físicas</div>
        <table class="details-grid">
            <tbody>
                <tr>
                    <td class="label">Unidad de Medida:</td>
                    <td class="value">{{ $product->unidad_medida }}</td>
                </tr>
                <tr>
                    <td class="label">Presentación:</td>
                    <td class="value">{{ number_format($product->cantidad, 2) }} Unidades</td>
                </tr>
            </tbody>
        </table>

        <div class="section-title">Control de Inventario</div>
        <table class="details-grid">
            <tbody>
                <tr>
                    <td class="label">Stock Mínimo (Alerta):</td>
                    <td class="value" style="color: #d9534f;"> <strong>{{ number_format($product->stock_minimo, 2) }} {{ $product->unidad_medida }}</strong>
                    </td>
                </tr>
            </tbody>
        </table>
        
        <div class="section-title">Documentación Adicional</div>
        <table class="details-grid">
            <tbody>
                <tr>
                    <td class="label">Ficha del Fabricante:</td>
                    <td class="value">
                        @if(isset($product->ficha_fabricante) && $product->ficha_fabricante)
                            <a href="{{ $product->ficha_fabricante }}" class="link-box">
                                Ver Documento PDF / Web &rarr;
                            </a>
                            <div style="margin-top: 5px; font-size: 9px; color: #999;">
                                {{ $product->ficha_fabricante }}
                            </div>
                        @else
                            <span style="color: #999; font-style: italic;">No disponible en sistema.</span>
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>

    </main>
</body>
</html>