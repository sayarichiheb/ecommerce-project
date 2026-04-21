@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <h2>Ajouter un produit</h2>
        <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label>Titre</label>
                <input type="text" name="title" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Description</label>
                <textarea name="description" class="form-control" rows="4" required></textarea>
            </div>
            <div class="mb-3">
                <label>Prix (TND)</label>
                <input type="number" name="price" step="0.01" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Stock</label>
                <input type="number" name="stock" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Catégorie</label>
                <select name="category_id" class="form-select" required>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label>Image (optionnel)</label>
                <input type="file" name="image" class="form-control">
            </div>
            @if($errors->any())
                <div class="alert alert-danger">
                    @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif
            <button type="submit" class="btn btn-primary">Ajouter</button>
        </form>
    </div>
</div>
@endsection