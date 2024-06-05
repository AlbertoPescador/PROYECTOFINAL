<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Log;

use App\Models\Invoice;
use App\Models\Product;
use App\Models\User;
use App\Models\Line;
use PDF;

class CartController extends Controller
{
    /**
     * La función `cartList` recupera el contenido del carrito y lo pasa a la vista 'carrito'.
     * 
     * @return La función `cartList` devuelve una vista llamada 'cart' con los datos de la variable
     * `` que se le pasan usando la función `compact`.
     */
// Controlador
    public function cartList()
    {
        $cartItems = \Cart::getContent();
        $isCartEmpty = $cartItems->isEmpty();
        return view('user.cart', compact('cartItems', 'isCartEmpty'));
    }

     /**
      * La función "addToCart" en PHP valida los datos de entrada, verifica la disponibilidad de stock
      * y actualiza la cantidad de un artículo existente en el carrito o agrega un nuevo producto al
      * carrito.
      * 
      * @param Request request La función `addToCart` que proporcionó es una función PHP que maneja la
      * adición de productos a un carrito de compras. Toma un objeto "Solicitud" como parámetro, que
      * probablemente contiene los datos del producto que se agrega al carrito.
      * 
      * @return La función `addToCart` devuelve una respuesta JSON con un mensaje que indica si el
      * producto se agregó correctamente al carrito o si no había suficiente stock disponible. El
      * mensaje de respuesta será "Producto agregado al carrito correctamente!" (Producto agregado al
      * carrito exitosamente) o "No hay suficiente stock disponible" (No hay suficiente stock
      * disponible). Si ocurre un error inesperado durante el proceso, el
      */
     public function addToCart(Request $request)
     {
         // Validar los datos de entrada
         $validatedData = $request->validate([
             'id' => 'required|integer|exists:products,id',
             'nombre' => 'required|string|max:40',
             'priceKG' => 'required|numeric|min:0',
             'urlImagen' => 'required|string',
             'quantity' => 'required|integer|min:1',
             'tipoBandeja' => 'required|numeric|min:0.5',
             'tipoCorte' => 'nullable|string|max:50',
         ]);
     
         try {
             // Obtener el producto desde la base de datos
             $product = Product::findOrFail($request->id);
             $stockDisponible = $product->stock;
     
             // Buscar el artículo en el carrito con el mismo id, tipoBandeja y tipoCorte
             $existingItem = \Cart::getContent()->first(function ($item) use ($request) {
                 return $item->attributes->idProducto == $request->id &&
                        $item->attributes->tipoBandeja == $request->tipoBandeja &&
                        $item->attributes->tipoCorte == $request->tipoCorte;
             });
     
             // Calcular la cantidad total en el carrito para este producto en base al tipo de bandeja
             $cantidadEnCarrito = $existingItem ? $existingItem->quantity * (float)$request->tipoBandeja : 0;
     
             // Calcular la cantidad total requerida para este producto y tipo de bandeja
             $cantidadRequerida = $cantidadEnCarrito + ($request->quantity * (float)$request->tipoBandeja);
     
             // Verificar si hay suficiente stock disponible
             if ($cantidadRequerida > $stockDisponible) {
                 return response()->json(['message' => 'No hay suficiente stock disponible', 'cantidadRequerida' => $cantidadRequerida, 'stockDisponible' => $stockDisponible], 400);
             }
     
             // Si existe, actualizar la cantidad
             if ($existingItem) {
                 \Cart::update($existingItem->id, [
                     'quantity' => [
                         'relative' => false,
                         'value' => $existingItem->quantity + $request->quantity
                     ]
                 ]);
                 $message = 'Cantidad actualizada en el carrito correctamente!';
             } else {
                 // Añadir el producto al carrito
                 \Cart::add(
                     uniqid(),
                     $request->nombre,
                     $request->priceKG,
                     $request->quantity,
                     [
                         'idProducto' => $request->id,
                         'tipoBandeja' => $request->tipoBandeja,
                         'tipoCorte' => $request->tipoCorte,
                         'image' => $request->urlImagen,
                     ]
                 );
                 $message = 'Producto agregado al carrito correctamente!';
             }
     
             return response()->json(['message' => $message]);
     
         } catch (\Exception $e) {
             // Manejo de errores
             return response()->json(['message' => 'Ha ocurrido un error inesperado.'], 500);
         }
    }
      
    /**
     * La función `updateCart` actualiza la cantidad de un producto en el carrito y redirige a la
     * página de lista del carrito con un mensaje de éxito.
     * 
     * @param Request request La función `updateCart` se utiliza para actualizar la cantidad de un
     * producto en el carrito de compras. Toma un objeto `Solicitud` como parámetro, que contiene los
     * datos enviados por el cliente en la solicitud HTTP.
     * 
     * @return La función `updateCart` devuelve una respuesta de redireccionamiento a la ruta
     * denominada 'cart.list'.
     */
    public function updateCart(Request $request)
    {
        // Validar los datos de entrada
        $validatedData = $request->validate([
            'id' => 'required|string',
            'quantity' => 'required|integer|min:1',
            'original_quantity' => 'required|integer|min:1',
        ]);
    
        // Obtener el ítem del carrito
        $item = \Cart::get($request->id);
    
        // Verificar si el ítem existe en el carrito
        if (!$item) {
            session()->flash('error', 'El producto no se encuentra en el carrito.');
            return redirect()->route('cart.list');
        }
    
        // Obtener el producto desde la base de datos para verificar el stock
        $product = Product::findOrFail($item->attributes->idProducto);
    
        // Calcular la cantidad total en el carrito para este producto
        $cantidadEnCarrito = ($request->quantity - $item->quantity) * $item->attributes->tipoBandeja;
    
        // Verificar si la cantidad solicitada no excede el stock disponible
        if ($cantidadEnCarrito > $product->stock) {
            session()->flash('error', 'No hay suficiente stock disponible.');
            return redirect()->route('cart.list');
        }
    
        // Actualizar la cantidad en el carrito
        \Cart::update(
            $request->id,
            [
                'quantity' => [
                    'relative' => false,
                    'value' => $request->quantity
                ],
            ]
        );
    
        session()->flash('success', 'Producto modificado correctamente !');
        return redirect()->route('cart.list');
    }
    

    /**
     * La función elimina un producto del carrito y lo redirige a la página de la lista del carrito
     * mientras muestra un mensaje de éxito.
     * 
     * @param Request request El parámetro `` en la función `removeCart` es una instancia de la
     * clase `Illuminate\Http\Request`. Representa la solicitud HTTP que se realiza al servidor. En
     * este contexto, se utiliza para recuperar el parámetro "id" de la solicitud para eliminar un
     * parámetro específico.
     * 
     * @return La función `removeCart` devuelve una respuesta de redireccionamiento a la ruta
     * denominada `cart.list`.
     */
    public function removeCart(Request $request)
    {
        \Cart::remove($request->id);
        session()->flash('success', 'Producto eliminado correctamente !');
        return redirect()->route('cart.list');
    }

    /**
     * La función borra todos los artículos del carrito de compras y muestra un mensaje de éxito antes
     * de redirigir a la página de lista del carrito.
     * 
     * @return La función `clearAllCart()` devuelve una respuesta de redireccionamiento a la ruta
     * denominada 'cart.list'.
     */
    public function clearAllCart()
    {
        \Cart::clear();
        session()->flash('success', 'Todos los productos fueron eliminados !');
        return redirect()->route('cart.list');
    }

    /**
     * La función `cartConfirm` en PHP procesa los artículos en un carrito de compras, calcula las
     * cantidades totales considerando los tipos de bandeja, verifica la disponibilidad de existencias
     * del producto y devuelve una respuesta JSON con el estado de éxito o un mensaje de error.
     * 
     * @param Request request La función `cartConfirm` que proporcionó es una función PHP que maneja la
     * confirmación de artículos en un carrito de compras. Realiza los siguientes pasos:
     * 
     * @return La función `cartConfirm` devuelve una respuesta JSON. Si la verificación de existencias
     * de todos los productos en el carrito se realiza correctamente, devuelve una respuesta JSON con
     * "success" establecido en "true" y una clave "redirect_url" que apunta a la ruta denominada
     * "cart.confirmcart". Si hay un problema con la disponibilidad de existencias para cualquier
     * producto, devuelve una respuesta JSON con "éxito" establecido en
     */
    public function cartConfirm(Request $request)
    {
        try {
            // Obtener los elementos del carrito
            $cartItems = \Cart::getContent();

            // Inicializar un array para el seguimiento de las cantidades totales de cada producto
            $productQuantities = [];

            // Calcular la cantidad total de cada producto en el carrito
            foreach ($cartItems as $item) {
                $productId = $item->attributes['idProducto'];
                $tipoBandeja = $item->attributes['tipoBandeja'];
                $quantity = $item->quantity;

                if (!isset($productQuantities[$productId])) {
                    $productQuantities[$productId] = 0;
                }

                // Sumar la cantidad total del producto considerando el tipo de bandeja
                $productQuantities[$productId] += $quantity * $tipoBandeja;
            }

            // Verificar el stock disponible para cada producto
            foreach ($productQuantities as $productId => $totalQuantity) {
                $product = Product::findOrFail($productId);

                if ($totalQuantity > $product->stock) {
                    // Si la cantidad total excede el stock disponible, mostrar un mensaje de error
                    $errorMessage = 'La cantidad total del producto "' . $product->name . '" excede el stock disponible. ' . $product->stock . 'kg';
                    return response()->json(['success' => false, 'message' => $errorMessage]);
                }
            }

            // Si todo está bien, devolver una respuesta JSON exitosa
            return response()->json(['success' => true, 'redirect_url' => route('cart.confirmcart')]);
        } catch (\Exception $e) {
            // Registra cualquier excepción que ocurra
            \Log::error('Error en cartConfirm: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Se produjo un error al procesar la solicitud.']);
        }
    }

/**
 * La función confirmCart devuelve una vista para confirmar la factura del usuario.
 * 
 * @return Se devuelve una vista denominada 'confirmación de factura' ubicada en el directorio
 * 'usuario/factura'.
 */
    public function confirmCart(){
        return view('user.invoice.invoiceconfirm');
    }

/**
 * La función `cartSelect` devuelve una vista para seleccionar una factura en una aplicación PHP.
 * 
 * @return Se devuelve una vista denominada 'usuario.invoice.select'.
 */
    public function cartSelect(){
        $cartItems = \Cart::getContent();
        return view('user.invoice.select', compact('cartItems'));
    }

    public function confirmOrder(Request $request)
    {
        $request->validate([
            'delivery_option' => 'required|string',
            'pickup_date' => 'required_if:delivery_option,pickup|nullable|date_format:Y-m-d\TH:i',
        ]);

        // Obtener los productos del carrito
        $cartItems = \Cart::getContent();

        // Array para almacenar los IDs de los productos
        $productIds = [];
        try {
            // Restar el stock de los productos
            foreach ($cartItems as $item) {

                $product = Product::find($item->id);
                if ($product) {
                    $product->stock -= $item->quantity;
                    if ($product->stock < 0) {
                        throw new \Exception('No hay suficiente stock para el producto: ' . $product->name);
                    }
                    $product->save();
                }
                   // Guardar el ID del producto en el array
                $productIds[] = $item->attributes->idProducto;
            }

            // Obtener los ítems del carrito
            $cartItems = \Cart::getContent();
        
            // Verificar si el carrito está vacío
            if ($cartItems->isEmpty()) {
                return redirect()->back()->with('error', 'El carrito está vacío.');
            }
        
            // Crear una nueva factura en la tabla 'invoices'
            $invoice = new Invoice();
            $invoice->total_invoice = 0; // Inicializar el total de la factura en 0
            $invoice->user_id = Auth::id(); // Ajustar según sea necesario
            $invoice->save();
        
            // Calcular el total de la factura y crear las líneas de factura
            foreach ($cartItems as $item) {
                // Obtener datos del producto del carrito
                $productId = $item->attributes->idProducto;
        
                // Convertir tipoBandeja a float
                $tipoBandeja = (float) $item->attributes->tipoBandeja;
        
                // Calcular el total de la línea de factura
                $stockBuy = $item->quantity * $tipoBandeja;
                $totalPriceProduct = $item->price * $stockBuy;
        
                // Crear una nueva línea de factura
                $line = new Line();
                $line->stock = $stockBuy;
                $line->totalPriceProduct = $totalPriceProduct; // Precio total de la línea
                $line->product_id = $productId; // ID del producto
                $line->invoice_id = $invoice->id; // Asociar la línea con la factura creada
                $line->save();
        
                // Actualizar el stock del producto
                $productoEncontrado = Product::find($productId);
                $productoEncontrado->stock = $productoEncontrado->stock - $stockBuy;
                $productoEncontrado->save();
            }
        
            // Asignar el total de la factura
            $invoice->total_invoice = $request->final_total;
            $invoice->save();
        
            // Cargar relaciones
            $invoice->load('lines.product');
        
            // Vaciar el carrito
            \Cart::clear();
        
            // Redirigir a la página de confirmación final con los datos necesarios para generar el PDF
            return redirect()->route('order.finalConfirm', [
                'invoice_id' => $invoice->id,
                'delivery_option' => $request->delivery_option,
                'pickup_date' => $request->pickup_date,
                'address' => auth()->user()->address,
                'product_ids' => $productIds // Pasar los IDs de los productos
            ]);

        } catch (\Exception $e) {

            // Redirigir de nuevo con un mensaje de error
            return redirect()->back()->with('error', 'Ha ocurrido un error: ' . $e->getMessage());
        }
    }

    /*
    public function generateInvoices(Request $request) {
        // Obtener los ítems del carrito
        $cartItems = \Cart::getContent();
    
        // Verificar si el carrito está vacío
        if ($cartItems->isEmpty()) {
            return redirect()->back()->with('error', 'El carrito está vacío.');
        }
    
        // Crear una nueva factura en la tabla 'invoices'
        $invoice = new Invoice();
        $invoice->total_invoice = 0; // Inicializar el total de la factura en 0
        $invoice->user_id = Auth::id(); // Ajustar según sea necesario
        $invoice->save();
    
        // Calcular el total de la factura y crear las líneas de factura
        foreach ($cartItems as $item) {
            // Obtener datos del producto del carrito
            $productId = $item->attributes->idProducto;
    
            // Convertir tipoBandeja a float
            $tipoBandeja = (float) $item->attributes->tipoBandeja;
    
            // Calcular el total de la línea de factura
            $stockBuy = $item->quantity * $tipoBandeja;
            $totalPriceProduct = $item->price * $stockBuy;
    
            // Crear una nueva línea de factura
            $line = new Line();
            $line->stock = $stockBuy;
            $line->totalPriceProduct = $totalPriceProduct; // Precio total de la línea
            $line->product_id = $productId; // ID del producto
            $line->invoice_id = $invoice->id; // Asociar la línea con la factura creada
            $line->save();
    
            // Actualizar el stock del producto
            $productoEncontrado = Product::find($productId);
            $productoEncontrado->stock = $productoEncontrado->stock - $stockBuy;
            $productoEncontrado->save();
        }
    
        // Asignar el total de la factura
        $invoice->total_invoice = $request->final_total;
        $invoice->save();
    
        // Cargar relaciones
        $invoice->load('lines.product');
    
        // Vaciar el carrito
        \Cart::clear();
    
        // Redirigir a la página de confirmación final con los datos necesarios para generar el PDF
        return redirect()->route('order.finalConfirm', [
            'invoice_id' => $invoice->id,
            'delivery_option' => $request->delivery_option,
            'pickup_date' => $request->pickup_date,
            'address' => auth()->user()->address,
        ]);
    }*/
           
    
    public function finalConfirm(){ 
        $invoices = Invoice::all();
        return view('user.invoice.finalcart', compact('invoices'));
    }

    public function downloadInvoice(Request $request) {
        // Obtener los datos necesarios de la solicitud
        $invoiceId = $request->query('invoice_id');
        $deliveryOption = $request->query('delivery_option');
        $pickupDate = $request->query('pickup_date');
        $address = $request->query('address');
        $finalTotal = $request->query('final_total'); // Agregado para incluir el total final
        
        // Preparar los datos de los productos
        $invoice = Invoice::with('lines.product')->findOrFail($invoiceId);
        $productsData = $invoice->lines->map(function($line) {
            return [
                'name' => $line->product->name,
                'stock' => $line->stock,
                'priceKG' => $line->product->priceKGFinal,
                'totalPriceProduct' => $line->totalPriceProduct,
                
            ];
        });


        // Obtener la factura por ID
        $invoice = Invoice::with('lines.product')->findOrFail($invoiceId);
        
        // Obtener los datos del usuario actual
        $user = Auth::user();
       
        // Generar el PDF de la factura
        $pdf = \PDF::loadView('user.invoice.pdf', [
            'invoice' => $invoice, 
            'deliveryOption' => $deliveryOption,
            'pickupDate' => $pickupDate,
            'address' => $address,
            'finalTotal' => $finalTotal, // Pasando el total final al PDF
            'user' => $user, // Pasando los datos del usuario
            'productsData' => $productsData,
        ]);

        
        // Descargar el PDF
        return $pdf->download('factura.pdf');
    }
    
    
    
    
}