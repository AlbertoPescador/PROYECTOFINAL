<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GESTIÓN: PEDIDOS</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        #userSearch {
            margin-top: 20px;
            text-align: center; /* Centrar contenido horizontalmente */
        }
    
        #userSearch table {
            width: 100%; /* Ocupar todo el ancho disponible */
            border-collapse: collapse;
            margin: 0 auto; /* Centrar la tabla horizontalmente */
        }
    
        #userSearch th,
        #userSearch td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center; /* Centrar contenido horizontalmente */
            vertical-align: middle; /* Alinear el contenido verticalmente en el centro */
        }
    
        #userSearch th {
            background-color: #f2f2f2;
        }

        /* Estilos para la tabla en dispositivos móviles */
        @media (max-width: 576px) {
            .table-container {
                overflow-x: auto; /* Permitir desplazamiento horizontal en dispositivos pequeños */
            }
            #userSearch table {
                width: 100%; /* Hacer que la tabla ocupe todo el ancho disponible */
            }
            #userSearch th,
            #userSearch td {
                white-space: nowrap; /* Evitar que el contenido de las celdas se divida en varias líneas */
            }
        }
    </style>     
</head>
<body>
    <x-app-web-layout>
        <div class="container">
            <div class="row justify-content-between align-items-center mb-4">
                <div class="col-sm-6">
                    <h1 class="mt-3 mb-3 fs-4">GESTIÓN CARNICERÍA - PEDIDOS</h1>
                </div>
            </div>

            <div class="row justify-content-center mb-4">
                <div class="col-sm-6">
                    <form id="searchForm" class="flex items-center">
                        <input id="busqueda" type="text" name="busqueda" class="form-control border border-gray-300 rounded-md py-1 px-2 focus:outline-none focus:border-blue-400" placeholder="Email del usuario...">
                    </form>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-sm-12">
                    <div class="table-container" id="categorySearch">
                        @include('admin.orders.busqueda')
                    </div>
                </div>
            </div>
        </div>
    </x-app-web-layout>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('busqueda').addEventListener('keyup', function() {
                let query = this.value;
                fetch("{{ route('admin.order.searchUsers') }}?search=" + query)
                    .then(response => response.text()) // Cambia a response.text()
                    .then(data => {
                        document.getElementById('userSearch').innerHTML = data;
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            });
        });
    </script>
</body>
</html>
