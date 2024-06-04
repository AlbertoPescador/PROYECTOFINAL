<div class="table-container" id="productSearch">
    @if ($products->isEmpty())
        <strong><p>No se encontraron productos ese nombre.</p></strong>
    @else
    <table class="table table-bordered text-center">
        <thead>
            <tr>
                <th>ID</th>
                <th>IMAGEN</th>
                <th>NOMBRE</th>
                <th>DESCRIPCION</th>
                <th>PRECIO (KG)</th>
                <th>STOCK (KG)</th>
                <th>OFERTA</th>
                <th>CATEGORÍA</th>
                <th>PRECIO REBAJADO (€)</th>
                <th>PRECIO FINAL (KG)</th> 
                <th>ACCIONES</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td><img src="{{ url($product->urlImagen) }}" alt="" class="product-image"></td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->description }}</td>
                    <td>{{ number_format($product->priceKG, 2) }}</td>
                    <td>{{ $product->stock }}</td>
                    <td>{{ $product->sale ? 'Sí' : 'No' }}</td>
                    <td>{{ $product->category->name }}</td>
                    <td>{{ $product->priceSale !== null ? number_format($product->priceSale, 2) : '-' }}</td>
                    <td>{{ number_format($product->priceKGFinal ?: $product->priceKG, 2) }}</td>
                    <td>
                        <a href="{{ route("admin.product.edit", $product->id) }}" class="btn btn-success">EDITAR PRODUCTO</a>
                        <form id="formDeleteProduct{{ $product->id }}" action="{{ route('admin.product.destroy', $product->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="button" onclick="confirmarEliminacion('{{ $product->id }}', '{{ $product->name }}')" class="btn" style="background-color: #dc3545; color: #fff; border-color: #dc3545;">ELIMINAR PRODUCTO</button>
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
            document.getElementById('formDeleteProduct' + id).action = "/admin/gestproduct/delete/" + id;
            document.getElementById('formDeleteProduct' + id).submit();
        }
    }
</script>