<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contáctanos</title>
</head>
<body>
<x-app-layout>
    <img src="{{ asset('assets/logo.png') }}" 
        width="200" height="400"
        style="display: block; margin: 0 auto;"
    />
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header">{{ __('¿ALGUNA DUDA O SUGERENCIA? ¡¡CONTACTANOS!!') }}</div>

                    <div class="card-body">
                        <!-- Contenido del formulario de contacto -->
                        <form method="POST" action="{{ route('contact.store') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="name" class="form-label">{{ __('Nombre') }}</label>
                                <input type="text" class="form-control" id="name" name="name">
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">{{ __('Correo Electrónico') }}</label>
                                <input type="email" class="form-control" id="email" name="email">
                            </div>

                            <div class="mb-3">
                                <label for="message" class="form-label">{{ __('Mensaje') }}</label>
                                <textarea class="form-control" id="message" name="message" rows="5"></textarea>
                            </div>

                            <button type="submit" 
                                    style="background-color: #007bff; color: #fff; border: none; padding: 8px 16px; border-radius: 4px; transition: background-color 0.3s ease;"
                                    onmouseover="this.style.backgroundColor='#0056b3'"
                                    onmouseout="this.style.backgroundColor='#007bff'">
                                {{ __('Enviar') }}
                            </button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
</body>
</html>