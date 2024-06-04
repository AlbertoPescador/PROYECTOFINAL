<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMailable;

class ContactController extends Controller
{
/**
 * La función de índice devuelve la vista de la página de contacto del usuario.
 * 
 * @return Se devuelve una vista denominada 'user.contact.index'.
 */
    public function index()
    {
        return view('user.contact.index');
    }

/**
 * La función `store` envía un correo electrónico utilizando la fachada de correo de Laravel con los
 * datos de la solicitud a la dirección de correo electrónico especificada.
 * 
 * @param Request request El parámetro `Request ` en la función `store` es una instancia de la
 * clase `Illuminate\Http\Request` en Laravel. Representa la solicitud HTTP que se realiza a la
 * aplicación y contiene todos los datos enviados con la solicitud, como entradas de formularios,
 * encabezados y archivos.
 */
    public function store(Request $request)
    {
        Mail::to('proyectocarniceriacalidad@gmail.com')
            ->send(new ContactMailable($request->all()));
    }
}
