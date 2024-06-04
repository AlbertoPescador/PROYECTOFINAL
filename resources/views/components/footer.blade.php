<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Footer Example</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <style>
    body, html {
      margin: 0;
      padding: 0;
      height: 100%;
    }
    .content-wrapper {
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }
    .content {
      flex: 1;
      margin-bottom: 20px; /* Ajusta el margen inferior según sea necesario */
    }
    footer {
      background-color: #989898;
      margin-top: auto; /* Establece el margen superior automático para el footer */
      padding-top: 20px; /* Ajusta el espacio en blanco dentro del footer */
    }
    .footer-top {
      background-color: #c3c3c3;
    }
    .footer-bottom {
      background-color: black;
    }
    .black-line {
      border-color: black;
    }
  </style>
</head>
<body>
  <div class="content-wrapper">
    <div class="content">
      <!-- Aquí va el contenido principal de tu página -->
    </div>
    <footer class="text-white text-center text-lg-start">
      <div class="footer-top text-center p-3">
        <img src="{{asset('assets/flecha.png')}}" style="width: 40px; height: auto; display: block; margin: 0 auto;">
      </div>
      <hr class="black-line">
      <div class="container p-4">
        <div class="row mt-4">
          <div class="col-lg-4 col-md-12 mb-4 mb-md-0">
            <h5 class="text-uppercase mb-4">Sobre nosotros</h5>
            <p>Tu carniceria de confianza al mejor precio.</p>
            <p>¿A qué esperas? ¡Compra ya!</p>
            <div class="mt-4">
              <a href="https://www.facebook.com/profile.php?id=61559750253153" type="button" class="btn btn-floating btn-warning btn-lg">
                <img src="{{asset('assets/facebook.png')}}" style="width: 50px; height: auto;">
              </a>
              <a href="https://www.instagram.com/tucarniceria" type="button" class="btn btn-floating btn-warning btn-lg">
                <img src="{{asset('assets/instagram.png')}}" style="width: 50px; height: auto;">
              </a>
              <a href="https://x.com/lacalidad_" type="button" class="btn btn-floating btn-warning btn-lg">
                <img src="{{asset('assets/twitter.png')}}" style="width: 50px; height: auto;">
              </a>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 mb-4 mb-md-0">
            <h5 class="text-uppercase mb-4">LOCALIZACIÓN Y MÁS</h5>
            <ul class="fa-ul" style="margin-left: 1.65em;">
              <li class="mb-3">
                <span class="fa-li"><i class="fas fa-home"></i></span><span class="ms-2">Luque, 28 de Febrero, 28, ES</span>
              </li>
              <li class="mb-3">
                <span class="fa-li"><i class="fas fa-envelope"></i></span><span class="ms-2">proyectocarniceriacalidad@gmail.com</span>
              </li>
              <li class="mb-3">
                <span class="fa-li"><i class="fas fa-phone"></i></span><span class="ms-2">+34 621 06 48 73</span>
              </li>
              <li class="mb-3">
                <span class="fa-li"><i class="fas fa-print"></i></span><span class="ms-2">+34 957 67 09 24</span>
              </li>
            </ul>
          </div>
          <div class="col-lg-4 col-md-6 mb-4 mb-md-0">
            <h5 class="text-uppercase mb-4">HORARIO DE APERTURA</h5>
            <table class="table text-center text-white">
              <tbody class="font-weight-normal">
                <tr>
                  <td>Lunes - Viernes</td>
                  <td>10:00 - 20:00</td>
                </tr>
                <tr>
                  <td>Sábado</td>
                  <td>08:00 - 18:00</td>
                </tr>
                <tr>
                  <td>Domingo</td>
                  <td>9:00 - 14:30</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="footer-bottom text-center p-3">
        <h4>Verificado por W3C</h4>
        <a href="http://validator.w3.org/check/referer">
            <img style="border:0;width:88px;height:31px"
                src="https://www.w3.org/Icons/valid-html401-v.svg"
                alt="¡HTML Válido!" />
        </a>
        <a href="http://jigsaw.w3.org/css-validator/check/referer">
            <img style="border:0;width:88px;height:31px"
                src="http://jigsaw.w3.org/css-validator/images/vcss-blue"
                alt="¡CSS Válido!" />
        </a>
        © 2024 Copyright: <a class="text-white" href="https://baena.es">Baena</a>
      </div>
    </footer>
  </div>
</body>
</html>