<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\User;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('user.profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

/**
 * La función `viewRole` recupera todos los usuarios y los pasa a la vista para mostrar las funciones
 * de los usuarios en un panel de administración.
 * 
 * @return La función `viewRole` devuelve una vista llamada 'admin.role.roleuser' con los datos de
 * todos los usuarios obtenidos del modelo de Usuario usando el método `User::all()`. Los datos de los
 * usuarios se pasan a la vista utilizando la función "compacta".
 */
    public function viewRole(){
        $users = User::all();
        return view('admin.role.roleuser',compact('users'));
    }    

/**
 * La función busca usuarios basándose en una consulta por correo electrónico y devuelve los resultados
 * de la búsqueda en una respuesta JSON con contenido HTML.
 * 
 * @param Request request La función `buscar` en el fragmento de código que proporcionaste es una
 * función PHP que toma un objeto `Solicitud` como parámetro. El objeto `Request` se usa normalmente en
 * aplicaciones Laravel para manejar solicitudes HTTP entrantes.
 * 
 * @return Se devuelve una respuesta JSON con la clave 'html' que contiene la vista renderizada de
 * 'admin.role.busqueda' con los datos de los usuarios pasados como una variable.
 */
    public function search(Request $request)
    {
        $query = $request->get('search');
        $users = User::where('email', 'LIKE', "%{$query}%")->get();

        $view = view('admin.role.busqueda', compact('users'))->render();

        return response()->json(['html' => $view]);
    }

    /**
     * La función `updateRole` en PHP valida y actualiza la información del rol del usuario,
     * verificando la unicidad del correo electrónico y evitando la edición de los datos del
     * administrador principal.
     * 
     * @param Request request La función `updateRole` que proporcionó es responsable de actualizar el
     * rol y otros detalles de un usuario en función de la entrada recibida a través de una solicitud.
     * Analicemos la función y sus parámetros:
     * @param id El parámetro `id` en la función `updateRole` representa el identificador único del
     * usuario cuya función e información se están actualizando. Este identificador se utiliza
     * normalmente para recuperar al usuario de la base de datos, validar la unicidad del correo
     * electrónico y actualizar los detalles del usuario en consecuencia.
     * 
     * @return La función `updateRole` devuelve una vista llamada 'admin.role.roleuser' con la lista de
     * todos los usuarios después de actualizar la función y la dirección de correo electrónico del
     * usuario. Si hay algún error de validación o se cumplen condiciones específicas (como un correo
     * electrónico que ya está siendo utilizado por otro usuario o si se intenta editar el usuario
     * administrador principal), devolverá la vista 'admin.roleuser' con un mensaje de error.
     */
    public function updateRole(Request $request, $id)
    {
        $request->validate([
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($id),
            ],
            'role' => 'required|in:user,admin',
            'address' => ['nullable', 'string', 'max:255'],
        ]);
    
        // Obtener el usuario a actualizar
        $user = User::findOrFail($id);
    
        // Verificar si el correo electrónico ya está en uso por otro usuario
        $existingUser = User::where('email', $request->input('email'))->where('id', '!=', $id)->first();
        if ($existingUser) {
            $users = User::all();
            return view('admin.roleuser', compact('users'))->with('error', 'El correo electrónico ya está en uso por otro usuario.');
        }
    
        // Verificar si el usuario es el administrador principal
        if ($user->email === 'admin@gmail.com') {
            $users = User::all();
            return view('admin.roleuser', compact('users'))->with('error', 'No puedes editar los datos del administrador principal.');
        }
    
        // Actualizar los datos del usuario
        $user->email = $request->input('email');
        $user->address = $request->input('address');
        $user->role = $request->input('role');
        $user->save();
    
        $users = User::all();
        return view('admin.role.roleuser', compact('users'));
    }    
    
/**
 * La función `destroyAdmin` elimina un usuario con la ID especificada y luego devuelve una vista que
 * muestra todos los usuarios.
 * 
 * @param id La función `destroyAdmin` toma un parámetro `` que se utiliza para encontrar el usuario
 * con el ID correspondiente en la base de datos. Luego, este usuario se elimina de la base de datos
 * utilizando el método `delete()`. Después de la eliminación, todos los usuarios se recuperan de la
 * base de datos y se pasan al `roleuser
 * 
 * @return La función `destroyAdmin` devuelve una vista llamada 'admin.role.roleuser' con la variable
 * 'usuarios' pasada, que contiene todos los registros de usuario después de eliminar un usuario
 * específico con el `` dado.
 */
    public function destroyAdmin($id){
        $user = User::findOrFail($id);
        $user->delete();
        $users = User::all();
        return view('admin.role.roleuser',compact('users'));
    }
}