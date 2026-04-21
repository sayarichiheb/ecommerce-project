@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">Réinitialiser le mot de passe</div>
            <div class="card-body">
                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Nouveau mot de passe</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Confirmer le mot de passe</label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>

                    @if($errors->any())
                        <div class="alert alert-danger">
                            @foreach($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif

                    <button type="submit" class="btn btn-primary">Réinitialiser</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection