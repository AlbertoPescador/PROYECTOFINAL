@if ($categories->isEmpty())
    <strong><p>No se encontraron categorías con esta búsqueda</p></strong>
@else
<div class="table-container">
    <table class="table table-bordered text-center">
        <thead>
            <tr>
                <th>ID</th>
                <th>NOMBRE</th>
                <th>ACCIONES</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $category)
                <tr>
                    <td>{{ $category->id }}</td>
                    <td>{{ $category->name }}</td>
                    <td>
                        <a href="{{ route('admin.category.edit', $category->id) }}" class="btn btn-success">EDITAR CATEGORÍA</a>
                        <form id="formDeleteCategory{{ $category->id }}" action="{{ route('admin.category.destroy', $category->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="button" onclick="confirmarEliminacion('{{ $category->id }}', '{{ $category->name }}')" class="btn" style="background-color: #dc3545; color: #fff; border-color: #dc3545;">ELIMINAR CATEGORÍA</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif

<script>
    function confirmarEliminacion(id, name) {
        var mensaje = "¿Estás seguro de que quieres eliminar a " + name + " con ID " + id + "?";
        if (confirm(mensaje)) {
            // Corrige la URL de la acción dinámicamente
            document.getElementById('formDeleteCategory' + id).action = "/admin/gestcategory/delete/" + id;
            document.getElementById('formDeleteCategory' + id).submit();
        }
    }
</script>