<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GESTIÓN: CATEGORÍAS</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .table-container {
            width: 90%;
            margin: 0 auto;
            text-align: center; /* Centrar contenido horizontalmente */
        }
    
        #categorySearch table {
            width: 100%; /* Ocupar todo el ancho disponible */
            border-collapse: collapse;
            margin: 0 auto; /* Centrar la tabla horizontalmente */
        }
    
        #categorySearch th,
        #categorySearch td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center; /* Centrar contenido horizontalmente */
            vertical-align: middle; /* Alinear el contenido verticalmente en el centro */
        }
    
        #categorySearch th {
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

            /* Reducir el padding en dispositivos móviles */
            #categorySearch th,
            #categorySearch td {
                padding: 6px;
            }
        }
    </style>    
</head>
<body>
    <x-app-web-layout>
        <div class="container">
            <div class="row justify-content-between align-items-center mb-4">
                <div class="col-sm-6">
                    <h1 class="mt-3 mb-3 fs-4">GESTIÓN CARNICERÍA - CATEGORÍAS</h1>
                </div>
                <div class="col-sm-6 text-center text-sm-right"> <!-- Modificación aquí -->
                    <a href="{{ route('admin.category.create') }}" class="btn btn-success">CREAR CATEGORÍA</a>
                </div>
            </div>

            <div class="row justify-content-center mb-4">
                <div class="col-sm-6">
                    <form id="searchForm" class="flex items-center">
                        <input id="busqueda" type="text" name="busqueda" class="form-control border border-gray-300 rounded-md py-1 px-2 focus:outline-none focus:border-blue-400" placeholder="Nombre de la categoría...">
                    </form>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-sm-12">
                    <div class="table-container" id="categorySearch">
                        @include('admin.category.busqueda')
                    </div>
                </div>
            </div>
        </div>
    </x-app-web-layout>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            function realizarBusqueda(busqueda) {
                $.ajax({
                    url: '{{ route("category.searchAdmin") }}',
                    method: 'GET',
                    data: {
                        busqueda: busqueda
                    },
                    success: function(response) {
                        $('#categorySearch').html(response.html);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error en la solicitud AJAX:', error);
                    }
                });
            }

            $('#busqueda').on('keyup', function() {
                var query = $(this).val().trim();
                realizarBusqueda(query);
            });

            realizarBusqueda('');
        });
    </script>
</body>
</html>
