@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">Mot de passe oublié</div>
            <div class="card-body">
                <p>Entrez votre adresse email et nous vous enverrons un lien pour réinitialiser votre mot de passe.</p>

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>

                    @if($errors->any())
                        <div class="alert alert-danger">
                            @foreach($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif

                    <button type="submit" class="btn btn-primary">Envoyer le lien</button>
                </form>

                <p class="mt-3"><a href="{{ route('login') }}">Retour à la connexion</a></p>
            </div>
        </div>
    </div>
</div>
@endsection