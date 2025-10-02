@extends('layout.authlayout')
@section('content')
    <div class="account-content">
        <div class="login-wrapper login-new">
            <div class="container">
                <div class="login-content user-login">
                    <div class="login-logo">
                        <img src="{{ URL::asset('/build/img/logo.png') }}" alt="img">
                        <a href="{{ url('index') }}" class="login-logo logo-white">
                            <img src="{{ URL::asset('/build/img/logo-white.png') }}" alt="">
                        </a>
                    </div>
                    <form method="POST" action="{{ route('login.post') }}">
                         @csrf
                        <div class="login-userset">
                            <div class="login-userheading">
                                <h3>Login</h3>
                            </div>
                            <div class="form-login">
                                <label class="form-label">Username</label>
                                <div class="form-addons">
                                    <input type="text" class="form-control @error('username') is-invalid @enderror"
                                        name="username" value="{{ old('username') }}" required>
                                    @error('username')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-login">
                                <label>Password</label>
                                <div class="pass-group">
                                    <input type="password" class="pass-input @error('password') is-invalid @enderror"
                                        name="password" required>
                                    <span class="fas toggle-password fa-eye-slash"></span>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <!-- Error session (username/password salah) -->
                            @if(session('error'))
                                <div class="alert alert-danger mt-2">
                                    {{ session('error') }}
                                </div>
                            @endif
                            <div class="form-login">
                                <button class="btn btn-login" type="submit">Login</button>
                            </div>
                            <div class="form-sociallink">
                                <ul class="d-flex">
                                    <li>
                                        <a href="javascript:void(0);" class="facebook-logo">
                                            <img src="{{ URL::asset('/build/img/icons/facebook-logo.svg') }}"
                                                alt="Facebook">
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <img src="{{ URL::asset('/build/img/icons/google.png') }}" alt="Google">
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="apple-logo">
                                            <img src="{{ URL::asset('/build/img/icons/apple-logo.svg') }}" alt="Apple">
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
