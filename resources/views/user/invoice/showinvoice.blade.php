<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles de la factura</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Detalles de la factura</h2>
        <br>
        <p><strong>Código de Factura:</strong> {{ $invoice->id }}</p>
        <p><strong>Usuario:</strong> {{ $invoice->user->name }} / {{ $invoice->user->email }}</p>
        <p><strong>Fecha:</strong> {{ $invoice->date_created }}</p>
        <p><strong>Total de la Factura:</strong> {{ $invoice->total_invoice }}€</p>
        
        <!-- Lista de productos en la factura -->
        <h3>Productos:</h3>
        <ul class="list-group">
            @foreach ($invoice->lines as $line)
                <li class="list-group-item">
                    <div class="d-flex align-items-center">
                        <img src="{{ url($line->product->urlImagen) }}" class="mr-3" style="width: 50px; height: 50px;">
                        <div>
                            <strong>{{ $line->product->name }}</strong>
                            <div class="d-flex justify-content-between">
                                <span>Cantidad: {{ $line->stock }}</span>
                                <span class="ml-3">Precio unitario: {{ $line->product->priceKG }} €</span>
                                <span class="ml-3">Total: {{ $line->totalPriceProduct }} €</span>
                            </div>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</body>
</html>