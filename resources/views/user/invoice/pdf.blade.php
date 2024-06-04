<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura</title>
    <style>
        /* Estilos para el PDF */
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
    </style>
</head>
<body>
    <h1>Factura de: {{ Auth::user()->name}} </h1>
    <p>Código de factura: {{ $invoice->id}} </p>
    <p>Fecha de creación: {{ $invoice->date_created }}</p>
    <p>Total de la factura: {{ $invoice->total_invoice }} €</p>
    <h2>Líneas de factura:</h2>
    <table>
        <thead>
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio Unitario(€)</th>
                <th>Total(€)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($productsData as $productData)
                <tr>
                    <td>{{ $productData['name'] }}</td>
                    <td>{{ $productData['stock'] }}</td>
                    <td>{{ $productData['priceKG'] }} €</td>
                    <td>{{ $productData['totalPriceProduct'] }} €</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
