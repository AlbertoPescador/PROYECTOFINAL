<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Productos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
        }

        .container {
            padding: 20px;
        }

        .card {
            display: flex;
            flex-direction: column;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            max-width: 800px;
            margin: 20px auto;
            overflow: hidden;
        }

        .visit-counter {
            text-align: center;
            padding: 10px;
            font-size: 16px;
            background-color: rgba(255, 255, 255, 0.5); /* Semi-transparent background */
            border-bottom: 1px solid #ddd; /* Separation line */
            font-weight: bold;
            color: #333;
        }

        .card-image {
            flex: 1;
            border-top: 1px solid #ddd; /* Separation line */
        }

        .card-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .card-content {
            flex: 1;
            padding: 20px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .card-content h2 {
            margin: 0 0 10px;
            font-size: 24px;
            color: #333;
        }

        .card-content p {
            margin: 0;
            color: #666;
        }

        .text-center {
            text-align: center;
        }

        .fs-4 {
            font-size: 1.5rem;
        }

        #cmsinfo_block {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin: 20px 0;
        }

        .info-column {
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .info-column ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .info-column li {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }

        .info-column em {
            margin-right: 10px;
            font-size: 24px;
        }

        .info-column h3, .info-column h4 {
            margin: 0 0 5px;
        }

        .info-column p {
            margin: 0;
        }

        .icon-phone::before {
            content: "\260E";
        }

        .icon-truck::before {
            content: "\1F69A";
        }

        .dark {
            font-weight: bold;
            color: #333;
        }

        .bold {
            font-weight: bold;
        }

        .title1 {
            text-align: center;
            font-size: 35px;
            font-style: oblique;
            font-weight: bold;
        }

        .info-column h3 {
            font-size: 20px;
        }

    </style>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Check if visitCount exists in localStorage
            if (localStorage.getItem('visitCount')) {
                // Increment the visit count
                localStorage.setItem('visitCount', Number(localStorage.getItem('visitCount')) + 1);
            } else {
                // Initialize visit count
                localStorage.setItem('visitCount', 1);
            }

            // Display the visit count
            const visitCount = localStorage.getItem('visitCount');
            document.getElementById('visit-counter').textContent = `Número de visitas: ${visitCount}`;
        });
    </script>
</head>
<body>
    <x-app-layout>
        <div class="container">
            @if(session()->has('success'))
                <script>
                    window.onload = function() {
                        alert("{{ session('success') }}");
                    };
                </script>
            @endif

            <!-- Tarjeta de la carnicería "La Calidad" -->
            <div class="card">
                <div class="visit-counter" id="visit-counter"></div>
                <div class="card-image">
                    <!-- Imagen de ejemplo. Reemplaza la ruta según sea necesario. -->
                    <img src="{{asset('assets/principalimagen.jpg')}}" alt="Imagen de la carnicería La Calidad">
                </div>
                <div class="card-content">
                    <h2>Carnicería "La Calidad"</h2>
                    <p>Bienvenidos a la carnicería "La Calidad". Ofrecemos los mejores cortes de carne con la frescura y calidad que nos caracteriza. Visítanos y disfruta de una experiencia única.</p>
                </div>
            </div>
            <br>
            <hr>
            <br>
            <h1 class="title1">SOMOS ÚNICOS EN EL SECTOR ANDALUZ</h1>
            <br>
            <hr>
            <br>
            <!-- Nuevo bloque cmsinfo_block -->
            <div id="cmsinfo_block">
                <div class="info-column">
                    <ul>
                        <li>
                            <em class="icon-phone" id="icon-phone"></em>
                            <div class="type-text">
                                <h3 class="bold">Llámenos: <a href="tel: 621 06 48 73">621 06 48 73</a></h3>
                                <p>Le atenderemos por teléfono en horario comercial</p>
                            </div>
                        </li>
                        <li>
                            <em class="icon-truck" id="icon-truck"></em>
                            <div class="type-text">
                                <h3 class="bold">Transporte a domicilio en Córdoba. Su pedido en 24 h.</h3>
                                <h4 class="bold">Envíos: 7,5 €. Gratis a partir de 50 €</h4>
                                <p>No hacemos envíos fuera de Córdoba</p>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="info-column">
                    <h3 class="bold">Envíos al vacío</h3>
                    <p>Todos los pedidos los envasamos al vacío</p>
                    <h3 style="margin-top: 16px;" class="bold">Sin romper la cadena de frío</h3>
                    <p>De nuestra carnicería a tu casa, en transporte refrigerado</p>
                    <h3 style="margin-top: 14px;" class="bold">Compra online de carne</h3>
                    <p>Una gran variedad de productos cárnicos</p>
                </div>
            </div>
        </div>
    </x-app-layout>
</body>
<x-app-footer-layout></x-app-footer-layout>
</html>
