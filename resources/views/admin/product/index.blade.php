<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GESTIÓN: PRODUCTOS</title>
    <!-- Estilos CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .table-container {
            width: 90%;
            margin: 0 auto;
            overflow-x: auto; /* Agregar desplazamiento horizontal */
        }

        .table-responsive {
            overflow-x: auto; /* Agregar desplazamiento horizontal */
        }

        /* Estilo para las imágenes en la tabla */
        .product-image {
            max-width: 60px; /* Ancho máximo para las imágenes */
            max-height: 60px; /* Altura máxima para las imágenes */
            height: auto;
            display: block;
            margin: 0 auto; /* Centrar la imagen horizontalmente */
            border-radius: 5px;
        }

        /* Estilos para la tabla de resultados */
        #productSearch table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        #productSearch th,
        #productSearch td {
            padding: 8px; /* Reducir el padding */
            border: 1px solid #ddd;
            text-align: center; /* Centrar el contenido horizontalmente */
            vertical-align: middle; /* Alinear el contenido verticalmente en el centro */
        }

        #productSearch th {
            background-color: #f2f2f2;
        }

        /* Consultas de Medios para Tabletas */
        @media (max-width: 768px) {
            .table-container {
                width: 100%; /* Ancho completo en tabletas */
            }
        }

        /* Consultas de Medios para Dispositivos Móviles */
        @media (max-width: 576px) {
            .table-container {
                width: 100%; /* Ancho completo en dispositivos móviles */
            }

            /* Reducir el tamaño de la imagen en dispositivos móviles */
            .product-image {
                max-width: 40px;
                max-height: 40px;
            }

            /* Reducir el padding en dispositivos móviles */
            #productSearch th,
            #productSearch td {
                padding: 6px;
            }
        }
    </style>    
</head>
<body>
    <x-app-web-layout>
        <div class="container">
            <div class="row justify-content-center align-items-center mb-4 mt-3">
                <div class="col-sm-12 col-md-6">
                    <h1 class="mt-3 mb-3 fs-4 text-center text-md-left">GESTIÓN CARNICERÍA - PRODUCTOS</h1>
                </div>
                <div class="col-sm-12 col-md-6 text-center text-md-right">
                    <a href="{{ route("admin.product.create") }}" class="btn btn-success">CREAR PRODUCTO</a>
                </div>
            </div>

            <div class="row justify-content-center mb-4">
                <div class="col-sm-12 col-md-6">
                    <form id="searchForm" class="flex items-center">
                        <input id="busqueda" type="text" name="busqueda" class="form-control border border-gray-300 rounded-md py-1 px-2 focus:outline-none focus:border-blue-400" placeholder="Nombre del producto...">
                    </form>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-sm-12">
                    <div class="table-container" id="productSearch">
                        <div class="table-responsive">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-app-web-layout>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script>
            $(document).ready(function() {
                // Función para realizar la búsqueda AJAX
                function realizarBusqueda(busqueda) {
                    $.ajax({
                        url: '{{ route("product.searchAdmin") }}',
                        method: 'GET',
                        data: {
                            busqueda: busqueda
                        },
                        success: function(response) {
                            $('#productSearch').html(response.html);
                            // Aplicar estilos a la tabla después de cargar los resultados
                            $('#productSearch table').addClass('table table-bordered text-center');
                            $('.product-image').addClass('img-fluid rounded');
                        },
                        error: function(xhr, status, error) {
                            console.error('Error en la solicitud AJAX:', error);
                        }
                    });
                }

                // Manejar el evento keyup en el campo de búsqueda
                $('#busqueda').on('keyup', function() {
                    var query = $(this).val().trim(); // Obtener el valor del campo de búsqueda (eliminando espacios en blanco)
                    realizarBusqueda(query); // Realizar la búsqueda AJAX
                });

                // Realizar la búsqueda inicial al cargar la página
                realizarBusqueda('');
            });
        </script>
</body>
</html>
