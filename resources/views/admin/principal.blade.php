<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMINISTRADOR</title>
    <style>
        /* Estilos específicos para la vista de bienvenida del administrador */
        .welcome-container {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            padding: 0 20px; /* Añadir un padding horizontal para evitar que los estilos afecten al menú */
        }

        .welcome-content {
            text-align: center;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            background-color: #ffffff;
            max-width: 500px;
            width: 100%; /* Ajustar el ancho al 100% del contenedor */
        }

        .welcome-title {
            font-size: 2.5rem;
            color: #007bff;
            margin-bottom: 20px;
        }

        .welcome-text {
            font-size: 1.2rem;
            color: #555;
            margin-bottom: 30px;
        }

        .welcome-image {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <x-app-web-layout>
        <!-- Contenedor específico para la vista de bienvenida -->
        <div class="welcome-container">
            <div class="welcome-content">
                <img src="https://static.vecteezy.com/system/resources/previews/014/341/422/non_2x/home-system-administrator-icon-cartoon-computer-server-vector.jpg" alt="Bienvenido Administrador" class="welcome-image">
                <h1 class="welcome-title">Bienvenido administrador: {{ Auth::user()->name }}</h1>
                <p class="welcome-text">¡Disfruta de tu sesión de administrador!</p>
            </div>
        </div>
    </x-app-web-layout>
</body>
</html>
