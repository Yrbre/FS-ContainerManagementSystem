<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>{{ config('app.name') }}</title>
    <link href="{{ asset('css/console.css') }}" rel="stylesheet">
</head>
<body>
    <div class="bg-light min-vh-100 d-flex flex-row align-items-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-4">
                    <div class="text-center mb-2">
                        <img src="{{ asset('assets/img/logo.png') }}" class="img-fluid" width="150"/>
                    </div>
                    <div class="card-group d-block d-md-flex row">
                        <div class="card col-md-12 p-4 mb-0">
                            <div class="card-body">
                                @include('console.user.partials.alert')

                                <form method="POST" action="{{ route('console.auth.login') }}">
                                    @csrf

                                    <h1>Login</h1>
                                    <p class="text-medium-emphasis">Sign In to your account</p>
                                    <div class="input-group mb-3">
                                        <input name="username" class="form-control @error('username') is-invalid @enderror"
                                            type="text" placeholder="Username">
                                        @error('username')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="input-group mb-4">
                                        <input name="password"
                                            class="form-control @error('password') is-invalid @enderror" type="password"
                                            placeholder="Password">
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="row">
                                        <div class="col-6">
                                            <button class="btn btn-primary px-4" type="submit" type="button">Login</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
