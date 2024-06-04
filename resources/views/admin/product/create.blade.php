<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AÑADIR PRODUCTO</title>
    <style>
        input:invalid {
            border-color: red;
        }
    </style>
</head>
<body>
    <x-app-web-layout>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-sm-8">
                    <h1 class="mt-3 mb-3 fs-4">AÑADIR PRODUCTO</h1>
                    <form id="productForm" action="{{ route('admin.product.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="name">NOMBRE:</label>
                            <input type="text" class="form-control" id="name" name="name" pattern="^[A-Za-zÀ-ÿ\s]+$" title="Solo se permiten letras y espacios" required>
                        </div>
                        <div class="form-group">
                            <label for="description">DESCRIPCIÓN:</label>
                            <input type="text" class="form-control" id="description" name="description" pattern="^[A-Za-zÀ-ÿ\s]+$" title="Solo se permiten letras y espacios" required>
                        </div>
                        <div class="form-group">
                            <label for="stock">STOCK:</label>
                            <input type="number" step="0.5" min="0.5" class="form-control" id="stock" name="stock" title="Debe ser mayor a 0 y una cantidad media o entera (por ejemplo, 0.5 o entero)" required>
                        </div>
                        <div class="form-group">
                            <label for="sale">¿EN OFERTA?:</label>
                            <select class="form-control" id="sale" name="sale">
                                <option value="0">No</option>
                                <option value="1">Sí</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="priceKG">PRECIO / KG:</label>
                            <input type="number" step="0.01" min="0" class="form-control" id="priceKG" name="priceKG" title="Debe ser un número positivo con dos decimales" required>
                        </div>
                        <div class="form-group">
                            <label for="urlImagen">IMAGEN DEL PRODUCTO:</label>
                            <input type="file" accept=".jpg, .png" class="form-control" id="urlImagen" name="urlImagen" required>
                        </div>
                        <div id="imagePreviewContainer" style="display: none;">
                            <label for="imagePreview">Previsualización de la Imagen:</label>
                            <img id="imagePreview" src="#" alt="Previsualización de la Imagen" style="max-width: 200px; margin-top: 10px;">
                        </div>
                        <div class="form-group">
                            <label for="category">SELECCIONE UNA CATEGORÍA:</label>
                            <select name="category_id" class="form-control" required>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group" id="precioRebajadoContainer" style="display: none;">
                            <label for="priceSale">PRECIO REBAJADO:</label>
                            <input type="number" step="0.01" min="0" class="form-control" id="priceSale" name="priceSale" disabled>
                        </div>
                        <div class="form-group">
                            <label for="priceKGFinal">PRECIO FINAL:</label>
                            <input type="number" step="0.01" class="form-control" id="priceKGFinal" name="priceKGFinal" disabled>
                        </div>
                        <br>
                        <button type="submit" 
                                style="background-color: #007bff; color: #fff; border: none; padding: 8px 16px; border-radius: 4px; transition: background-color 0.3s ease;"
                                onmouseover="this.style.backgroundColor='#0056b3'"
                                onmouseout="this.style.backgroundColor='#007bff'">
                            {{ __('CREAR PRODUCTO') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </x-app-web-layout>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const saleSelect = document.getElementById('sale');
            const precioRebajadoContainer = document.getElementById('precioRebajadoContainer');
            const precioRebajadoInput = document.getElementById('priceSale');
            const precioKGInput = document.getElementById('priceKG');
            const precioFinalInput = document.getElementById('priceKGFinal');
            const form = document.getElementById('productForm');
            const urlImagenInput = document.getElementById('urlImagen');
            const imagePreviewContainer = document.getElementById('imagePreviewContainer');
            const imagePreview = document.getElementById('imagePreview');

            saleSelect.addEventListener('change', function() {
                const sale = parseInt(saleSelect.value);

                if (sale === 1) {
                    precioRebajadoContainer.style.display = 'block';
                    precioRebajadoInput.removeAttribute('disabled');
                } else {
                    precioRebajadoContainer.style.display = 'none';
                    precioRebajadoInput.setAttribute('disabled', 'disabled');
                    precioRebajadoInput.value = '';
                    recalcularPrecioFinal();
                }
            });

            precioRebajadoInput.addEventListener('input', recalcularPrecioFinal);
            precioKGInput.addEventListener('input', recalcularPrecioFinal);

            urlImagenInput.addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        imagePreview.src = e.target.result;
                        imagePreviewContainer.style.display = 'block';
                    };
                    reader.readAsDataURL(file);
                } else {
                    imagePreviewContainer.style.display = 'none';
                }
            });

            form.addEventListener('submit', function(event) {
                if (saleSelect.value === '1') {
                    const precioRebajado = parseFloat(precioRebajadoInput.value) || 0;
                    const precioKG = parseFloat(precioKGInput.value) || 0;

                    if (precioRebajado <= 0 || precioRebajado >= precioKG) {
                        alert('El campo "PRECIO REBAJADO" debe tener un valor mayor a 0 y menor que el "PRECIO / KG" cuando la opción "OFERTA" está activada.');
                        event.preventDefault();
                    }
                }
            });

            function recalcularPrecioFinal() {
                const precioRebajado = parseFloat(precioRebajadoInput.value) || 0;
                const precioKG = parseFloat(precioKGInput.value) || 0;

                const precioFinal = (saleSelect.value === '1' && precioRebajado > 0 && precioRebajado < precioKG) ? (precioKG - precioRebajado) : precioKG;
                precioFinalInput.value = precioFinal.toFixed(2);
            }

            recalcularPrecioFinal();
        });
    </script>
</body>
</html>
