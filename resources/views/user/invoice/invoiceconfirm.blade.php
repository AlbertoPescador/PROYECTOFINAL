<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Carrito</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .drop-area {
            width: 100%;
            max-width: 300px;
            height: 200px;
            border: 2px dashed #ccc;
            border-radius: 8px;
            text-align: center;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 18px;
            margin: 20px auto;
            cursor: pointer; /* Añadido para cambiar el cursor al pasar sobre la zona de arrastre */
        }
        .drag-over {
            border-color: #000;
        }
        .draggable {
            width: 100px;
            padding: 10px;
            background-color: #007bff;
            color: white;
            text-align: center;
            border-radius: 8px;
            cursor: move;
            margin: 20px auto;
            user-select: none;
        }
    </style>
</head>
<body>
    <x-app-layout>
        <main class="my-8">
            <div class="container px-6 mx-auto">
                <div class="flex justify-center my-6">
                    <div class="flex flex-col w-full p-8 text-gray-800 bg-white shadow-lg md:w-4/5 lg:w-4/5">
                        @if ($message = Session::get('success'))
                            <div class="p-4 mb-3 bg-blue-400 rounded">
                                <p class="text-white">{{ $message }}</p>
                            </div>
                        @endif
                        @if ($message = Session::get('error'))
                            <div class="p-4 mb-3 bg-red-400 rounded">
                                <p class="text-white">{{ $message }}</p>
                            </div>
                        @endif
                        <h3 class="text-3xl font-bold mb-4">Carro</h3>
                        <div class="flex-1">
                            <div class="draggable" draggable="true" id="draggable-button">
                                Arrástrame
                            </div>
                            <div id="drop-area" class="drop-area">
                                Arrastra aquí para confirmar la compra
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </x-app-layout>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dropArea = document.getElementById('drop-area');
            const draggableButton = document.getElementById('draggable-button');

            draggableButton.addEventListener('dragstart', function(event) {
                event.dataTransfer.setData('text/plain', 'Drag Me');
            });

            dropArea.addEventListener('dragover', function(event) {
                event.preventDefault();
                dropArea.classList.add('drag-over');
            });

            dropArea.addEventListener('dragleave', function(event) {
                dropArea.classList.remove('drag-over');
            });

            dropArea.addEventListener('drop', function(event) {
                event.preventDefault();
                dropArea.classList.remove('drag-over');
                console.log('Drop Event Triggered');
                
                // Recuperar el texto arrastrado
                var data = event.dataTransfer.getData("text");
                console.log('Text Dropped: ', data);
                
                // Redirigir a la URL especificada
                window.location.href = "{{ route('cart.select') }}";
            });

            // Touch events for mobile devices
            draggableButton.addEventListener('touchstart', function(event) {
                event.dataTransfer = event.target;
                dropArea.classList.add('drag-over');
            });

            draggableButton.addEventListener('touchend', function(event) {
                dropArea.classList.remove('drag-over');
                console.log('Touch Event Triggered');
                window.location.href = "{{ route('cart.select') }}";
            });

            draggableButton.addEventListener('touchcancel', function(event) {
                dropArea.classList.remove('drag-over');
            });
        });
    </script>
</body>
</html>
