<div class="container">
    <div class="row product-list">
        @if ($products->isEmpty())
            <strong><p>No se encontraron productos de la categoría {{ $category->name }}.</p></strong>
        @else
            @foreach ($products as $product)
                @if ($product->stock > 0)
                    <div class="col-12 col-md-4 mb-4">
                        <div class="card product-card">
                            <img class="product-image" src="{{ asset($product->urlImagen) }}" alt="{{ $product->name }}">
                            <div class="card-body">
                                @if ($product->sale)
                                    <span class="badge badge-warning badge-lg">Oferta</span>
                                @endif
                                <div class="product-info">
                                    <h5 class="product-name @if (!$product->sale) font-weight-bold @endif">{{ $product->name }}</h5>
                                    @if ($product->sale)
                                        <p class="card-text product-price text-strike">Precio por KG: {{ number_format($product->priceKG, 2) }}€</p>
                                        <div class="price-discount-container">
                                            <p class="card-text product-final-price">Precio Final: {{ number_format($product->priceKGFinal, 2) }}€</p>
                                            <p class="discount-text">Descuento: {{ round(($product->priceKG - $product->priceKGFinal) / $product->priceKG * 100) }}%</p>
                                        </div>
                                    @else
                                        <p class="card-text product-price font-weight-bold">Precio por KG: {{ number_format($product->priceKG, ($product->stock - (int)$product->stock > 0 ? 2 : 0)) }}€</p>
                                    @endif
                                    <div class="buy-stock-container">
                                        <a href="{{ route('product.moreInformation', ['product_id' => $product->id]) }}" class="btn btn-primary buy-button">Comprar</a>
                                        <p class="card-text product-stock">Quedan: {{ number_format($product->stock, 2) }} KG</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        @endif
    </div>
</div>
