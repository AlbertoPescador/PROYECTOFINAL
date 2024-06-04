<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
</head>
<body>
    <x-guest-layout>
        <form method="POST" action="{{ route('register') }}" id="registerForm">
            @csrf

            <div>
                <label for="role" class="block font-medium text-sm text-gray-70">Tipo de cuenta</label>
                <select name="role" class="block mt-1 w-full" required>
                    <option value="user">Usuario</option>
                    <option value="admin" disabled>Administrador</option>
                </select>
            </div>        
            <br>
            <!-- Name -->
            <div class="mt-4">
                <x-input-label for="name" :value="__('Nombre')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Address -->
            <div class="mt-4">
                <x-input-label for="address" :value="__('Dirección')" />
                <x-text-input id="address" class="block mt-1 w-full" type="text" name="address" :value="old('address')" required autocomplete="address" />
                <x-input-error :messages="$errors->get('address')" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Contraseña')" />
                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-input-label for="password_confirmation" :value="__('Confirmar Contraseña')" />
                <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                    {{ __('¿Tienes cuenta?') }}
                </a>

                <x-primary-button class="ms-4">
                    {{ __('Registrar') }}
                </x-primary-button>
            </div>
        </form>
    </x-guest-layout>

    <script>
        document.getElementById('registerForm').addEventListener('submit', function(event) {
            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            const address = document.getElementById('address').value;
            const password = document.getElementById('password').value;
            const passwordConfirmation = document.getElementById('password_confirmation').value;

            // Validar el campo nombre
            const nameRegex = /^[A-Za-zÀ-ÿ\s]+$/;
            if (!nameRegex.test(name)) {
                alert('El campo "Nombre" solo puede contener letras y espacios.');
                event.preventDefault();
                return;
            }

            // Validar el campo email
            const emailRegex = /^[a-z0-9._%+-]+@(gmail|hotmail)\.(com|es)$/;
            if (!emailRegex.test(email)) {
                alert('El campo "Email" debe ser una dirección de correo electrónico válida con dominios gmail.com, gmail.es, hotmail.com o hotmail.es.');
                event.preventDefault();
                return;
            }

            // Validar el campo dirección
            const addressRegex = /^[A-Za-z0-9À-ÿ\s]+$/;
            if (!addressRegex.test(address)) {
                alert('El campo "Dirección" solo puede contener letras, números y espacios.');
                event.preventDefault();
                return;
            }

            // Validar que las contraseñas coincidan
            if (password !== passwordConfirmation) {
                alert('Las contraseñas no coinciden.');
                event.preventDefault();
                return;
            }
        });
    </script>
</body>
</html>
