<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mis pedidos</title>
</head>
<body>
    <x-app-layout> 
        <div class="container mx-auto px-4">
        <h2 class="text-2xl font-semibold my-8">Mis Pedidos</h2>
            @if (count($invoices) >= 1)
                @foreach ($invoices as $invoice)
                            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-4">
                                <div class="p-6 bg-white border-b border-gray-200">
                                    <h3 class="text-lg font-semibold mb-4">Pedido #{{ $invoice->id }}</h3>
                                    <p><strong>Fecha:</strong> {{ $invoice->date_created }}</p>
                                    <p><strong>Total de la Factura:</strong> {{ $invoice->total_invoice }}€</p>
                                    
                                    <!-- Botón "Ver Detalles" -->
                                    <a href="{{ route('invoices.show', $invoice->id) }}" class="mt-4 inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Ver Detalles</a>
                                    <!-- Enlace para descargar factura -->
                                    <a href="{{ route('invoice.generateInvoices', $invoice->id) }}" class="mt-4 inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Descargar Factura</a>
                                </div>
                            </div>
                @endforeach
            @else
                <h1>El usuario no tiene ninguna factura almacenada</h1>
            @endif
        </div>
    </x-app-layout>
</body>
</html>