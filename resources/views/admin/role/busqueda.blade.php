@if ($users->isEmpty())
    <strong><p>No se encontraron usuarios con ese correo.</p></strong>
@else
    @foreach($users as $user)
        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Usuario ID: {{ $user->id }}</h5>
                    <p class="card-text"><strong>Nombre:</strong> {{ $user->name }}</p>
                    <p class="card-text"><strong>Email:</strong> {{ $user->email }}</p>
                    <p class="card-text"><strong>Rol:</strong> {{ $user->role }}</p>

                    @if($user->email === 'admin@gmail.com')
                        <p class="text-danger"><em>Este usuario es el administrador principal y no se pueden editar sus datos.</em></p>
                    @else
                        @if($user->id === auth()->user()->id)
                            <form action="{{ route('admin.user.update', $user->id) }}" method="POST" onsubmit="return validateForm(this);">
                                @csrf
                                @method('PUT')

                                <div class="form-group">
                                    <label for="email">Email:</label>
                                    <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}">
                                </div>

                                <div class="form-group">
                                    <label for="address">Dirección:</label>
                                    <input type="text" class="form-control" id="address" name="address" value="{{ $user->address }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="role">Rol:</label>
                                    <input type="text" class="form-control strikethrough" id="role" name="role" value="{{ $user->role }}" disabled>
                                    <p class="text-warning"><em>No puedes editar tu propio rol.</em></p>
                                </div>

                                <button type="submit" class="btn btn-primary">GUARDAR CAMBIOS</button>
                            </form>
                        @elseif(auth()->user()->role !== 'admin' || (auth()->user()->role === 'admin' && auth()->user()->id === 1) || auth()->user()->email === 'admin@gmail.com' || $user->role !== 'admin')
                            <form action="{{ route('admin.user.update', $user->id) }}" method="POST" onsubmit="return validateForm(this);">
                                @csrf
                                @method('PUT')

                                <div class="form-group">
                                    <label for="email">Email:</label>
                                    <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}">
                                </div>

                                <div class="form-group">
                                    <label for="address">Dirección:</label>
                                    <input type="text" class="form-control" id="address" name="address" value="{{ $user->address }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="role">Rol:</label>
                                    <select class="form-control" id="role" name="role">
                                        <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>User</option>
                                        <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                    </select>
                                </div>

                                <button type="submit" class="btn btn-primary">GUARDAR CAMBIOS</button>
                            </form>

                            <form id="formDeleteUser{{ $user->id }}" action="{{ route('admin.user.destroy', $user->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="confirmarEliminacion('{{ $user->id }}', '{{ $user->name }}')" class="btn" style="background-color: #dc3545; color: #fff; border-color: #dc3545;">ELIMINAR USUARIO</button>
                            </form>
                        @else
                            <p class="text-danger"><em>No tienes permiso para editar a otros administradores.</em></p>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    @endforeach
@endif

<script>
    function confirmarEliminacion(id, name) {
        var mensaje = "¿Estás seguro de que quieres eliminar a " + name + " con ID " + id + "?";
        if (confirm(mensaje)) {
            document.getElementById('formDeleteUser' + id).submit();
        }
    }

    function validateForm(form) {
        let email = form.email.value;
        let address = form.address.value;
        let emailRegex = /^[a-zA-Z0-9._%+-]+@(gmail|hotmail)\.(com|es)$/;
        let addressRegex = /^(avenida |Avenida |calle |Calle |cruce |Cruce |pasaje |Pasaje )?[^\/]+$/i;

        if (!emailRegex.test(email)) {
            alert('El correo no es válido.');
            return false;
        }

        if (!addressRegex.test(address)) {
            alert('La dirección no cumple con el formato requerido.');
            return false;
        }

        return true;
    }
</script>
