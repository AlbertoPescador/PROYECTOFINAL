<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EDITAR CATEGORÍA</title>
</head>
<body>
    <x-app-web-layout>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-sm-8">
                    <h1 class="mt-3 mb-3 fs-4">EDITAR CATEGORÍA</h1>
                    <form action="{{ route('admin.category.update', $category->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="id" class="form-label">ID</label>
                            <input type="text" id="id" name="id" value="{{ $category->id }}" class="form-control" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="name" class="form-label">NOMBRE DE LA CATEGORÍA</label>
                            <input type="text" id="name" name="name" value="{{ $category->name }}" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label for="sale" class="form-label">OFERTA</label>
                            <select id="sale" name="sale" class="form-control" onchange="togglePriceSale()">
                                <option value="0" {{ $category->sale == 0 ? 'selected' : '' }}>No</option>
                                <option value="1" {{ $category->sale == 1 ? 'selected' : '' }}>Sí</option>
                            </select>
                        </div>

                        <div class="mb-3" id="priceSaleContainer" style="display: {{ $category->sale == 1 ? 'block' : 'none' }}">
                            <label for="priceSale" class="form-label">PRECIO REBAJADO</label>
                            <input type="text" id="priceSale" name="priceSale" value="{{ $category->priceSale }}" class="form-control">
                        </div>

                        <button type="submit" 
                                style="background-color: #007bff; color: #fff; border: none; padding: 8px 16px; border-radius: 4px; transition: background-color 0.3s ease;"
                                onmouseover="this.style.backgroundColor='#0056b3'"
                                onmouseout="this.style.backgroundColor='#007bff'">
                            {{ __('GUARDAR CAMBIOS') }}
                        </button>
                        <a href="{{ route('admin.category.index') }}" class="btn btn-secondary">CANCELAR</a>
                    </form>
                </div>
            </div>
        </div>
    </x-app-web-layout>

    <script>
        function togglePriceSale() {
            var saleValue = document.getElementById('sale').value;
            var priceSaleContainer = document.getElementById('priceSaleContainer');
    
            // Verificar si el valor seleccionado es "Sí"
            if (saleValue === '0') {
                priceSaleContainer.style.display = 'none'; // Mostrar el campo de precio rebajado
            } else {
                priceSaleContainer.style.display = 'block'; // Ocultar el campo de precio rebajado
            }
        }
        
        // Llamar a la función togglePriceSale() inicialmente para asegurarse de que el campo de precio rebajado se muestre correctamente al cargar la página
        window.onload = function() {
            togglePriceSale();
        };
    </script>
    
    
</body>
</html>
