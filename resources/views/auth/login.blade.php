@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">Connexion</div>
            <div class="card-body">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Mot de passe</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    @if($errors->any())
                        <div class="alert alert-danger">
                            @foreach($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif
                    <button type="submit" class="btn btn-primary w-100">Se connecter</button>
                    <p class="mt-3 text-center">
    <a href="{{ route('password.request') }}">Mot de passe oublié ?</a>
</p>
<p class="text-center">Pas de compte ? <a href="{{ route('register') }}">Inscription</a></p>
                    
                </form>

            </div>
        </div>
    </div>
</div>
@endsection