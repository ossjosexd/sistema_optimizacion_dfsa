<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enlace a Ruta con Parámetro</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 30px; }
        .btn-link {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <h1>Vista de Inicio (Contiene el Enlace)</h1>

    <?php 
        $nombre_a_pasar = 'Ricardo'; 
    ?>

    <p>
        El valor del parámetro `var1` que se enviará es: 
        <strong>{{ $nombre_a_pasar }}</strong>
    </p>

    <a href="{{ route('prueba.mostrar', ['var1' => $nombre_a_pasar]) }}" class="btn-link">
        Haz clic para ir a la Ruta de Prueba
    </a>

    <p style="margin-top: 20px;">
        La URL generada será: **{{ url('/prueba/' . $nombre_a_pasar) }}**
    </p>

</body>
</html>