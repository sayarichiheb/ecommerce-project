@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-6">
        @if($product->image)
            <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid rounded">
        @endif
    </div>
    <div class="col-md-6">
        <h2>{{ $product->title }}</h2>
        <p class="text-muted">{{ $product->category->name }}</p>
        <h4 class="text-success">{{ $product->price }} TND</h4>
        <p>{{ $product->description }}</p>
        <p>Stock : {{ $product->stock }}</p>
        @auth
            <form method="POST" action="{{ route('cart.add', $product) }}">
                @csrf
                <button class="btn btn-success">🛒 Ajouter au panier</button>
            </form>
        @endauth
    </div>
</div>

<hr>
<h4>Avis clients</h4>

@auth
<form method="POST" action="{{ route('reviews.store', $product) }}" class="mb-4">
    @csrf
    <div class="mb-2">
        <label>Note (1-5)</label>
        <input type="number" name="rating" min="1" max="5" class="form-control" style="width:100px">
    </div>
    <div class="mb-2">
        <label>Commentaire</label>
        <textarea name="comment" class="form-control" rows="3"></textarea>
    </div>
    <button class="btn btn-primary">Envoyer</button>
</form>
@endauth

@forelse($reviews as $review)
    <div class="card mb-2">
        <div class="card-body">
            <strong>{{ $review->user->name }}</strong>
            <span class="text-warning">⭐ {{ $review->rating }}/5</span>
            <p>{{ $review->comment }}</p>
        </div>
    </div>
@empty
    <p>Aucun avis pour ce produit.</p>
@endforelse
@endsection