<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Confirmar Compra</title>
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
        }

        .modern-button:hover {
            background-color: #0056b3 !important;
            transform: scale(1.05) !important;
            box-shadow: 0 6px 8px rgba(0, 0, 0, 0.15) !important;
        }

        label {
            font-weight: bold;
            margin-right: 10px;
        }

        select,
        input[type="datetime-local"] {
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
                            <input type="hidden" name="pickup_date" id="hidden_pickup_date">
                            <input type="hidden" name="final_total" id="hidden_final_total">
                            <div class="form-group">
                                <label for="delivery_option">Selecciona una opción:</label>
                                <select id="delivery_option" name="delivery_option" required>
                                    <option value="" selected disabled>Selecciona una opción</option>
                                    <option value="delivery">Entrega</option>
                                    <option value="pickup">Recogida</option>
                                </select>
                            </div>
                            <div class="form-group highlighted-field" id="delivery_message" style="display: none;">
                                @php
                                    $priceTotal = 0; // Inicializa el total en 0
                                @endphp
                                @foreach ($cartItems as $item)
                                    @php
                                        $priceBandeja = $item->price * $item->attributes['tipoBandeja'];
                                        $priceTotal += $priceBandeja * $item->quantity; // Calcula el total sumando los precios de cada ítem en el carrito
                                    @endphp
                                @endforeach
                                @php
                                    $total = $priceTotal;
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
                                <p id="delivery_time_period"></p>
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
            const confirmButton = document.getElementById('confirm_button');
            const confirmForm = document.getElementById('confirm-form');
            const deliveryTimePeriod = document.getElementById('delivery_time_period');
            const hiddenDeliveryOption = document.getElementById('hidden_delivery_option');
            const hiddenFinalTotal = document.getElementById('hidden_final_total');

            const deliveryHours = {
                weekdays: "10:00 - 20:00",
                saturday: "08:00 - 18:00",
                sunday: "09:00 - 14:30"
            };

            const isValidPickupTime = (date) => {
                const day = date.getDay();
                const hour = date.getHours();

                if (day >= 1 && day <= 5) { // Lunes a Viernes
                    return hour >= 10 && hour < 20;
                } else if (day === 6) { // Sábado
                    return hour >= 8 && hour < 18;
                } else if (day === 0) { // Domingo
                    return hour >= 9 && hour < 14.5;
                }
                return false;
            };

            const getDeliveryPeriod = (day) => {
                if (day >= 1 && day <= 5) { // Lunes a Viernes
                    return deliveryHours.weekdays;
                } else if (day === 6) { // Sábado
                    return deliveryHours.saturday;
                } else if (day === 0) { // Domingo
                    return deliveryHours.sunday;
                }
                return "";
            };

            const checkValidity = () => {
                if (deliveryMethodSelect.value === 'pickup') {
                    if (pickupDateInput.value && isValidPickupTime(new Date(pickupDateInput.value))) {
                        confirmButton.disabled = false;
                    } else {
                        confirmButton.disabled = true;
                    }
                } else if (deliveryMethodSelect.value === 'delivery') {
                    confirmButton.disabled = false;
                } else {
                    confirmButton.disabled = true;
                }
            };

            const updateDeliveryTimePeriod = () => {
                const today = new Date();
                const period = getDeliveryPeriod(today.getDay());
                deliveryTimePeriod.textContent = `Periodo de entrega: ${period}`;
            };

            pickupDateInput.addEventListener('input', (event) => {
                const inputDate = new Date(event.target.value);
                if (!isValidPickupTime(inputDate)) {
                    alert('Por favor selecciona un horario válido para la recogida.');
                    event.target.value = '';
                }
                checkValidity();
            });

            deliveryMethodSelect.addEventListener('change', function (event) {
                const selectedOption = event.target.value;
                if (selectedOption === 'delivery') {
                    deliveryMessageDiv.style.display = 'block';
                    pickupMessageDiv.style.display = 'none';
                    pickupDateInput.required = false;
                    updateDeliveryTimePeriod();

                    // Asignar el valor del total final al campo oculto
                    hiddenFinalTotal.value = "{{ $finalTotal }}";
                } else if (selectedOption === 'pickup') {
                    deliveryMessageDiv.style.display = 'none';
                    pickupMessageDiv.style.display = 'block';
                    pickupDateInput.required = true;

                    // Sin costo de envío para recogida, solo el total
                    hiddenFinalTotal.value = "{{ $total }}";
                } else {
                    deliveryMessageDiv.style.display = 'none';
                    pickupMessageDiv.style.display = 'none';
                }
                checkValidity();
            });

            confirmForm.addEventListener('submit', function () {
                if (deliveryMethodSelect.value === 'delivery') {
                    hiddenDeliveryOption.value = 'delivery';
                } else if (deliveryMethodSelect.value === 'pickup') {
                    hiddenDeliveryOption.value = 'pickup';
                    document.getElementById('hidden_pickup_date').value = pickupDateInput.value;
                }
            });

            updateDeliveryTimePeriod(); // Initialize the delivery time period on page load
        });
</script>

</body>

</html>
