@extends('layouts.app')

@section('content')
<h2>Mes Commandes</h2>

@forelse($orders as $order)
    <div class="card mb-3">
        <div class="card-header">
            Commande #{{ $order->id }} —
            <span class="badge bg-{{ $order->status == 'validee' ? 'success' : ($order->status == 'annulee' ? 'danger' : 'warning') }}">
                {{ $order->status }}
            </span>
            — Total : {{ $order->total }} TND
        </div>
        <div class="card-body">
            <ul>
                @foreach($order->items as $item)
                    <li>{{ $item->product->title }} x{{ $item->quantity }} — {{ $item->price }} TND</li>
                @endforeach
            </ul>
        </div>
    </div>
@empty
    <p>Aucune commande pour le moment.</p>
@endforelse
@endsection