<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenida</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.css"/>
    <link rel="stylesheet" href="{{asset('assets/css/index.css')}}">
</head>
<body>
    
    <div class="relative min-h-screen bg-gray-100 dark:bg-gray-900">
        <!-- Contenido adicional (Mensaje de bienvenida y redes sociales) -->
        <div class="additional-content">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-md-6 col-lg-5">
                    <!-- Mensaje de bienvenida y redes sociales -->  
                    <div class="card p-3" style="border-radius: 1rem;">
                        <h1 class="text-4xl font-bold mb-3 pb-3">¡Bienvenido!</h1>
                        <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Síguenos en redes sociales</h5>
                        <div class="d-flex justify-content-between">
                            <!-- Imagen 1: Facebook -->
                            <a href="https://www.facebook.com/profile.php?id=61559750253153" target="_blank">
                                <img src="{{asset('assets/facebook.png')}}" alt="Facebook" style="width: 50px; height: auto;">
                            </a>
                            <!-- Imagen 2: Instagram -->
                            <a href="https://www.instagram.com/tucarniceria" target="_blank">
                                <img src="{{asset('assets/instagram.png')}}" alt="Instagram" style="width: 50px; height: auto;">
                            </a>
                            <!-- Imagen 3: Twitter -->
                            <a href="https://x.com/lacalidad_" target="_blank">
                                <img src="{{asset('assets/twitter.png')}}" alt="Twitter" style="width: 50px; height: auto;">
                            </a>
                        </div>
                    </div>  
                </div>
            </div>
        </div>
        
        <!-- Contenedor del slider -->
        <div class="absolute top-0 right-0 bottom-0 left-1/3 flex justify-center items-center">
            <div class="w-full sm:w-3/4">
                <div class="slick-carousel">
                    <div><img src="{{ asset('assets/imagen1.jpg') }}" alt="Slide 1"></div>
                    <div><img src="{{ asset('assets/imagen2.jpg') }}" alt="Slide 2"></div>
                    <div><img src="{{ asset('assets/imagen3.jpg') }}" alt="Slide 3"></div>
                </div>
            </div>
        </div>
        
        <!-- Links de autenticación -->
        <div class="auth-links">
            @if (Route::has('login'))
                <div class="fixed top-0 right-0 p-6 text-right z-10">
                    @auth
                        <a href="{{ route('products.list') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Iniciar Sesión</a>
        
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Crear Cuenta</a>
                        @endif
                    @endauth
                </div>
            @endif
        </div>
    </div>

    <!-- Scripts de Slick Carousel -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
    <script>
        $(document).ready(function(){
            $('.slick-carousel').slick({
                autoplay: true,
                autoplaySpeed: 2000, // Cambiar velocidad del autoplay si es necesario
                dots: true,
                arrows: false, // No mostramos las flechas de navegación
                infinite: true,
                speed: 500,
                slidesToShow: 1,
                slidesToScroll: 1
            });
        });
    </script>
</body>
</html>
