@if ($invoices->isEmpty())
    <strong>No se encontraron facturas para este usuario en la fecha seleccionada.</strong>
@else
    @foreach ($invoices as $invoice)
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-4">
            <div class="p-6 bg-white border-b border-gray-200">
                <h3 class="text-lg font-semibold mb-4">Pedido #{{ $invoice->id }}</h3>
                <p><strong>Fecha:</strong> {{ $invoice->created_at->format('d-m-Y H:i:s') }}</p>
                <p><strong>Total de la Factura:</strong> {{ number_format($invoice->total_invoice, 2) }}€</p>
                <!-- Botón "Ver Detalles" -->
                <a href="{{ route('invoices.show', $invoice->id) }}" class="mt-4 inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Ver Detalles</a>
            </div>
        </div>
    @endforeach
@endif
