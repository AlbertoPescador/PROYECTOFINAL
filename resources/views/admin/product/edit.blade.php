<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EDITAR PRODUCTO</title>
</head>
<body>
    <x-app-web-layout>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-sm-8">
                    <h1 class="mt-3 mb-3 fs-4">EDITAR PRODUCTO</h1>
                    <form id="productForm" action="{{ route('admin.product.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="id" class="form-label">ID</label>
                            <input type="text" id="id" name="id" value="{{ $product->id }}" class="form-control" readonly>
                        </div>
                        
                        <div class="mb-3">
                            <label for="current_image" class="form-label">IMAGEN ACTUAL</label>
                            <div>
                                <img src="{{ asset($product->urlImagen) }}" alt="Imagen Actual" style="max-width: 200px; margin-bottom: 10px;">
                            </div>
                        </div>

                        <!-- Mostrar label y campo para la nueva imagen -->
                        <div class="mb-3">
                            <label for="image" class="form-label">NUEVA IMAGEN</label>
                            <div>
                                <input type="file" id="urlImagen" name="urlImagen" class="form-control" onchange="previewImage(event)">
                            </div>
                            <div id="newImageContainer" style="margin-top: 10px; display: none;">
                                <label id="newImageLabel" class="form-label">Previsualización:</label>
                                <img id="newImagePreview" src="#" alt="Nueva Imagen" style="max-width: 200px;">
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="name" class="form-label">NOMBRE DEL PRODUCTO</label>
                            <input type="text" id="name" name="name" value="{{ $product->name }}" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">DESCRIPCION DEL PRODUCTO</label>
                            <input type="text" id="description" name="description" value="{{ $product->description }}" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label for="priceKG" class="form-label">PRECIO/KG</label>
                            <input type="float" id="priceKG" name="priceKG" value="{{ $product->priceKG }}" class="form-control" onchange="calculateAndSetPriceKGFinal()">
                        </div>

                        <div class="mb-3">
                            <label for="stock" class="form-label">STOCK (KG)</label>
                            <input type="text" id="stock" name="stock" value="{{ $product->stock }}" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label for="sale" class="form-label">OFERTA</label>
                            <select id="sale" name="sale" class="form-control" onchange="togglePriceSaleContainer(); calculateAndSetPriceKGFinal();">
                                <option value="0" {{ $product->sale == 0 ? 'selected' : '' }}>No</option>
                                <option value="1" {{ $product->sale == 1 ? 'selected' : '' }}>Sí</option>
                            </select>
                        </div>

                        <div class="mb-3" id="priceSaleContainer" style="display: {{ $product->sale == 1 ? 'block' : 'none' }}">
                            <label for="priceSale" class="form-label">PRECIO REBAJADO</label>
                            <input type="text" id="priceSale" name="priceSale" value="{{ $product->priceSale }}" class="form-control" oninput="calculateAndSetPriceKGFinal()">
                        </div>

                        <!-- Campo readonly para mostrar el precio final (priceKGFinal) -->
                        <div class="mb-3">
                            <label for="priceKGFinal" class="form-label">PRECIO FINAL</label>
                            <input type="text" id="priceKGFinal" name="priceKGFinal" value="{{ $product->priceKGFinal }}" class="form-control" readonly>
                        </div>

                        <button type="submit" style="background-color: #007bff; color: #fff; border: none; padding: 8px 16px; border-radius: 4px; transition: background-color 0.3s ease;"
                                onmouseover="this.style.backgroundColor='#0056b3'"
                                onmouseout="this.style.backgroundColor='#007bff'">{{ __('EDITAR PRODUCTO') }}</button>
                        <a href="{{ route('admin.product.index') }}" class="btn btn-secondary">CANCELAR</a>
                    </form>
                </div>
            </div>
        </div>
    </x-app-web-layout>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const saleSelect = document.getElementById('sale');
            const priceSaleInput = document.getElementById('priceSale');
            const priceKGInput = document.getElementById('priceKG');
            const priceKGFinalInput = document.getElementById('priceKGFinal');
            const priceSaleContainer = document.getElementById('priceSaleContainer');
            const form = document.getElementById('productForm');

            // Función para mostrar/ocultar el contenedor de precio de rebaja
            function togglePriceSaleContainer() {
                if (saleSelect.value === '1') {
                    priceSaleContainer.style.display = 'block';
                } else {
                    priceSaleContainer.style.display = 'none';
                    priceSaleInput.value = ''; // Limpiar el valor de priceSale si se oculta
                }
            }

            // Función para calcular y establecer el precio final (priceKGFinal)
            function calculateAndSetPriceKGFinal() {
                const priceKG = parseFloat(priceKGInput.value);
                const priceSale = parseFloat(priceSaleInput.value);

                // Verificar si hay una rebaja activa (sale = Sí) y si se ha ingresado un valor en priceSale
                if (saleSelect.value === '1' && !isNaN(priceSale)) {
                    const priceKGFinal = priceKG - priceSale;
                    priceKGFinalInput.value = priceKGFinal.toFixed(2);
                } else {
                    priceKGFinalInput.value = priceKG.toFixed(2);
                }
            }

            // Calcular y establecer priceKGFinal al cargar la página
            calculateAndSetPriceKGFinal();

            // Manejar el evento change en el campo sale
            saleSelect.addEventListener('change', function() {
                togglePriceSaleContainer();
                calculateAndSetPriceKGFinal();
            });

            // Manejar el evento input en el campo priceSale
            priceSaleInput.addEventListener('input', function() {
                calculateAndSetPriceKGFinal();
            });

            // Manejar el evento input en el campo priceKG
            priceKGInput.addEventListener('input', function() {
                calculateAndSetPriceKGFinal();
            });

            // Función para validar el formulario antes de enviarlo
            function validateForm(event) {
                if (saleSelect.value === '1') {
                    const priceSale = parseFloat(priceSaleInput.value);
                    const priceKG = parseFloat(priceKGInput.value);

                    if (isNaN(priceSale) || priceSale <= 0 || priceSale >= priceKG) {
                        alert('El campo "PRECIO REBAJADO" debe tener un valor mayor a 0 y menor que el "PRECIO/KG" cuando la opción "OFERTA" está activada.');
                        event.preventDefault(); // Prevenir el envío del formulario
                    }
                }
            }

            // Agregar el evento submit al formulario para validar antes de enviar
            form.addEventListener('submit', validateForm);
        });

        // Función para previsualizar la nueva imagen
        function previewImage(event) {
            const newImageContainer = document.getElementById('newImageContainer');
            const newImagePreview = document.getElementById('newImagePreview');
            const file = event.target.files[0];

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    newImagePreview.src = e.target.result;
                    newImageContainer.style.display = 'block';
                };
                reader.readAsDataURL(file);
            } else {
                newImageContainer.style.display = 'none';
            }
        }
    </script>
</body>
</html>
