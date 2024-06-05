<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    /**
     * La función productList recupera todos los productos de la base de datos y los pasa a la vista
     * 'productos'.
     * 
     * @return La función `productList()` devuelve una vista llamada 'productos' con los datos de los
     * productos pasados como una variable usando la función `compact()`.
     */

     public function productListOrder(Request $request)
     {
         try {
             $products = Product::query(); // Comienza la consulta
     
             // Búsqueda
             if ($request->has('busqueda')) {
                 $busqueda = $request->input('busqueda');
                 $products->where('name', 'like', '%' . $busqueda . '%');
             }
     
             // Ordenamiento y filtrado
             if ($request->has('sort_and_filter')) {
                 $sortAndFilter = $request->input('sort_and_filter');
                 switch ($sortAndFilter) {
                     case 'name_asc':
                         $products->orderBy('name', 'asc');
                         break;
                     case 'name_desc':
                         $products->orderBy('name', 'desc');
                         break;
                     case 'price_asc':
                         $products->orderBy('priceKGFinal', 'asc');
                         break;
                     case 'price_desc':
                         $products->orderBy('priceKGFinal', 'desc');
                         break;
                     case 'stock_asc':
                         $products->orderBy('stock', 'asc');
                         break;
                     case 'stock_desc':
                         $products->orderBy('stock', 'desc');
                         break;
                     default:
                         $products->orderBy('id', 'asc');
                 }
             } else {
                 $products->orderBy('id', 'asc');
             }
     
             $products = $products->paginate(200); // Aplica paginación
     
             if ($request->ajax()) {
                 return response()->json([
                     'html' => view('user.product.busqueda', compact('products'))->render(),
                 ]);
             }
     
             return view('user.product.products', compact('products'));
         } catch (\Exception $e) {
             Log::error('Error en productListOrder: ' . $e->getMessage());
             return response()->json(['error' => 'Internal Server Error'], 500);
         }
     }    
     
    public function productListByCategory(Request $request, $category_id)
    {
        $category = Category::find($category_id);
    
        if ($category) {
            $products = Product::where('category_id', $category_id);
    
            // Búsqueda
            if ($request->has('busqueda')) {
                $busqueda = $request->input('busqueda');
                $products->where('name', 'like', '%' . $busqueda . '%');
            }
    
            // Ordenamiento y filtrado
            if ($request->has('sort_and_filter')) {
                $sortAndFilter = $request->input('sort_and_filter');
    
                switch ($sortAndFilter) {
                    case 'name_asc':
                        $products->orderBy('name', 'asc');
                        break;
                    case 'name_desc':
                        $products->orderBy('name', 'desc');
                        break;
                    case 'price_asc':
                        $products->orderBy('priceKGFinal', 'asc');
                        break;
                    case 'price_desc':
                        $products->orderBy('priceKGFinal', 'desc');
                        break;
                    case 'stock_asc':
                        $products->orderBy('stock', 'asc');
                        break;
                    case 'stock_desc':
                        $products->orderBy('stock', 'desc');
                        break;
                    default:
                        $products->orderBy('id', 'asc');
                }
            } else {
                $products->orderBy('id', 'asc');
            }
            
            $products = $products->paginate(200); // Aplica paginación

            if ($request->ajax()) {
                return response()->json([
                    'html' => view('user.product.category.busqueda', compact('products', 'category'))->render(),
                ]);
            }
    
            return view('user.product.category.' . $category->name, compact('products', 'category'));
        } else {
            abort(404);
        }
    }           

    /**
     * La función busca productos basándose en la entrada de una palabra clave y muestra los resultados
     * paginados con hasta 10.000 elementos por página.
     * 
     * @param Request request El parámetro `Request ` en la función `search` es una instancia
     * de la clase `Illuminate\Http\Request` en Laravel. Representa una solicitud HTTP y le permite
     * acceder a datos de entrada, archivos, cookies y más desde la solicitud.
     * 
     * @return La función `search` devuelve una vista llamada 'products' con las variables ``
     * y `` pasadas usando la función `compact`. La variable `` contiene los
     * resultados de la búsqueda basados en la consulta de búsqueda proporcionada en la entrada de
     * solicitud 'busqueda'. La búsqueda se realiza en las columnas 'id' y 'descripción' del modelo de
     * Producto mediante el comando 'ME GUSTA'
     */
    public function search(Request $request)
    {
        $busqueda = $request->input('busqueda');
    
        // Filtrar productos según la búsqueda
        $products = Product::query();
    
        if (!empty($busqueda)) {
            $products->where('id', 'LIKE', '%' . $busqueda . '%')
                    ->orWhere('name', 'LIKE', '%' . $busqueda . '%');
        }
    
        $products = $products->oldest('id')->paginate(100); // Paginar los resultados (cambiar el número según tus necesidades)
    
        // Verificar si la solicitud es AJAX y devolver solo la sección de la tabla
        if ($request->ajax()) {
            // Renderizar la vista parcial para la tabla de productos
            $view = view('user.product.products', compact('products'))->render();
            return response()->json(['html' => $view]);
        }
    
        // Si no es una solicitud AJAX, cargar la vista completa con los resultados
        return view('user.product.products', compact('products', 'busqueda'));  
    }

    /**
     * La función "ventas" recupera los productos que están en oferta y los pasa a la vista
     * "productos".
     * 
     * @param Request request El parámetro `` en la función `sales` es una instancia de la
     * clase `Illuminate\Http\Request` en Laravel. Representa la solicitud HTTP que se realiza a la
     * aplicación y contiene todos los datos e información relacionados con la solicitud, como datos de
     * entrada, encabezados, cookies, etc.
     * 
     * @return La función "ventas" devuelve una vista denominada "productos" con los productos que
     * tienen el atributo "venta" establecido en verdadero. Los productos se obtienen de la base de
     * datos utilizando el modelo Producto y luego se pasan a la vista utilizando el método "compacto".
     */
    public function sales()
    {
        $categories = Category::all();
    
        $categoriesWithProducts = $categories->map(function ($category) {
            $products = Product::where('category_id', $category->id)
                                ->where('sale', 1)
                                ->paginate(4, ['*'], 'page', request()->input("page_{$category->id}", 1));
            $category->products = $products;
            return $category;
        });
    
        return view('user.product.sales', compact('categoriesWithProducts'));
    }

/**
 * La función moreInformation recupera un producto específico por su ID y lo pasa a una vista para su
 * visualización.
 * 
 * @param productId El parámetro `productId` en la función `moreInformation` se utiliza para recuperar
 * un producto específico de la base de datos. La función busca el producto con el ID dado usando el
 * método `findOrFail` y luego lo pasa a la vista llamada `user.product.product` usando el método
 * `compact`. Este
 * 
 * @return La función `moreInformation` devuelve una vista llamada 'user.product.product' con los datos
 * del producto recuperados usando el método `findOrFail` para el `` dado. Los datos del
 * producto se pasan a la vista utilizando la función "compacta".
 */
    public function moreInformation($productId){
        $product = Product::findOrFail($productId);
        return view('user.product.product', compact('product'));
    }

/**
 * La función `getProduct` recupera todos los productos de la base de datos y devuelve una vista con
 * los productos para el panel de administración.
 * 
 * @return La función `gestProduct` devuelve una vista llamada 'admin.product.index' con los datos de
 * los productos pasados como una variable compacta.
 */
    public function gestProduct(){
        $products = Product::all();
        return view('admin.product.index', compact('products'));
    }
    
/**
 * La función "crear" recupera todas las categorías y las pasa a la vista para crear un nuevo producto
 * en un panel de administración.
 * 
 * @return La función `create()` devuelve una vista llamada 'admin.product.create' y pasa la variable
 * `` a la vista usando la función `compact()`.
 */
    public function create()
    {
        $categories = Category::all();
        return view('admin.product.create', compact('categories'));
    }

    /**
     * La función almacena un nuevo producto en la base de datos junto con su archivo de imagen y luego
     * lo redirige a la página de índice del producto.
     * 
     * @param Request request La función `store` que proporcionó es responsable de almacenar un nuevo
     * producto junto con su imagen en la base de datos y mover la imagen a la carpeta `public/assets`.
     * Analicemos el código:
     * 
     * @return La función `store` devuelve una vista llamada 'admin.product.index' con la variable
     * `` pasada. Esta vista se utiliza para mostrar una lista de productos después de que se
     * haya agregado exitosamente un nuevo producto. Además, se configura un mensaje flash de éxito
     * usando `session()->flash('success', "El producto fue añadido")` para notificar al usuario que el
     * producto se agregó exitosamente.
     */
    public function store (Request $request){

        $product = Product::create($request->except('_token'));

        $imagen = $request->file('urlImagen');
        // Obtener el nombre de la imagen
        $nombreimagen = $imagen->getClientOriginalName();
        
        // Mover la imagen a la carpeta public/assets
        $imagen->move(public_path('assets'), $nombreimagen);
        
        // Construir la URL completa de la imagen
        $urlArchivo = asset('assets/' . $nombreimagen);
        
        // Guardar la URL de la imagen en la base de datos
        $product->urlImagen = $urlArchivo;

        $product->save();

        $products = Product::all();
        session()->flash('success', "El producto fue añadido");
        return view('admin.product.index',compact('products'));
    }

/**
 * Esta función PHP elimina un producto con la ID proporcionada y luego devuelve una vista que muestra
 * todos los productos.
 * 
 * @param product_id El método `destroy` en el fragmento de código se utiliza para eliminar un producto
 * de la base de datos según el `` proporcionado. El parámetro `` es el
 * identificador único del producto que debe eliminarse. Cuando se llama a este método con un
 * `` específico, encontrará
 * 
 * @return El método `destroy` consiste en eliminar un producto con el `` dado, luego
 * recuperar todos los productos y devolver una vista llamada 'admin.product.index' con los datos de
 * los productos que se le pasan.
 */
    public function destroy($product_id)
    {
        $product = Product::findOrFail($product_id);
        $product->delete();
        $products = Product::all();
        return view('admin.product.index',compact('products'));
    }

    /**
     * La función `searchAdmin` filtra productos según una consulta de búsqueda, pagina los resultados
     * y devuelve una vista parcial para solicitudes AJAX o una vista completa con los resultados de la
     * búsqueda.
     * 
     * @param Request request La función `searchAdmin` es una función PHP que maneja una solicitud de
     * búsqueda de productos en un panel de administración. Toma un objeto `Solicitud` como parámetro,
     * que contiene los datos enviados con la solicitud HTTP.
     * 
     * @return La función `searchAdmin` devuelve una respuesta JSON que contiene la vista HTML de la
     * tabla de resultados de búsqueda del producto si la solicitud es AJAX, o devuelve la vista
     * completa con los resultados de la búsqueda si no es una solicitud AJAX.
     */
    public function searchAdmin(Request $request)
    {
        $busqueda = $request->input('busqueda');
    
        // Filtrar productos según la búsqueda
        $products = Product::query();
    
        if (!empty($busqueda)) {
            $products->where('id', 'LIKE', '%' . $busqueda . '%')
                    ->orWhere('name', 'LIKE', '%' . $busqueda . '%');
        }
    
        $products = $products->oldest('id')->paginate(100); // Paginar los resultados (cambiar el número según tus necesidades)
    
        // Verificar si la solicitud es AJAX y devolver solo la sección de la tabla
        if ($request->ajax()) {
            // Renderizar la vista parcial para la tabla de productos
            $view = view('admin.product.busqueda', compact('products'))->render();
            return response()->json(['html' => $view]);
        }
    
        // Si no es una solicitud AJAX, cargar la vista completa con los resultados
        return view('admin.product.index', compact('products', 'busqueda'));
    }    

/**
 * La función "editar" recupera un producto específico y todas las categorías para fines de edición en
 * una aplicación PHP Laravel.
 * 
 * @param product_id La función "editar" en el fragmento de código se utiliza para recuperar un
 * producto específico según el "" proporcionado y luego cargar las categorías
 * correspondientes que se mostrarán en la vista de edición.
 * 
 * @return El método "editar" devuelve una vista llamada "admin.product.edit" junto con los datos del
 * producto y todas las categorías.
 */
    public function edit($product_id)
    {
        $product = Product::find($product_id);
        $categories = Category::all();
        return view('admin.product.edit', [
            'product' => $product,
            'categories' => $categories
        ]);
    }

    /**
     * La función actualiza la información de un producto, incluido el nombre, la descripción, el
     * precio, el estado de venta, el stock y la imagen, según los datos de solicitud proporcionados.
     * 
     * @param Request request La función "actualizar" que proporcionó es un método que normalmente se
     * encuentra en un controlador en una aplicación Laravel. Esta función se encarga de actualizar un
     * producto en base a los datos proporcionados en la solicitud.
     * @param id El parámetro "id" en la función "actualizar" representa el identificador único del
     * producto que desea actualizar. Normalmente se utiliza para recuperar el producto existente de la
     * base de datos en función de este ID y luego actualizar su información en consecuencia. Esta
     * identificación es crucial para apuntar al producto específico que debe ser
     * 
     * @return una respuesta de redirección a la lista de productos en el panel de administración. Está
     * utilizando el método `redirect()->route('admin.product.index')` de Laravel para redirigir al
     * usuario a la ruta denominada 'admin.product.index', que presumiblemente muestra la lista de
     * productos.
     */
    public function update(Request $request, $id)
    {
        // Obtener el producto existente por su ID
        $product = Product::findOrFail($id);

        // Actualizar el nombre del producto
        $product->name = $request->input('name');

        // Actualizar la descripción del producto
        $product->description = $request->input('description');

        // Actualizar priceKG
        $product->priceKG = floatval($request->input('priceKG'));

        // Verificar el estado de la oferta (sale)
        $saleStatus = $request->input('sale') == 1; // Convertir a booleano (true si '1', false si '0')

        if ($saleStatus) {
            // La oferta está activa
            $product->sale = true;

            // Obtener y validar el nuevo priceSale
            $newPriceSale = floatval($request->input('priceSale'));
            $product->priceSale = !is_nan($newPriceSale) ? $newPriceSale : 0;

            // Calcular priceKGFinal
            $product->priceKGFinal = $product->priceKG - $product->priceSale;
        } else {
            // La oferta está desactivada
            $product->sale = false;
            $product->priceSale = 0;
            $product->priceKGFinal = $product->priceKG; // priceKGFinal igual a priceKG cuando no hay oferta
        }

        // Actualizar el stock del producto
        $product->stock = intval($request->input('stock'));

        // Manejo de la imagen (si se proporciona una nueva imagen)
        if ($request->hasFile('urlImagen')) {
            $imagen = $request->file('urlImagen');
            $nombreProducto = $product->name; // Nombre del producto como nombre de archivo
            $extension = $imagen->getClientOriginalExtension(); // Extensión del archivo

            // Construir el nombre del archivo con el nombre del producto y su extensión
            $nombreimagen = $nombreProducto . '.' . $extension;

            // Ruta completa donde se guardará la imagen
            $rutaImagen = 'assets/' . $nombreimagen;

            // Mover la imagen al directorio de almacenamiento (public_path)
            $imagen->move(public_path('assets'), $nombreimagen);

            // Actualizar la URL de la imagen solo si se ha proporcionado una nueva imagen
            $product->urlImagen = $rutaImagen;
        }

        // Guardar los cambios en el producto
        $product->save();

        // Redireccionar de vuelta a la lista de productos con un mensaje de éxito
        return redirect()->route('admin.product.index');
    }  
}