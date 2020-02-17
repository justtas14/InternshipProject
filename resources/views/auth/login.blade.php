<div class="background__overlay" onclick="toggleLogin()"></div>
<div id="loginCard" class="card customCard">
    <div class="authCloseContainer" onclick="toggleLogin()">
        <i class="material-icons authClose">
            close
        </i>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group row">
                <label for="email" class="col-12 col-form-label">
                    <div class="row">
                        <div class="mr-2 ml-3"><i class="material-icons font-weight-lighter materialIcons">email</i></div>
                        <div>{{ __('E-Mail Address') }}</div>
                    </div>
                </label>
                <div class="col-12">
                    <input id="loginEmail" type="email" class="form-control @error('loginEmail') is-invalid @enderror" name="loginEmail" value="{{ old('loginEmail') }}" required autocomplete="email" autofocus>

                    @error('loginEmail')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="password" class="col-12 col-form-label">
                    <div class="row">
                        <div class="mr-2 ml-3"><i class="material-icons font-weight-lighter materialIcons">lock</i></div>
                        <div>{{ __('Password') }}</div>
                    </div>
                </label>
                <div class="col-12">
                    <input id="loginPassword" type="password" class="form-control @error('loginPassword') is-invalid @enderror" name="loginPassword" required autocomplete="current-password">

                    @error('loginPassword')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row mb-4">
                <div class="col-12">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember">
                            {{ __('Remember Me') }}
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-12 mb-4 text-center">
                    <button type="submit" class="btn btn-primary container-fluid">
                        {{ __('Login') }}
                    </button>
                </div>
                <div class="col-12 text-center">
                    @if (Route::has('password.request'))
                        <a class="btn btn-link" href="{{ route('password.request') }}">
                            {{ __('Forgot Your Password?') }}
                        </a>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    window.addEventListener('load', () => {
        var hasErrors = {{ $errors->has('loginEmail') || $errors->has('loginPassword') }}
            console.log(hasErrors);
        toggleLogin(hasErrors);
    });
</script>
