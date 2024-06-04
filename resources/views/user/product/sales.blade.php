<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ofertas</title>
    <link href="{{ asset('assets/css/sales.css') }}" rel="stylesheet">
</head>
<body>
    <x-app-layout>
        <div class="container mt-4">
            <div class="titulo">
                <h1 class="section-title">Ofertas</h1>
            </div>
            @foreach($categoriesWithProducts as $category)
                    <div class="category-section mb-5">
                        <h2 class="category-title mb-3">{{ $category->name }}</h2>
                        <div class="product-list">
                            @forelse($category->products as $product)
                            @if ($product->stock > 0)
                                <div class="product-card">
                                    <div class="card">
                                        <img src="{{ asset($product->urlImagen) }}" class="card-img-top product-image" alt="{{ $product->name }}">
                                        <div class="card-body">
                                            <div class="product-info">
                                                <h5 class="product-name">{{ $product->name }}</h5>
                                                <p class="product-price text-strike"><strong>Precio (KG):</strong> {{ $product->priceKG }}€</p>
                                                @if($product->sale)
                                                    <div class="price-discount-container">
                                                        <p class="product-sale-price highlight-sale-price"><strong>Precio Rebajado:</strong> {{ $product->priceSale }}€</p>
                                                        <p class="discount-text">Descuento: {{ round(($product->priceKG - $product->priceKGFinal) / $product->priceKG * 100) }}%</p>
                                                    </div>
                                                @endif
                                                <p class="product-final-price highlight-price"><strong>Precio Final (KG):</strong> {{ $product->priceKGFinal }}€</p>
                                                <div class="stock">
                                                    <a href="{{ route('product.moreInformation', ['product_id' => $product->id]) }}" class="buy-button">Comprar</a>
                                                </div>
                                                <div>
                                                    <p class="product-stock">Quedan: {{ $product->stock }} KG</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            @empty
                                <p class="no-products-message">No hay productos en oferta en esta categoría.</p>
                            @endforelse
                        </div>
                        @if($category->products->hasPages())
                            <div class="pagination-container d-flex justify-content-center mt-4">
                                {{ $category->products->appends(["page_{$category->id}" => $category->products->currentPage()])->links() }}
                            </div>
                        @endif
                    </div>
            @endforeach
            <br>
            <br>
        </div>
    </x-app-layout>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
<x-app-footer-layout>
</x-app-footer-layout>
</html>
