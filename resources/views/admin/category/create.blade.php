<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>AÑADIR CATEGORÍA</title>
</head>
<body>
  <x-app-web-layout>
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-sm-8">
          <h1 class="mt-3 mb-3 fs-4">AÑADIR CATEGORÍA</h1>
          <form action="{{ route('admin.category.store') }}" method="post" id="categoryForm">
            @csrf
            <label for="name">NOMBRE DE LA CATEGORÍA:</label></br>
            <input type="text" name="name" id="name" class="form-control" required 
                   pattern="[A-Za-z\s]+" title="Solo se permiten letras y espacios">
            <span id="nameError" style="color: red; display: none;">Solo se permiten letras y espacios.</span></br>
            <button type="submit" 
                    style="background-color: #007bff; color: #fff; border: none; padding: 8px 16px; border-radius: 4px; transition: background-color 0.3s ease;"
                    onmouseover="this.style.backgroundColor='#0056b3'"
                    onmouseout="this.style.backgroundColor='#007bff'">
              {{ __('CREAR CATEGORÍA') }}
            </button>
          </form>
        </div>
      </div>
    </div>
  </x-app-web-layout>
  
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const nameInput = document.getElementById('name');
      const nameError = document.getElementById('nameError');
      const form = document.getElementById('categoryForm');

      // Validar en tiempo real
      nameInput.addEventListener('input', function() {
        const regex = /^[A-Za-z\s]+$/;
        if (!regex.test(nameInput.value)) {
          nameError.style.display = 'inline';
        } else {
          nameError.style.display = 'none';
        }
      });

      // Validar al enviar el formulario
      form.addEventListener('submit', function(event) {
        const regex = /^[A-Za-z\s]+$/;
        if (!regex.test(nameInput.value)) {
          nameError.style.display = 'inline';
          event.preventDefault(); // Prevenir el envío del formulario si la validación falla
        } else {
          nameError.style.display = 'none';
        }
      });
    });
  </script>
</body>
</html>
