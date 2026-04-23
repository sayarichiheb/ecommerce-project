@extends('layouts.app')

@section('title', 'Gestion commandes')

@section('content')
<h2>📋 Gestion des commandes</h2>
<a href="{{ route('admin.dashboard') }}" class="btn btn-secondary mb-3">← Dashboard</a>

@foreach($orders as $order)
<div class="card mb-3">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>Commande #{{ $order->id }} – {{ $order->user?->name ?? 'Utilisateur supprimé' }} – {{ $order->total }} TND</span>
        <form method="POST" action="{{ route('admin.orders.status', $order) }}" class="d-flex gap-2">
            @csrf @method('PUT')
            <select name="status" class="form-select form-select-sm" style="width:150px">
                <option value="en_attente" {{ $order->status=='en_attente' ? 'selected' : '' }}>En attente</option>
                <option value="validee"    {{ $order->status=='validee'    ? 'selected' : '' }}>Validée</option>
                <option value="annulee"    {{ $order->status=='annulee'    ? 'selected' : '' }}>Annulée</option>
            </select>
            <button class="btn btn-primary btn-sm">Mettre à jour</button>
        </form>
    </div>
    <div class="card-body">
        <ul class="mb-0">
            @foreach($order->items as $item)
                <li>{{ $item->product->title ?? 'Produit supprimé' }} × {{ $item->quantity }} — {{ $item->price }} TND</li>
            @endforeach
        </ul>
    </div>
</div>
@endforeach
@endsection