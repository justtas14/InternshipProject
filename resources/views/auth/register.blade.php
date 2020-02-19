@extends('layouts.app')

@section('content')
<div class="container mainContainer toggleContainer">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card customCard">
                <div class="card-body">
                    <div class="container text-center registerTitle mb-4">
                        Registration
                    </div>
                    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row mt-lg-4">
                            <div class="row col-lg-5 align-items-center">
                                <div class="mr-2 ml-3"><i class="material-icons font-weight-lighter materialIcons">portrait</i></div>
                                <div>{{ __('Name') }}</div>
                            </div>

                            <div class="col-lg-7">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                            </div>
                        </div>
                        @error('name')
                        <span class="form-group row invalid-feedback errorMessage mt-lg-n2 ml-lg-n3 ml-1" role="alert">
                                <strong class="offset-lg-5 col-lg-7 p-0">{{ $message }}</strong>
                            </span>
                        @enderror
                        <div class="form-group row">
                        <div class="row col-lg-5 align-items-center">
                            <div class="mr-2 ml-3"><i class="material-icons font-weight-lighter materialIcons">email</i></div>
                            <div>{{ __('E-Mail Address') }}</div>
                        </div>
{{--                            <i class="material-icons font-weight-lighter materialIcons">email</i>--}}
{{--                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>--}}

                            <div class="col-lg-7">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                            </div>
                        </div>
                        @error('email')
                        <span class="form-group row invalid-feedback errorMessage mt-lg-n2 ml-lg-n3 ml-1" role="alert">
                                <strong class="offset-lg-5 col-lg-7 p-0">{{ $message }}</strong>
                            </span>
                        @enderror

                        <div class="form-group row">
                            <div class="row col-lg-5 align-items-center">
                                <div class="mr-2 ml-3"><i class="material-icons font-weight-lighter materialIcons">lock</i></div>
                                <div>{{ __('Password') }}</div>
                            </div>

                            <div class="col-lg-7">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                            </div>
                        </div>
                        @error('password')
                            <span class="form-group row invalid-feedback errorMessage mt-lg-n2 ml-lg-n3 ml-1" role="alert">
                                <strong class="offset-lg-5 col-lg-7 p-0">{{ $message }}</strong>
                            </span>
                        @enderror

                        <div class="form-group row">
                            <div class="row col-lg-5 align-items-center">
                                <div class="mr-2 ml-3"><i class="material-icons font-weight-lighter materialIcons">lock</i></div>
                                <div>{{ __('Confirm Password') }}</div>
                            </div>

                            <div class="col-lg-7">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>
                        <div class="form-group row mb-0 mt-4 align-items-center">
                            <div class="col-lg-5 text-lg-right">
                                <div class="mt-lg-0 mt-3 text-center">
                                    Upload profile picture:
                                </div>
                            </div>
                            <div class="col-lg-7 text-center">
                                <div class="circle m-lg-0 m-auto" onclick="selectFile()">
                                    <img class="profile-pic @error('profile_picture') is-invalid-picture @enderror" src="{{ asset('storage/images/profile/default.png') }}">
                                    <div class="p-image">
                                        <i class="material-icons upload-button">add_a_photo</i>
                                        <input onchange="readUrl(this)" class="file-upload" type="file" name="profile_picture" accept="image/*"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @error('profile_picture')
                        <span class="form-group row invalid-feedback errorMessage text-lg-left text-center m-l-1 m-0 mb-5" role="alert">
                            <strong class="offset-lg-5 col-lg-7 p-lg-0">{{ $message }}</strong>
                        </span>
                        @enderror
                        <div class="form-group row mb-0 mt-4">
                            <div class="col text-center">
                                <button type="submit" class="btn btn-primary registerSubmit">
                                    {{ __('Register') }}
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
