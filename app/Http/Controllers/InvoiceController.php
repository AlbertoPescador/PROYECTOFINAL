<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

use App\Models\Line;
use App\Models\Invoice; 
use App\Models\Product;
use App\Models\User;
use PDF;

class InvoiceController extends Controller
{
   /**
    * La función `generarFacturas` crea facturas basadas en los artículos del carrito, calcula el monto
    * total de la factura, genera una factura en PDF y la descarga.
    * 
    * @param Request request La función "generarFacturas" que proporcionó parece ser responsable de
    * generar facturas basadas en los artículos del carrito. Analicemos el proceso:
    * 
    * @return un archivo PDF para descargar, que contiene los detalles de la factura y los datos del
    * producto generados en función de los artículos del carrito. El PDF se genera utilizando la vista
    * Blade 'user.profile.pdf' y se descarga como 'factura.pdf'. Después de descargar el PDF, la
    * función redirige a la misma página.
    */
    public function generateInvoices(Request $request) {
        // Obtener los ítems del carrito
        $cartItems = \Cart::getContent();
        
        // Verificar si el carrito está vacío
        if ($cartItems->isEmpty()) {
            return redirect()->back()->with('error', 'El carrito está vacío.');
        }
        
        // Crear una nueva factura en la tabla 'invoices'
        $invoice = new Invoice();
        $invoice->date_created = now();
        $invoice->total_invoice = 0; // Inicializar el total de la factura en 0
        $invoice->user_id = Auth::id(); // Ajustar según sea necesario
        $invoice->save();
        
        // Inicializar el total de la factura
        $totalInvoice = 0;
    
        // Inicializar array para almacenar datos de productos
        $productsData = [];
        
        // Calcular el total de la factura y crear las líneas de factura
        foreach ($cartItems as $item) {
            // Obtener el producto asociado al ítem del carrito
            $product = Product::find($item->id);    
    
            // Calcular el total de la línea
            $totalLine = $item->quantity * $item->price;
    
            // Crear una nueva línea de factura
            $line = new Line();
            $line->stock = $item->quantity; // Cantidad de productos
            $line->totalPriceProduct = $totalLine; // Precio total de la línea
            $line->product_id = $product->id; // ID del producto
            $line->invoice_id = $invoice->id; // Asociar la línea con la factura creada
            $line->save();
    
            // Agregar datos del producto al array
            $productsData[] = [
                'name' => $product->name,
                'description' => $product->description,
                'stock' => $line->stock, // Agregar stock desde la tabla Line
                'priceKG' => $product->priceKG,   
                'totalPriceProduct' => $line->totalPriceProduct, // Agregar totalPriceProduct desde la tabla Line
            ];
    
            // Actualizar el total de la factura
            $totalInvoice += $totalLine;
        }
    
        // Asignar el total de la factura
        $invoice->total_invoice = $totalInvoice;
        $invoice->save();
    
        // Vaciar el carrito
        \Cart::clear();

        // Renderizar la vista Blade para generar el PDF
        $pdf = \PDF::loadView('user.profile.pdf', ['invoice' => $invoice, 'productsData' => $productsData]);
        
        // Descargar el PDF y redirigir a la misma página
        return $pdf->download('factura.pdf');
    }

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
}
