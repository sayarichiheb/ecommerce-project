@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<h2>🛠️ Dashboard Admin</h2>
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card text-white bg-primary text-center p-3">
            <h3>{{ $totalUsers }}</h3><p class="mb-0">👥 Utilisateurs</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-success text-center p-3">
            <h3>{{ $totalProducts }}</h3><p class="mb-0">📦 Produits</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-warning text-center p-3">
            <h3>{{ $totalOrders }}</h3><p class="mb-0">🛒 Commandes</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-danger text-center p-3">
            <h3>{{ number_format($totalRevenue, 2) }} TND</h3><p class="mb-0">💰 Revenus</p>
        </div>
    </div>
</div>
<div class="d-flex gap-2 mb-4">
    <a href="{{ route('admin.users') }}" class="btn btn-outline-primary">👥 Utilisateurs</a>
    <a href="{{ route('admin.orders') }}" class="btn btn-outline-warning">📋 Commandes</a>
    <a href="{{ route('products.index') }}" class="btn btn-outline-success">📦 Catalogue</a>
</div>
<h4>Dernières commandes</h4>
<table class="table table-striped">
    <thead><tr><th>#</th><th>Client</th><th>Total</th><th>Statut</th><th>Date</th></tr></thead>
    <tbody>
        @foreach($recentOrders as $order)
        <tr>
            <td>{{ $order->id }}</td>
            <td>{{ $order->user?->name ?? 'Utilisateur supprimé' }}</td>
            <td>{{ $order->total }} TND</td>
            <td>
                <span class="badge bg-{{ $order->status=='validee' ? 'success' : ($order->status=='annulee' ? 'danger' : 'warning') }}">
                    {{ $order->status }}
                </span>
            </td>
            <td>{{ $order->created_at->format('d/m/Y') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection