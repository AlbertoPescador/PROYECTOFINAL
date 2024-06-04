<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Productos: Ternera</title>
    <link href="{{ asset('assets/css/productCategory.css') }}" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <x-app-layout>
        <div class="container mt-4">
            <div class="titulo"><h1 class="section-title">Ternera</h1></div>

            <!-- Barra de búsqueda y ordenamiento -->
            <div class="mb-4 search-container">
                <form id="sortAndFilterForm" method="GET" action="{{ url()->current() }}">
                    <input id="busqueda" type="text" name="busqueda" value="{{ request('busqueda') }}" placeholder="Buscar productos..." class="form-control mb-2">

                    <select id="ordenarYFiltrar" name="sort_and_filter" class="form-control">
                        <option value="" selected disabled>Ordenar o filtrar por...</option>
                        <option value="name_asc" {{ request('sort_and_filter') == 'name_asc' ? 'selected' : '' }}>Nombre (A-Z)</option>
                        <option value="name_desc" {{ request('sort_and_filter') == 'name_desc' ? 'selected' : '' }}>Nombre (Z-A)</option>
                        <option value="price_asc" {{ request('sort_and_filter') == 'price_asc' ? 'selected' : '' }}>Precio (ascendente)</option>
                        <option value="price_desc" {{ request('sort_and_filter') == 'price_desc' ? 'selected' : '' }}>Precio (descendente)</option>
                        <option value="stock_asc" {{ request('sort_and_filter') == 'stock_asc' ? 'selected' : '' }}>Stock (ascendente)</option>
                        <option value="stock_desc" {{ request('sort_and_filter') == 'stock_desc' ? 'selected' : '' }}>Stock (descendente)</option>
                    </select>
                </form>
            </div>

            <!-- Contenedor para la lista de productos -->
            <div id="productListContainer" class="d-flex flex-wrap justify-content-center">
                @include('user.product.category.busqueda', ['products' => $products])
            </div>
        </div>
    </x-app-layout>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>    
    <script>
        $(document).ready(function() {
            // Función para realizar la búsqueda AJAX
            function realizarBusquedaYFiltrar() {
                var busqueda = $('#busqueda').val().trim();
                var ordenacion = $('#ordenarYFiltrar').val();
                
                $.ajax({
                    url: '{{ url()->current() }}',
                    method: 'GET',
                    data: {
                        busqueda: busqueda,
                        sort_and_filter: ordenacion
                    },
                    success: function(response) {
                        $('#productListContainer').html(response.html);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error en la solicitud AJAX:', error);
                    }
                });
            }

            // Manejar el evento keyup en el campo de búsqueda
            $('#busqueda').on('keyup', function() {
                realizarBusquedaYFiltrar();
            });

            // Manejar el cambio en el campo de ordenación
            $('#ordenarYFiltrar').change(function() {
                realizarBusquedaYFiltrar();
            });

            // Realizar la búsqueda y el filtrado inicial al cargar la página
            realizarBusquedaYFiltrar();
        });
    </script>
</body>
<x-app-footer-layout></x-app-footer-layout>
</html>