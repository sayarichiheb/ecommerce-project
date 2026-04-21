@extends('layouts.app')

@section('title', 'Modifier le produit')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <h2>✏️ Modifier le produit</h2>
        <form method="POST" action="{{ route('products.update', $product) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label">Titre</label>
                <input type="text" name="title"
                       class="form-control @error('title') is-invalid @enderror"
                       value="{{ old('title', $product->title) }}" required>
                @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" rows="4"
                          class="form-control @error('description') is-invalid @enderror"
                          required>{{ old('description', $product->description) }}</textarea>
                @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Prix (TND)</label>
                    <input type="number" name="price" step="0.01" min="0"
                           class="form-control @error('price') is-invalid @enderror"
                           value="{{ old('price', $product->price) }}" required>
                    @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Stock</label>
                    <input type="number" name="stock" min="0"
                           class="form-control @error('stock') is-invalid @enderror"
                           value="{{ old('stock', $product->stock) }}" required>
                    @error('stock') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Catégorie</label>
                <select name="category_id"
                        class="form-select @error('category_id') is-invalid @enderror" required>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Image</label>
                @if($product->image)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $product->image) }}"
                             class="img-thumbnail" style="max-height:120px;">
                        <p class="text-muted small mt-1">Image actuelle</p>
                    </div>
                @endif
                <input type="file" name="image" class="form-control" accept="image/*">
                <small class="text-muted">Laisser vide pour garder l'image actuelle</small>
            </div>
            @if($errors->any())
                <div class="alert alert-danger">
                    @foreach($errors->all() as $error)
                        <p class="mb-0">{{ $error }}</p>
                    @endforeach
                </div>
            @endif
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-warning">💾 Enregistrer</button>
                <a href="{{ route('products.index') }}" class="btn btn-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection