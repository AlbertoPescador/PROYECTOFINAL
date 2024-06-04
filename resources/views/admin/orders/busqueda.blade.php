<div class="table-container" id="userSearch">
    @if ($users->isEmpty())
        <strong><p>No se encontraron usuarios con ese correo.</p></strong>
    @else
    <table class="table table-bordered text-center">
        <thead>
            <tr>
                <th>ID</th>
                <th>NOMBRE</th>
                <th>EMAIL</th>
                <th>ACCIONES</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <a href="{{ route("admin.order.userInvoices", $user->id) }}" class="btn btn-primary">VER FACTURAS</a>
                    </td>
                </tr>
                @endforeach
        </tbody>
    </table>
    @endif
</div>