@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">Vérifiez votre email</div>
            <div class="card-body">
                <p>Merci de vous être inscrit ! Avant de commencer, veuillez vérifier votre adresse email en cliquant sur le lien que nous venons de vous envoyer.</p>
                
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <form method="POST" action="{{ route('verification.send') }}" class="mb-3">
                    @csrf
                    <button type="submit" class="btn btn-primary">Renvoyer l'email de vérification</button>
                </form>

                <hr>
                <p class="text-muted small">Pour la démo (simulation du clic sur l'email) :</p>
                <form method="POST" action="{{ route('verification.demo') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">✅ Vérifier mon email maintenant</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection