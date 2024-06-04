<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $product->name }}</title>
    <link href="{{ asset('assets/css/product.css') }}" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>
<body>
    <x-app-layout>
        <div class="container">
            <div class="row">
                <h1 class="section-title">{{ $product->name }}</h1>
                <div class="col-md-6">
                    <br>
                    <img class="product-image" src="{{ asset($product->urlImagen) }}" alt="{{ $product->name }}">
                    <br>
                    <div class="product-detail-container">
                        <h1 class="h1info">Más Información</h1>
                        <br>
                        <p>{{ $product->description }}</p>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <br>
                    <div class="purchase-info-container">
                        <div class="mb-4">
                            @if ($product->sale)
                                <p id="originalPrice" class="product-price text-strike">{{ number_format($product->priceKG, 2) }}€ (KG)</p>
                                <div class="price-discount-container">
                                    <p id="finalPrice" class="product-final-price">{{ number_format($product->priceKGFinal, 2) }}€ impuestos inc.</p>
                                    <p class="discount-text">¡¡{{ round(($product->priceKG - $product->priceKGFinal) / $product->priceKG * 100) }}% de descuento!!</p>
                                </div>
                            @else
                                <p id="originalPrice" class="product-price">{{ number_format($product->priceKG, 2) }}€ impuestos inc.</p>
                            @endif
                        </div>
                        <div class="mb-4">
                            <p class="stockstyle">Quedan: {{ number_format($product->stock, 2) }} KG</p>
                            @if ($product->stock <= 10)
                                <p class="lastunits">¡Últimas unidades!</p>
                            @endif
                        </div>
                        <div class="mb-4">
                            <label for="tipoBandeja">Tipo de Bandeja:</label>
                            <select id="tipoBandeja" class="form-control">
                                <option value="0.5">0.5 kg</option>
                                <option value="1">1 kg</option>
                            </select>
                        </div>
                        <div id="tipoCorteContainer" class="mb-4" style="display: none;">
                            <label for="tipoCorte">Tipo de Corte:</label>
                            <select id="tipoCorte" class="form-control">
                                <!-- Opciones se actualizarán dinámicamente -->
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="bandejas">Cantidad:</label>
                            <input type="number" id="bandejas" name="bandejas" class="form-control" value="1" min="1">
                        </div>
                    </div>
                    <button id="addToCart" class="btn btn-primary">
                        <svg class="w-5 h-5 text-gray-600 inline-block mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 5l1 9h15l4-9H2Z"/><circle cx="10.5" cy="18.5" r="1"/><circle cx="17.5" cy="18.5" r="1"/></svg>
                        Añadir al carro
                    </button>
                </div>
            </div>
        </div>
    </x-app-layout>
    <script>
    $(document).ready(function() {
        const tipoBandeja = $('#tipoBandeja');
        const tipoCorte = $('#tipoCorte');
        const tipoCorteContainer = $('#tipoCorteContainer');
        const originalPriceElement = $('#originalPrice');
        const finalPriceElement = $('#finalPrice');
        const isOnSale = {{ $product->sale ? 'true' : 'false' }};
        const originalPrice = parseFloat('{{ $product->priceKG }}');
        const finalPrice = parseFloat('{{ $product->priceKGFinal }}');
        const productName = '{{ $product->name }}';
        const stockDisponible = parseFloat('{{ $product->stock }}');

        const cortesPorProducto = {
            'Filete': ['Filetes Normales', 'Filetes Finos', 'Filetes Gruesos'],
            'Filetes': ['Filetes Normales', 'Filetes Finos', 'Filetes Gruesos'],
            'Carne Picada': ['Picada Fina', 'Picada Gruesa'],
            'Chuleta': ['Chuletas Normales', 'Chuletas Gruesas'],
            'Chuletas': ['Chuletas Normales', 'Chuletas Gruesas'],
            'Solomillo': ['Solomillo Entero', 'Solomillo en Medallones'],
            'Estofado': ['Dados Grandes', 'Dados Pequeños'],
            'Lomo': ['Lomo Entero', 'Lomo en Rodajas'],
            'Costilla': ['Costillas Normales', 'Costillas Adobadas'],
            'Costillas': ['Costillas Normales', 'Costillas Adobadas'],
            'Hamburguesa': ['Hamburguesas Normales', 'Hamburguesas Gourmet'],
            'Hamburguesas': ['Hamburguesas Normales', 'Hamburguesas Gourmet'],
            'Entrecot': ['Entrecot Normal', 'Entrecot Fino', 'Entrecot Grueso'],
            'Entrecots': ['Entrecot Normal', 'Entrecot Fino', 'Entrecot Grueso']
        };

        const actualizarCortes = (producto) => {
            tipoCorte.empty();
            let cortes = [];
            for (let key in cortesPorProducto) {
                if (producto.includes(key)) {
                    cortes = cortesPorProducto[key];
                    break;
                }
            }
            if (cortes.length === 0) {
                tipoCorteContainer.hide();
            } else {
                tipoCorteContainer.show();
                cortes.forEach(corte => {
                    tipoCorte.append(`<option value="${corte}">${corte}</option>`);
                });
            }
        };

        actualizarCortes(productName);

        tipoBandeja.on('change', function() {
            const selectedValue = parseFloat(tipoBandeja.val());
            const displayPrice = (isOnSale ? finalPrice : originalPrice) * selectedValue;

            if (isOnSale) {
                finalPriceElement.text(displayPrice.toFixed(2) + '€ impuestos inc.');
            } else {
                originalPriceElement.text(displayPrice.toFixed(2) + '€ impuestos inc.');
            }
        });

        // Trigger change event to set initial price
        tipoBandeja.trigger('change');

        $('#addToCart').click(function(event) {
            event.preventDefault();

            var productId = '{{ $product->id }}';
            var productName = '{{ $product->name }}';
            var productPriceKG = parseFloat(isOnSale ? finalPrice : originalPrice);
            var productQuantity = parseInt($('#bandejas').val());
            var productImage = '{{ asset($product->urlImagen) }}';
            var tipoBandejaValue = $('#tipoBandeja').val();
            var tipoCorteValue = $('#tipoCorte').val() || '';

            // Calcular la cantidad total que se quiere añadir en kg
            var cantidadRequerida = productQuantity * parseFloat(tipoBandejaValue);

            // Verificar si hay suficiente stock disponible
            if (cantidadRequerida > stockDisponible) {
                alert('No hay suficiente stock disponible');
                return;
            }

            // Log de depuración de los datos enviados
            console.log('Datos enviados:', {
                id: productId,
                nombre: productName,
                priceKG: productPriceKG.toFixed(2),
                urlImagen: productImage,
                quantity: productQuantity,
                tipoBandeja: tipoBandejaValue,
                tipoCorte: tipoCorteValue,
                _token: '{{ csrf_token() }}'
            });

            $.ajax({
                url: '{{ route("cart.store") }}',
                method: 'POST',
                data: {
                    id: productId,
                    nombre: productName,
                    priceKG: productPriceKG.toFixed(2),
                    urlImagen: productImage,
                    quantity: productQuantity,
                    tipoBandeja: tipoBandejaValue,
                    tipoCorte: tipoCorteValue,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    console.log('Respuesta del servidor:', response);
                    alert(response.message);
                    window.location.href = '{{ route("products.list") }}';
                },
                error: function(xhr, status, error) {
                    console.error('Error en la solicitud AJAX:', xhr.responseText, status, error);
                    alert('Error al añadir el producto al carrito.');
                }
            });
        });
    });
    </script>
</body>
<x-app-footer-layout>
</x-app-footer-layout>
</html>
