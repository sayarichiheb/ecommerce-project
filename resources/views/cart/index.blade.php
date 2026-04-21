@extends('layouts.app')

@section('content')
<h2>Mon Panier</h2>

@if(empty($cart))
    <p>Votre panier est vide. <a href="{{ route('products.index') }}">Continuer les achats</a></p>
@else
    <table class="table">
        <thead>
            <tr>
                <th>Produit</th>
                <th>Prix</th>
                <th>Quantité</th>
                <th>Total</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @php $total = 0; @endphp
            @foreach($cart as $id => $item)
                @php $total += $item['price'] * $item['quantity']; @endphp
                <tr>
                    <td>{{ $item['title'] }}</td>
                    <td>{{ $item['price'] }} TND</td>
                    <td>
                        <form method="POST" action="{{ route('cart.update', $id) }}">
                            @csrf @method('PUT')
                            <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" class="form-control" style="width:80px">
                        </form>
                    </td>
                    <td>{{ $item['price'] * $item['quantity'] }} TND</td>
                    <td>
                        <form method="POST" action="{{ route('cart.remove', $id) }}">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h4>Total : {{ $total }} TND</h4>

    <form method="POST" action="{{ route('orders.store') }}">
        @csrf
        <button class="btn btn-success">✅ Passer la commande</button>
    </form>
@endif
<script>
    document.querySelectorAll('input[name="quantity"]').forEach(input => {
        input.addEventListener('change', function() {
            this.closest('form').submit();
        });
    });
</script>
@endsection