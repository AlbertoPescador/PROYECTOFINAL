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
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
        }
        .container {
            width: 80%;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #333;
            text-align: center;
        }
        p {
            margin: 10px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
        .invoice-info {
            margin-bottom: 20px;
        }
        .invoice-info p {
            font-size: 16px;
        }
        .line-header {
            background-color: #f2f2f2;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Factura de: {{ $user->name }}</h1>
        <div class="invoice-info">
            <p>Email: {{ $user->email }}</p>
            <p>Dirección: {{ $user->address }}</p>
            <p>Código de factura: {{ $invoice->id }}</p>
            <p>Fecha de creación: {{ $invoice->created_at }}</p>
            <p>Total de la factura: {{ $invoice->total_invoice }} €</p>
            @if($deliveryOption == 'delivery')
                <p>Horario de entrega: 10:00 - 18:00</p>
                <p>Dirección de entrega: {{ $address }}</p>
            @elseif($deliveryOption == 'pickup')
                <p>Fecha de recogida: {{ $pickupDate }}</p>
            @endif
        </div>
        
        <h2>Líneas de factura:</h2>
        <table>
            <thead>
                <tr class="line-header">
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio KG</th>
                    <th>Total(€)</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($productsData as $productData)
                    <tr>
                        <td>{{ $productData['name'] }}</td>
                        <td>{{ $productData['stock'] }}</td>
                        <td>{{ $productData['priceKG'] }} €</td>
                        <td>{{ $productData['totalPriceProduct']}} €</td>
                    </tr>
                @endforeach

                
            </tbody>
        </table>
    </div>
</body>
</html>