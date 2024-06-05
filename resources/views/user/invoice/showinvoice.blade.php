<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles de la factura</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        hr {
            border: 2px solid;
        }
        .logo-container {
            position: absolute;
            right: 0;
            top: 50px; /* Ajusta esta posición según sea necesario */
        }
        .content {
            position: relative;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="content">
            <div class="logo-container">
                <a href="{{ route('invoice.myinvoices') }}">
                    <img src="{{ asset('assets/logo.png') }}" width="110" height="80" />
                </a>
            </div>
            <h2>Detalles de la factura</h2>
            <br>
            <p><strong>Código de Factura:</strong> {{ $invoice->id }}</p>
            <p><strong>Usuario:</strong> {{ $invoice->user->name }} / {{ $invoice->user->email }}</p>
            <p><strong>Fecha:</strong> {{ $invoice->created_at->format('d-m-Y H:i:s') }}</p>
            <p><strong>Dirección:</strong> {{ $invoice->user->address }}</p>
            <p><strong>Total de la Factura:</strong> {{ number_format($invoice->total_invoice,2) }}€</p>
            <hr>
        </div>
        <br>
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
                                <span>Cantidad: {{ $line->stock }} kg</span>
                                <span class="ml-3">Precio (KG): {{ number_format($line->product->priceKGFinal,2) }} €</span>
                                <span class="ml-3">Total: {{ number_format($line->totalPriceProduct,2) }} €</span>
                            </div>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</body>
</html>
