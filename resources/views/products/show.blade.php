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
    @php
        $alreadyReviewed = $reviews->where('user_id', Auth::id())->count() > 0;
    @endphp

    @if($product->user_id === Auth::id())
        <div class="alert alert-warning">Vous ne pouvez pas noter votre propre produit.</div>
    @elseif($alreadyReviewed)
        <div class="alert alert-info">Vous avez déjà laissé un avis sur ce produit.</div>
    @else
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
    @endif
@endauth

@forelse($reviews as $review)
    <div class="card mb-2">
        <div class="card-body d-flex justify-content-between align-items-start">
            <div>
                <strong>{{ $review->user->name }}</strong>
                <span class="text-warning">⭐ {{ $review->rating }}/5</span>
                <p>{{ $review->comment }}</p>
            </div>
            @auth
                @if($review->user_id === Auth::id() || Auth::user()->role === 'admin')
                    <form method="POST" action="{{ route('reviews.destroy', $review) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm"
                            onclick="return confirm('Supprimer cet avis ?')">
                            🗑️
                        </button>
                    </form>
                @endif
            @endauth
        </div>
    </div>
@empty
    <p>Aucun avis pour ce produit.</p>
@endforelse
@endsection