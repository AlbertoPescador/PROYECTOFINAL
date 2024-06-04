<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
/**
 * La función `getCategory` recupera todas las categorías y las pasa a la vista para mostrarlas en un
 * panel de administración.
 * 
 * @return La función `gestCategory` devuelve una vista llamada 'admin.category.index' con los datos de
 * las categorías pasados como una variable compacta.
 */
    public function gestCategory(){
        $categories = Category::all();
        return view('admin.category.index', compact('categories'));
    }

/**
 * La función de creación devuelve una vista para crear una nueva categoría en el panel de
 * administración.
 * 
 * @return Se devuelve una vista denominada 'admin.category.create'.
 */
    public function create()
    {
        return view('admin.category.create');
    }

/**
 * La función de tienda crea una nueva categoría utilizando los datos de la solicitud, recupera todas
 * las categorías y luego devuelve la vista del índice de categorías de administrador con las
 * categorías.
 * 
 * @param Request request El parámetro `` en la función `store` es una instancia de la clase
 * `Illuminate\Http\Request`. Representa la solicitud HTTP que se realiza a la aplicación y contiene
 * todos los datos que se enviaron con la solicitud, como entradas de formulario, encabezados y
 * archivos. En este caso
 * 
 * @return La función `store` devuelve una vista llamada 'admin.category.index' con la variable
 * `` pasada mediante la función `compact`. Es probable que esta vista muestre una lista de
 * categorías.
 */
    public function store (Request $request){
        $category = Category::create($request->except('_token'));
        $categories = Category::all();
        return view('admin.category.index',compact('categories'));
    }

/**
 * La función de edición recupera una categoría específica por su ID y la pasa a la vista de edición
 * para su visualización.
 * 
 * @param category_id El parámetro `category_id` en la función `edit` se utiliza para identificar la
 * categoría específica que debe editarse. Se pasa a la función para recuperar la categoría
 * correspondiente de la base de datos usando el método `Category::find()`. Esto permite
 * que la función obtenga los detalles de la categoría.
 * 
 * @return La función `editar` devuelve una vista llamada `admin.category.edit` con los datos de la
 * categoría recuperados usando el método `Category::find()`. Los datos de la categoría se
 * pasan a la vista utilizando el método "with".
 */
    public function edit($category_id)
    {
        $category = Category::find($category_id);
        return view('admin.category.edit')->with('category', $category);
    }

/**
 * La función de actualización en PHP actualiza una categoría según los datos de la solicitud,
 * excluyendo el campo Category_id, y luego devuelve la lista actualizada de categorías con un mensaje
 * de éxito.
 * 
 * @param Request request El parámetro `` en la función `update` es una instancia de la clase
 * `Illuminate\Http\Request`. Representa la solicitud HTTP que se realiza al servidor y contiene datos
 * como entradas de formulario, encabezados y archivos enviados en la solicitud.
 * @param category_id El parámetro `` en la función `update` representa el identificador
 * único de la categoría que desea actualizar. Se utiliza para encontrar la categoría específica en la
 * base de datos que necesita actualizarse.
 * 
 * @return El método `update` en el fragmento de código actualiza una categoría con el ``
 * dado usando los datos del objeto ``, excluyendo el campo 'category_id'. Después de
 * actualizar la categoría, recupera todas las categorías y devuelve una vista denominada
 * 'admin.category.index' con los datos de las categorías y un mensaje flash que indica que la
 * categoría se actualizó correctamente.
 */
    public function update(Request $request, $category_id)
    {
        $category = Category::find($category_id);
        $category->update($request->except('category_id'));
        $categories = Category::all();
        return view('admin.category.index',compact('categories'))->with('flash_message', 'Categoria actualizada correctamente');  
    }
    
/**
 * La función `destruir` elimina una categoría por su ID y luego devuelve la lista actualizada de
 * categorías para mostrar en la vista de índice de categorías de administrador.
 * 
 * @param category_id El parámetro `category_id` en la función `destroy` se utiliza para identificar la
 * categoría específica que debe eliminarse de la base de datos. Este parámetro normalmente se pasa
 * como argumento al llamar a la función "destruir", indicando qué categoría se debe eliminar.
 * 
 * @return El método `destroy` devuelve una vista llamada 'admin.category.index' con la variable
 * `` pasada. Esta variable contiene todas las categorías recuperadas usando
 * `Category::all()` después de eliminar una categoría específica con el `` dado.
 */
    public function destroy($category_id)
    {
        $category = Category::findOrFail($category_id);
        $category->delete();
        $categories = Category::all();
        return view('admin.category.index',compact('categories'));
    }
    
/**
 * La función PHP busca categorías basándose en la entrada del usuario y devuelve los resultados como
 * una vista parcial para solicitudes AJAX o una vista completa para solicitudes regulares.
 * 
 * @param Request request La función "buscar" en el fragmento de código que proporcionó es un método
 * que maneja la búsqueda de categorías según un término de búsqueda ingresado por el usuario. A
 * continuación se muestra un desglose de lo que hace la función:
 * 
 * @return Si la solicitud es una solicitud AJAX, se devuelve una respuesta JSON que contiene el HTML
 * de una vista parcial para la tabla de categorías. De lo contrario, se devuelve la vista completa
 * 'admin.category.index' con las categorías y los datos de los términos de búsqueda.
 */
    public function search(Request $request)
    {
        $busqueda = $request->input('busqueda');
    
        $categories = Category::query();
    
        if (!empty($busqueda)) {
            $categories->where('name', 'LIKE', '%' . $busqueda . '%');
        }
    
        $categories = $categories->oldest('id')->paginate(10);
    
        if ($request->ajax()) {
            $view = view('admin.category.busqueda', compact('categories'))->render(); // Renderizar vista parcial para la tabla de categorías
            return response()->json(['html' => $view]);
        }
    
        return view('admin.category.index', compact('categories', 'busqueda')); // Cargar la vista completa con los resultados de la búsqueda
    }
}