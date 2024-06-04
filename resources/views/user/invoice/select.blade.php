<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Recogida</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            color: #333;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 20px;
        }

        .highlighted-field {
            background-color: #f0f0f0;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.3s ease;
            margin-bottom: 20px;
        }

        .highlighted-field p {
            margin: 8px 0;
            font-size: 16px;
            font-weight: bold;
        }

        .highlighted-field span {
            font-weight: normal;
        }

        .highlighted-field:hover {
            box-shadow: 0 6px 10px rgba(0, 0, 0, 0.2);
        }

        .modern-button {
            background-color: #007bff !important;
            /* Azul primario */
            color: white !important;
            padding: 14px 20px !important;
            margin: 8px 0 !important;
            border: none !important;
            border-radius: 4px !important;
            cursor: pointer !important;
            transition: background-color 0.3s ease, transform 0.3s ease, box-shadow 0.3s ease !important;
            font-size: 16px !important;
            display: inline-block !important;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1) !important;
            /* Sombra */
        }

        .modern-button:hover {
            background-color: #0056b3 !important;
            /* Azul más oscuro */
            transform: scale(1.05) !important;
            box-shadow: 0 6px 8px rgba(0, 0, 0, 0.15) !important;
            /* Sombra más pronunciada */
        }

        label {
            font-weight: bold;
            margin-right: 10px;
        }

        select,
        input[type="datetime-local"],
        input[type="time"] {
            padding: 8px !important;
            border: 1px solid #ccc !important;
            border-radius: 4px !important;
            margin-top: 10px !important;
            width: calc(100% - 18px) !important;
        }

        .form-group label {
            display: block !important;
            margin-bottom: 5px !important;
        }

        .form-group span {
            display: block;
            margin-top: 5px;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>

<body>
    <x-app-layout>
        <main class="my-8">
            <div class="container px-6 mx-auto">
                <div class="flex justify-center my-6">
                    <div class="flex flex-col w-full p-8 text-gray-800 bg-white shadow-lg md:w-4/5 lg:w-4/5">
                        <h3 class="text-3xl font-bold mb-4">Confirmar Compra</h3>
                        <form id="confirm-form" action="{{ route('order.confirm') }}" method="POST">
                        @csrf
                        <input type="hidden" name="delivery_option" id="hidden_delivery_option">
                        <input type="hidden" name="delivery_time" id="hidden_delivery_time">
                        <input type="hidden" name="pickup_date" id="hidden_pickup_date">
                        <div class="form-group">
                            <label for="delivery_option">Selecciona una opción:</label>
                            <select id="delivery_option" name="delivery_option" required>
                                <option value="" selected disabled>Selecciona una opción</option>
                                <option value="delivery">Entrega</option>
                                <option value="pickup">Recogida</option>
                            </select>
                        </div>
                        <div class="form-group highlighted-field" id="delivery_message" style="display: none;">
                            <!-- Información de entrega -->
                                @php
                                    $total = \Cart::getTotal();
                                    $shippingCost = $total > 50 ? 0 : 7.5;
                                    $finalTotal = $total + $shippingCost;
                                    $deliveryTime = \Carbon\Carbon::now()->addDay(); // Un día después de la compra
                                @endphp
                            <p><strong>Información de Entrega:</strong></p>
                            <p><strong>Dirección de entrega:</strong> <span>{{ auth()->user()->address }}</span></p>
                            <p><strong>Precio final:</strong> <span>{{ number_format($total, 2) }}€</span></p>
                            <p><strong>Precio más envío:</strong> <span>{{ number_format($finalTotal, 2) }}€</span></p>
                            <p><strong>Fecha de envío:</strong> <span>{{ $deliveryTime->format('d-m-Y') }}</span></p>
                            <p><strong>Cobro de envío:</strong> <span>{{ $shippingCost > 0 ? 'Sí' : 'No' }}</span></p>
                            <label for="delivery_time">Selecciona la hora de recepción:</label>
                            <input type="time" id="delivery_time" name="delivery_time">
                            <span>Horario de entrega: 10:00 - 18:00</span>
                        </div>
                        <div class="form-group highlighted-field" id="pickup_message" style="display: none;">
                            <label for="pickup_date">Selecciona la fecha y hora de recogida:</label>
                            <input type="datetime-local" id="pickup_date" name="pickup_date">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="modern-button" id="confirm_button" disabled>Confirmar Compra</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </main>
    </x-app-layout>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const deliveryMethodSelect = document.getElementById('delivery_option');
            const deliveryMessageDiv = document.getElementById('delivery_message');
            const pickupMessageDiv = document.getElementById('pickup_message');
            const pickupDateInput = document.getElementById('pickup_date');
            const deliveryTimeInput = document.getElementById('delivery_time');
            const confirmButton = document.getElementById('confirm_button');
            const confirmForm = document.getElementById('confirm-form');

            const isValidPickupTime = (date) => {
                const day = date.getDay();
                const hour = date.getHours();

                if (day >= 1 && day <= 5) { // Lunes a Viernes
                    return hour >= 10 && hour < 20;
                } else if (day === 6) { // Sábado
                    return hour >= 8 && hour < 18;
                } else if (day === 0) { // Domingo
                    return hour >= 9 && hour < 15;
                }
                return false;
            };

            const isValidDeliveryTime = (time) => {
                const [hour] = time.split(':').map(Number);
                return hour >= 10 && hour < 18; // Horario de entrega de 10:00 a 18:00
            };

            const checkValidity = () => {
                if (deliveryMethodSelect.value === 'delivery') {
                    if (deliveryTimeInput.value && isValidDeliveryTime(deliveryTimeInput.value)) {
                        confirmButton.disabled = false;
                    } else {
                        confirmButton.disabled = true;
                    }
                } else if (deliveryMethodSelect.value === 'pickup') {
                    if (pickupDateInput.value && isValidPickupTime(new Date(pickupDateInput.value))) {
                        confirmButton.disabled = false;
                    } else {
                        confirmButton.disabled = true;
                    }
                } else {
                    confirmButton.disabled = true;
                }
            };

            pickupDateInput.addEventListener('input', (event) => {
                const inputDate = new Date(event.target.value);
                if (!isValidPickupTime(inputDate)) {
                    alert('Por favor selecciona un horario válido para la recogida.');
                    event.target.value = '';
                }
                checkValidity();
            });

            deliveryTimeInput.addEventListener('input', (event) => {
                if (!isValidDeliveryTime(event.target.value)) {
                    alert('Por favor selecciona un horario válido para la entrega.');
                    event.target.value = '';
                }
                checkValidity();
            });

            deliveryMethodSelect.addEventListener('change', function (event) {
                const selectedOption = event.target.value;
                if (selectedOption === 'delivery') {
                    deliveryMessageDiv.style.display = 'block';
                    pickupMessageDiv.style.display = 'none';
                    pickupDateInput.removeAttribute('required');
                    deliveryTimeInput.setAttribute('required', 'required');
                } else if (selectedOption === 'pickup') {
                    pickupMessageDiv.style.display = 'block';
                    deliveryMessageDiv.style.display = 'none';
                    setPickupDateTimeMin();
                    deliveryTimeInput.removeAttribute('required');
                    pickupDateInput.setAttribute('required', 'required');
                } else {
                    deliveryMessageDiv.style.display = 'none';
                    pickupMessageDiv.style.display = 'none';
                }
                checkValidity();
            });

            const setPickupDateTimeMin = () => {
                const now = new Date();
                const currentHour = now.getHours();
                const currentDay = now.getDay();

                if (currentDay >= 1 && currentDay <= 5) { // Lunes a Viernes
                    if (currentHour >= 19) {
                        now.setDate(now.getDate() + 1);
                        now.setHours(10, 0, 0, 0);
                    } else if (currentHour < 9) {
                        now.setHours(10, 0, 0, 0);
                    }
                } else if (currentDay === 6) { // Sábado
                    if (currentHour >= 17) {
                        now.setDate(now.getDate() + 1);
                        now.setHours(9, 0, 0, 0);
                    } else if (currentHour < 8) {
                        now.setHours(8, 0, 0, 0);
                    }
                } else if (currentDay === 0) { // Domingo
                    if (currentHour >= 14) {
                        now.setDate(now.getDate() + 1);
                        now.setHours(10, 0, 0, 0);
                    } else if (currentHour < 9) {
                        now.setHours(9, 0, 0, 0);
                    }
                }

                now.setMinutes(now.getMinutes() + 60); // Añadir 1 hora
                pickupDateInput.min = now.toISOString().slice(0, 16);
            };

            confirmForm.addEventListener('submit', (event) => {
                if (confirmButton.disabled) {
                    event.preventDefault();
                    alert('Por favor completa todos los campos requeridos con valores válidos.');
                }
            });

            checkValidity();
        });
    </script>
</body>

</html>