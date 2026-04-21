@extends('layouts.app')

@section('title', 'Mon profil')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">👤 Mon profil</div>
            <div class="card-body">
                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Nom</label>
                        <input type="text" name="name"
                               class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name', $user->name) }}" required>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email"
                               class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email', $user->email) }}" required>
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nouveau mot de passe <small class="text-muted">(laisser vide pour ne pas changer)</small></label>
                        <input type="password" name="password"
                               class="form-control @error('password') is-invalid @enderror">
                        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Confirmer mot de passe</label>
                        <input type="password" name="password_confirmation" class="form-control">
                    </div>
                    <button class="btn btn-primary w-100">💾 Enregistrer</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection