@extends('layouts.app')

@section('content')
<div class="container mainContainer toggleContainer">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card customCard">
                <div class="card-body">
                    <div class="container text-center registerTitle mb-4">
                        Reset password
                    </div>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="form-group row">
                            <div class="row col-md-4 align-items-center">
                                <div class="mr-2 ml-3"><i class="material-icons font-weight-lighter materialIcons">email</i></div>
                                <div>{{ __('E-Mail Address') }}</div>
                            </div>

                            <div class="col-md-8">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            </div>
                        </div>
                        @error('email')
                        <span class="form-group row invalid-feedback errorMessage mt-md-n2 ml-md-n3 ml-1" role="alert">
                                <strong class="offset-md-4 col-md-8 p-0">{{ $message }}</strong>
                            </span>
                        @enderror

                        <div class="form-group row mb-0 mt-5 text-center">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary resetEmailSubmit">
                                    {{ __('Send Password Reset Link') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
