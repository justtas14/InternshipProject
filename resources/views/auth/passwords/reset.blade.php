@extends('layouts.app')

@section('content')
<div class="container mainContainer toggleContainer">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="card customCard">
                <div class="card-body">
                    <div class="container text-center registerTitle mb-4">
                        Reset password
                    </div>
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="form-group row">
                            <div class="row col-lg-4 align-items-center">
                                <div class="mr-2 ml-3"><i class="material-icons font-weight-lighter materialIcons">email</i></div>
                                <div>{{ __('E-Mail Address') }}</div>
                            </div>

                            <div class="col-lg-8">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                            </div>
                        </div>
                        @error('email')
                        <span class="form-group row invalid-feedback errorMessage mt-lg-n2 ml-lg-n3 ml-1" role="alert">
                                <strong class="offset-lg-4 col-lg-8 p-0">{{ $message }}</strong>
                            </span>
                        @enderror

                        <div class="form-group row">
                            <div class="row col-lg-4 align-items-center">
                                <div class="mr-2 ml-3"><i class="material-icons font-weight-lighter materialIcons">lock</i></div>
                                <div>{{ __('Password') }}</div>
                            </div>

                            <div class="col-lg-8">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                            </div>
                        </div>
                        @error('password')
                        <span class="form-group row invalid-feedback errorMessage mt-lg-n2 ml-lg-n3 ml-1" role="alert">
                                <strong class="offset-lg-4 col-lg-8 p-0">{{ $message }}</strong>
                            </span>
                        @enderror

                        <div class="form-group row">
                            <div class="row col-lg-4 align-items-center">
                                <div class="mr-2 ml-3"><i class="material-icons font-weight-lighter materialIcons">lock</i></div>
                                <div>{{ __('Confirm Password') }}</div>
                            </div>
                            <div class="col-lg-8">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-lg-6 offset-lg-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Reset Password') }}
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
