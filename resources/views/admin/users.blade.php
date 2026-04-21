@extends('layouts.app')

@section('title', 'Gestion utilisateurs')

@section('content')
<h2>👥 Gestion des utilisateurs</h2>
<a href="{{ route('admin.dashboard') }}" class="btn btn-secondary mb-3">← Dashboard</a>
<table class="table table-striped">
    <thead>
        <tr><th>ID</th><th>Nom</th><th>Email</th><th>Rôle</th><th>Produits</th><th>Commandes</th><th>Inscrit le</th><th>Action</th></tr>
    </thead>
    <tbody>
        @foreach($users as $user)
        <tr>
            <td>{{ $user->id }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td><span class="badge bg-{{ $user->role=='admin' ? 'danger' : 'secondary' }}">{{ $user->role }}</span></td>
            <td>{{ $user->products_count }}</td>
            <td>{{ $user->orders_count }}</td>
            <td>{{ $user->created_at->format('d/m/Y') }}</td>
            <td>
                @if($user->role !== 'admin')
                <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
                      onsubmit="return confirm('Supprimer ?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-danger btn-sm">🗑️</button>
                </form>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection