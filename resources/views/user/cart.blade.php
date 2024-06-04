<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Carrito</title>
    <link href="{{ asset('assets/css/cart.css') }}" rel="stylesheet">
</head>
<body>
    <x-app-layout>
        <main class="my-8">
            <div class="container px-6 mx-auto">
                <div class="flex justify-center my-6">
                    <div class="flex flex-col w-full p-8 text-gray-800 bg-white shadow-lg md:w-4/5 lg:w-4/5">
                        @if ($message = Session::get('success'))
                            <div class="p-4 mb-3 bg-blue-400 rounded">
                                <p class="text-white">{{ $message }}</p>
                            </div>
                        @endif
                        @if ($message = Session::get('error'))
                            <div class="p-4 mb-3 bg-red-400 rounded">
                                <p class="text-white">{{ $message }}</p>
                            </div>
                        @endif
                        <h3 class="text-3xl font-bold mb-4">Carro</h3>
                        <div class="flex-1">
                            <table cellspacing="0">
                                <thead>
                                    <tr class="h-12 uppercase">
                                        <th class="text-center">Imagen</th>
                                        <th class="text-left">Nombre</th>
                                        <th class="text-left">Tipo de Bandeja</th>
                                        <th class="text-left">Tipo de Corte</th>
                                        <th class="text-left">Cantidad de Bandejas</th>
                                        <th class="text-left">Cantidad Total (KG)</th>
                                        <th class="text-right">Precio por bandeja</th>
                                        <th class="text-right">Precio Total</th>
                                        <th class="text-right">Eliminar</th>
                                    </tr>
                                </thead>
                                <tbody id="cart-items">
                                    @foreach ($cartItems as $item)
                                        <tr data-id="{{ $item->id }}" data-stock="{{ $item->attributes->stock }}">
                                            <td class="text-center align-middle" data-label="Imagen">
                                                <img src="{{ $item->attributes->image }}" class="thumbnail rounded" alt="Thumbnail">
                                            </td>
                                            <td class="align-middle" data-label="Nombre">
                                                <p class="mb-2 text-gray-900 font-bold">{{ $item->name }}</p>
                                            </td>
                                            <td class="align-middle" data-label="Tipo de Bandeja">
                                                <p class="mb-2 text-gray-900">{{ $item->attributes['tipoBandeja'] }} kg</p>
                                            </td>
                                            <td class="align-middle" data-label="Tipo de Corte">
                                                <p class="mb-2 text-gray-900">{{ $item->attributes['tipoCorte'] }}</p>
                                            </td>
                                            <td class="align-middle text-center" data-label="Cantidad de Bandejas">
                                                <form action="{{ route('cart.update') }}" method="POST" class="update-form">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{ $item->id }}">
                                                    <input type="hidden" name="original_quantity" value="{{ $item->quantity }}">
                                                    <input type="number" name="quantity" value="{{ $item->quantity }}" class="w-20 text-center h-10 text-gray-800 outline-none rounded border border-gray-600 py-1 quantity-input" />
                                                    <button class="w-full px-2 mt-1 py-1 text-sm rounded shadow text-violet-100 bg-gray-800 btn">Actualizar</button>
                                                </form>
                                            </td>
                                            <td class="align-middle" data-label="Cantidad Total (KG)">
                                                <p class="mb-2 text-gray-900 cantidad-total">{{ number_format($item->quantity * $item->attributes['tipoBandeja'], 2) }} kg</p>
                                            </td>
                                            <td class="text-right align-middle" data-label="Precio por bandeja">
                                                <span class="text-sm font-medium lg:text-base">
                                                    {{ number_format($priceBandeja = $item->price * $item->attributes['tipoBandeja'], 2) }}€
                                                </span>
                                            </td>
                                            <td class="text-right align-middle" data-label="Precio Total">
                                                <span class="text-sm font-medium lg:text-base">
                                                    {{ number_format($priceTotal = $priceBandeja * $item->quantity, 2) }}€
                                                </span>
                                            </td>
                                            <td class="text-right align-middle" data-label="Eliminar">
                                                <form action="{{ route('cart.remove') }}" method="POST" class="remove-form">
                                                    @csrf
                                                    <input type="hidden" value="{{ $item->id }}" name="id">
                                                    <button class="px-3 py-1 text-white bg-gray-800 shadow rounded-full btn">x</button>
                                                </form>
                                            </td>
                                        </tr>
                                        <tr class="separator-row">
                                            <td colspan="9"></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="flex justify-between items-center my-5">
                                <div class="font-semibold text-2xl">
                                    @php
                                        $priceTotal = 0; // Inicializa el total en 0
                                    @endphp
                                    @foreach ($cartItems as $item)
                                        @php
                                            $priceBandeja = $item->price * $item->attributes['tipoBandeja'];
                                            $priceTotal += $priceBandeja * $item->quantity; // Calcula el total sumando los precios de cada ítem en el carrito
                                        @endphp
                                    @endforeach
                                    Total: {{ number_format($priceTotal, 2) }}€
                                </div>
                                <div>
                                    <form action="{{ route('cart.clear') }}" method="POST">
                                        @csrf
                                        <button class="px-6 py-2 text-sm rounded shadow text-red-100 bg-gray-800 btn">Vaciar Carro</button>
                                    </form>
                                </div>
                            </div>
                            <div>
                                <a href="{{ route('cart.confirm') }}" 
                                   class="px-6 py-2 text-sm rounded shadow text-red-100 bg-gray-500 btn-confirmar-compra {{ $isCartEmpty ? 'disabled' : '' }}"
                                   data-cart-empty="{{ $isCartEmpty ? 'true' : 'false' }}">
                                   Confirmar Compra
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </x-app-layout>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const confirmButton = document.querySelector('.btn-confirmar-compra');

            confirmButton.addEventListener('click', function(event) {
                event.preventDefault();

                const cartItems = [];
                document.querySelectorAll('#cart-items tr[data-id]').forEach(item => {
                    cartItems.push({
                        id: item.dataset.id,
                        quantity: parseFloat(item.querySelector('.quantity-input').value),
                        tipoBandeja: parseFloat(item.querySelector('[data-label="Tipo de Bandeja"]').textContent)
                    });
                });

                fetch('{{ route("cart.confirm") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ cartItems: cartItems })
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Error en la solicitud Fetch: ' + response.statusText);
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        window.location.href = data.redirect_url;
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Se produjo un error al verificar el stock. Por favor, inténtalo de nuevo.');
                });
            });

            const updateForms = document.querySelectorAll('.update-form');
            updateForms.forEach(form => {
                form.addEventListener('submit', function(event) {
                    event.preventDefault();
                    const quantityInput = form.querySelector('.quantity-input');
                    const quantity = parseFloat(quantityInput.value);
                    const originalQuantity = parseFloat(form.querySelector('input[name="original_quantity"]').value);
                    const stock = parseFloat(form.closest('tr').getAttribute('data-stock'));

                    if (quantity <= 0) {
                        alert('La cantidad debe ser mayor que 0. El producto será restaurado a su cantidad original.');
                        quantityInput.value = originalQuantity;
                    } else if (quantity > stock) {
                        alert('La cantidad supera el stock disponible. Por favor, reduce la cantidad.');
                        quantityInput.value = originalQuantity;
                    } else {
                        form.submit();
                    }
                });
            });
        });
    </script>
</body>
</html>
