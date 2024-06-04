<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GESTIÓN: USUARIOS</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Estilos adicionales */
        .card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.3s ease;
        }

        .card:hover {
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .strikethrough {
            text-decoration: line-through;
        }

        .search-label {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .search-container {
            margin-bottom: 20px;
        }

        .search-input {
            border: 2px solid #ced4da;
            border-radius: 4px;
            padding: 10px;
            font-size: 16px;
        }

        .btn-secondary {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Lista de Usuarios</h1>
        <a href="{{ route('admin.principal') }}" class="btn btn-secondary">VOLVER A LA PÁGINA PRINCIPAL</a>

        <!-- Campo de búsqueda -->
        <div class="search-container">
            <label for="search" class="search-label">Buscar por correo:</label>
            <input type="text" id="search" class="form-control search-input" placeholder="Introduzca el correo">
        </div>

        <div class="row justify-content-center" id="userSearchResults">
            <!-- Aquí se mostrarán los resultados de la búsqueda -->
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            function realizarBusqueda(busqueda) {
                $.ajax({
                    url: '{{ route("user.search") }}',
                    method: 'GET',
                    data: {
                        search: busqueda
                    },
                    success: function(response) {
                        $('#userSearchResults').html(response.html);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error en la solicitud AJAX:', error);
                        $('#userSearchResults').html('<strong><p>Error en el servidor. Inténtelo de nuevo más tarde.</p></strong>');
                    }
                });
            }

            $('#search').on('keyup', function() {
                var query = $(this).val().trim();
                realizarBusqueda(query);
            });

            realizarBusqueda('');
        });
    </script>
</body>
</html>
