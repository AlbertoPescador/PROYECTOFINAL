<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Pedidos</title>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>
<body>
    <x-app-layout> 
        <div class="container mx-auto px-4">
            <h2 class="text-2xl font-semibold my-8">Mis Pedidos</h2>

            <!-- Formulario de búsqueda por fecha -->
            <form id="searchForm" class="mb-4">
                <div class="form-group">
                    <label for="start_date">Buscar por fecha:</label>
                    <input type="date" id="start_date" name="start_date" class="form-control">
                </div>
            </form>

            <!-- Lista de facturas -->
            <div id="invoicesList">
                @include('user.invoice.busqueda', ['invoices' => $invoices])
            </div>
        </div>
    </x-app-layout>

    <script>
        $(document).ready(function() {
            // Función para realizar la búsqueda por fecha utilizando AJAX
            function searchInvoices() {
                var startDate = $('#start_date').val();

                $.ajax({
                    url: "{{ route('invoices.search') }}",
                    type: 'GET',
                    data: { start_date: startDate },
                    success: function(response) {
                        $('#invoicesList').html(response);
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            }

            // Evento change del campo de fecha
            $('#start_date').change(function() {
                searchInvoices();
            });

            // Ejecutar la búsqueda al cargar la página (opcional)
            searchInvoices();
        });
    </script>
</body>
</html>
