<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facturas del Usuario</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <x-app-web-layout>
        <div class="container mx-auto px-4">
            <h2 class="text-2xl font-semibold my-8">Facturas de {{ $user->name }} ({{ $user->email }})</h2>
            @if (count($invoices) > 0)
                @foreach ($invoices as $invoice)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-4">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <h3 class="text-lg font-semibold mb-4">Pedido #{{ $invoice->id }}</h3>
                            <p><strong>Fecha:</strong> {{ $invoice->date_created }}</p>
                            <p><strong>Total de la Factura:</strong> {{ $invoice->total_invoice }}€</p>
                            <a href="{{ route('invoices.show', $invoice->id) }}" class="mt-4 inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Ver Detalles</a>
                            <a href="{{ route('invoice.generateInvoices', $invoice->id) }}" class="mt-4 inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Descargar Factura</a>
                            <form id="formDeleteInvoice{{ $invoice->id }}" action="{{ route('admin.invoices.destroy', $invoice->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="confirmarEliminacion('{{ $invoice->id }}')" class="mt-4 inline-block bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Eliminar Factura</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            @else
                <h1>El usuario no tiene ninguna factura almacenada</h1>
            @endif
        </div>
    </x-app-web-layout>
    <script>
        function confirmarEliminacion(id) {
            var mensaje = "¿Estás seguro de que quieres eliminar la factura con ID " + id + "?";
            if (confirm(mensaje)) {
                document.getElementById('formDeleteInvoice' + id).submit();
            }
        }
    </script>
</body>
</html>