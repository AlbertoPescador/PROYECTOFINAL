<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Finalizar Compra</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-body">
                <h1 class="card-title">Gracias por tu compra!</h1>
                <p class="card-text">Tu pedido ha sido procesado con éxito.</p>

                <!-- Botón de descarga de factura -->
                <a href="{{ route('order.downloadInvoice', [
                    'invoice_id' => request('invoice_id'),
                    'delivery_option' => request('delivery_option'),
                    'pickup_date' => request('pickup_date'),
                    'address' => request('address'),
                ]) }}" class="btn btn-primary mr-2">Descargar Factura</a>

                <!-- Botón de Mis Pedidos -->
                <a href="{{ route('invoice.myinvoices') }}" class="btn btn-primary">Mis Pedidos</a>
            </div>
        </div>
    </div>

    <!-- Scripts de Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
