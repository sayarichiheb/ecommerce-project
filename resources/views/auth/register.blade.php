@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">Inscription</div>
            <div class="card-body">
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="mb-3">
                        <label>Nom</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Mot de passe</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Confirmer mot de passe</label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>
                    @if($errors->any())
                        <div class="alert alert-danger">
                            @foreach($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif
                    <button type="submit" class="btn btn-primary w-100">S'inscrire</button>
                </form>
                <p class="mt-3 text-center">Déjà un compte ? <a href="{{ route('login') }}">Connexion</a></p>
            </div>
        </div>
    </div>
</div>
@endsection 