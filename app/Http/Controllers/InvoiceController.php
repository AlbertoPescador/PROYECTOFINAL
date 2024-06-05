<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

use App\Models\Line;
use App\Models\Invoice; 
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use PDF;

class InvoiceController extends Controller
{
    /**
     * La función `myInvoices` recupera las facturas que pertenecen al usuario autenticado y las pasa a
     * la vista 'profile.invoices'.
     * 
     * @return La función `myInvoices` devuelve una vista llamada 'profile.invoices' con los datos de
     * las facturas pasados como una variable usando la función `compact`.
     */
    public function myInvoices()
    {
        $user = auth()->user();
        $invoices = Invoice::where('user_id', $user->id)->get();
        return view('user.invoice.invoices', compact('invoices')); 
    }

    /**
     * La función "mostrar" recupera y muestra una factura específica utilizando su ID.
     * 
     * @param id El parámetro "id" en la función "mostrar" representa el identificador único de la
     * factura que desea mostrar. Este parámetro se utiliza para recuperar la factura específica de la
     * base de datos utilizando el método `findOrFail` de Eloquent.
     * 
     * @return La función `show` devuelve una vista llamada 'profile.showinvoice' con los datos de
     * `invoice` pasados utilizando el método `compact`.
     */
    public function show($id)
    {
        $invoice = Invoice::findOrFail($id);
        return view('user.invoice.showinvoice', compact('invoice'));
    }

/**
 * La función `getOrders` recupera todos los usuarios y los pasa a la vista para mostrar pedidos en un
 * panel de administración.
 * 
 * @return La función `gestOrders` devuelve una vista llamada "admin.orders.index" con los datos de los
 * usuarios pasados como una variable compacta.
 */
    public function gestOrders(){
        $users = User::all();
        return view("admin.orders.index", compact('users'));
    }
    
/**
 * La función `searchUsers` busca usuarios basándose en una consulta por correo electrónico y devuelve
 * la vista renderizada con los resultados de la búsqueda.
 * 
 * @param Request request El parámetro `Request ` en la función `searchUsers` es una instancia
 * de la clase `Illuminate\Http\Request` en Laravel. Representa una solicitud HTTP y le permite acceder
 * a datos de entrada, parámetros de consulta y más desde la solicitud.
 * 
 * @return La función `searchUsers` devuelve una vista llamada 'busqueda' ubicada en el directorio
 * 'admin/orders', con los datos de los usuarios pasados como una variable a la vista.
 */
    public function searchUsers(Request $request)
    {
        $query = $request->get('search');
        $users = User::where('email', 'LIKE', "%{$query}%")->get();
    
        $view = view('admin.orders.busqueda', compact('users'))->render();
    
        return $view; 
    }
       
/**
 * La función `showUserInvoices` recupera la información de un usuario y sus facturas para mostrarlas
 * en una vista.
 * 
 * @param id El parámetro `id` en la función `showUserInvoices` se utiliza para recuperar la
 * información de un usuario específico y sus facturas. Normalmente es el identificador único del
 * usuario para quien desea mostrar las facturas.
 * 
 * @return Se devuelve una vista denominada 'userinvoices' del directorio 'admin.orders', con las
 * variables  y  pasadas a la vista usando la función compacta.
 */
    public function showUserInvoices($id)
    {
        $user = User::findOrFail($id);
        $invoices = Invoice::where('user_id', $id)->get();
        return view('admin.orders.userinvoices', compact('user', 'invoices'));
    }    

    public function destroy($id, $invoice_id)
    {
        $invoice = Invoice::findOrFail($invoice_id);
        $invoice->delete();
        $user = User::findOrFail($id);
        $invoices = Invoice::where('user_id', $id)->get();
        return view('admin.orders.userinvoices', compact('user', 'invoices'));
    }

    /**
     * La función `searchOrder` recupera facturas de un usuario específico en función de una fecha de
     * búsqueda determinada y devuelve una vista de tabla parcial para solicitudes AJAX o una vista
     * completa con los resultados.
     * 
     * @param Request request El parámetro `` en la función `searchOrder` es una instancia de
     * la clase `Illuminate\Http\Request` en Laravel. Representa la solicitud HTTP que se realiza al
     * servidor y contiene información como entrada de formulario, encabezados, cookies y más.
     * @param id El parámetro `` en la función `searchOrder` representa el ID de usuario que se pasa
     * a la función. Esta ID se utiliza para recuperar al usuario de la base de datos usando
     * `User::findOrFail()`. Luego, la función busca facturas relacionadas con este usuario en
     * función de una fecha específica proporcionada.
     * 
     * @return Si la solicitud es una solicitud AJAX, la función devolverá una respuesta JSON que
     * contiene la vista renderizada en HTML de 'admin.orders.busquedaorder' con las facturas y los
     * datos del usuario. Si la solicitud no es una solicitud AJAX, la función devolverá la vista
     * completa de 'admin.orders.userinvoices' con las facturas y los datos del usuario.
     */
    public function searchOrder(Request $request, $id)
    {
        // Obtener el usuario
        $user = User::findOrFail($id);
    
        // Obtener la fecha de búsqueda del formulario
        $searchDate = $request->input('start_date');
    
        // Convertir la fecha a un formato compatible con la base de datos (YYYY-MM-DD)
        $formattedDate = Carbon::parse($searchDate)->format('Y-m-d');
    
        // Filtrar las facturas del usuario según la fecha exacta
        $invoices = $user->invoices()->whereDate('created_at', $formattedDate)->get();
    
        // Verificar si la solicitud es AJAX y devolver solo la sección de la tabla
        if ($request->ajax()) {
            $view = view('admin.orders.busquedaorder', compact('invoices', 'user'))->render();
            return response()->json(['html' => $view]);
        }
    
        // Si no es una solicitud AJAX, cargar la vista completa con los resultados
        return view('admin.orders.userinvoices', compact('invoices', 'user'));
    }    

    public function search(Request $request)
    {
        // Obtiene la fecha de búsqueda del formulario
        $searchDate = $request->input('start_date');
        
        // Convierte la fecha a un formato compatible con la base de datos (YYYY-MM-DD)
        $formattedDate = Carbon::parse($searchDate)->format('Y-m-d');
    
        // Obtiene los pedidos del usuario actual según la fecha de búsqueda
        $invoices = Invoice::where('user_id', auth()->user()->id)
                        ->whereDate('created_at', $formattedDate)
                        ->get();
    
        // Retorna la vista parcial con los resultados de la búsqueda
        if ($request->ajax()) {
            return view('user.invoice.busqueda', compact('invoices'));
        }
    
        // Si no es una solicitud AJAX, retorna la vista completa con los resultados
        return view('user.invoice.invoices', compact('invoices'));
    }    

    public function downloadPdf(Invoice $invoice)
    {
        // Obtener los datos necesarios del modelo $invoice
        $deliveryOption = $invoice->delivery_option;
        $pickupDate = $invoice->pickup_date;
        $address = $invoice->address;
        $finalTotal = $invoice->final_total;

        // Preparar los datos de los productos
        $productsData = $invoice->lines->map(function($line) {
            return [
                'name' => $line->product->name,
                'stock' => $line->stock,
                'priceKG' => $line->product->priceKGFinal,
                'totalPriceProduct' => $line->totalPriceProduct,
            ];
        });

        // Obtener los datos del usuario actual
        $user = auth()->user();

        // Generar el PDF de la factura
        $pdf = PDF::loadView('user.invoice.pdf', [
            'invoice' => $invoice,
            'deliveryOption' => $deliveryOption,
            'pickupDate' => $pickupDate,
            'address' => $address,
            'finalTotal' => $finalTotal,
            'user' => $user,
            'productsData' => $productsData,
        ]);

        // Descargar el PDF
        return $pdf->download('factura.pdf');
    }
}
