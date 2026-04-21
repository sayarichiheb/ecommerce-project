@extends('layouts.app')

@section('content')
<h2>Catalogue Produits</h2>

<form method="GET" action="{{ route('products.index') }}" class="row g-2 mb-4" id="searchForm">
    <div class="col-md-4">
        <input type="text" name="search" class="form-control" placeholder="Rechercher..." value="{{ request('search') }}">
    </div>
    <div class="col-md-3">
        <select name="category" class="form-select">
            <option value="">Toutes les catégories</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-3">
        <select name="sort" class="form-select">
            <option value="">Trier par</option>
            <option value="price_asc">Prix croissant</option>
            <option value="price_desc">Prix décroissant</option>
        </select>
    </div>
    <div class="col-md-2">
        <button type="submit" class="btn btn-primary w-100">Filtrer</button>
    </div>
</form>

<div class="row">
    @forelse($products as $product)
        <div class="col-md-3 mb-4">
            <div class="card h-100">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" style="height:200px;object-fit:cover;">
                @endif
                <div class="card-body">
                    <h5 class="card-title">{{ $product->title }}</h5>
                    <p class="text-muted">{{ $product->category->name }}</p>
                    <p class="fw-bold">{{ $product->price }} TND</p>
                    <a href="{{ route('products.show', $product) }}" class="btn btn-outline-primary btn-sm">Voir</a>
                   @auth
                        <button class="btn btn-success btn-sm"
                            onclick="document.getElementById('cart-form-{{ $product->id }}').submit()">
                            🛒 Ajouter
                        </button>
                        <form id="cart-form-{{ $product->id }}"
                              method="POST"
                              action="{{ route('cart.add', $product) }}"
                              style="display:none">
                            @csrf
                        </form>

                        @if($product->user_id === Auth::id() || Auth::user()->role === 'admin')
                         <a href="{{ route('products.edit', $product) }}" class="btn btn-warning btn-sm">✏️</a><form method="POST" action="{{ route('products.destroy', $product) }}" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"
                                onclick="return confirm('Supprimer ce produit ?')">
                                🗑️
                            </button>
                        </form>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    @empty
        <p>Aucun produit trouvé.</p>
    @endforelse
</div>

{{ $products->links() }}
@endsection