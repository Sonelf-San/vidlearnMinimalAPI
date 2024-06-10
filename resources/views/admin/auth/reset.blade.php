<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>Se connecter | Back-office Admin | Vidlearn</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/img/favicon.png') }}">

    <!-- App css -->
    <link href="{{ asset('admin_assets/css/bootstrap.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('admin_assets/css/app.min.css') }}" rel="stylesheet"/>

    <!-- icons -->
    <link href="{{ asset('admin_assets/css/icons.min.css') }}" rel="stylesheet" type="text/css"/>

</head>

<body class="auth-fluid-pages pb-0">

<div class="auth-fluid">
    <!--Auth fluid left content -->
    <div class="auth-fluid-form-box">
        <div class="align-items-center d-flex h-100">
            <div class="card-body">

                <!-- Logo -->
                <div class="auth-brand text-center text-lg-left">
                    <div class="auth-logo">
                        <a href="{{ route('index') }}" class="logo text-center">
                            <span class="logo-lg">
                                <img src="{{ asset('assets/img/logo.png') }}" alt="" height="32">
                            </span>
                        </a>
                    </div>
                </div>

                <!-- title-->
                <h4 class="mt-0">Réinitialiser le mot de passe</h4>
                @include('admin.layouts.alerts')
                <p class="text-muted mb-4">Saisissez votre adresse e-mail et votre mot de passe pour accéder à votre
                    back-office administrateur.</p>

                <!-- form -->
                <form action="{{ route('admin.password.reset', $token) }}" method="POST">
                    @csrf
                    <input type="hidden" name="token" value="{{$token}}">
                    <div class="form-group">
                        <label for="emailaddress">Email</label>
                        <input class="form-control @error('email') is-invalid @enderror" type="email"
                               id="emailaddress" required=""
                               value="{{ old('email') }}"
                               name="email"
                               autofocus
                               placeholder="Entrer votre Email">
                        @error('email')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">

                        <label for="password">Mot de passe</label>
                        <div class="input-group input-group-merge">
                            <input type="password" id="password"
                                   name="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   placeholder="Entrer votre Mot de passe">
                            <div class="input-group-append" data-password="false">
                                <div class="input-group-text">
                                    <span class="password-eye"></span>
                                </div>
                            </div>
                        </div>
                        @error('password')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror

                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">Confirmez le mot de passe</label>
                        <div class="input-group input-group-merge">
                            <input type="password" id="password_confirmation"
                                   name="password_confirmation"
                                   class="form-control @error('password_confirmation') is-invalid @enderror"
                                   placeholder="Confirmez le mot de passe">
                            <div class="input-group-append" data-password="false">
                                <div class="input-group-text">
                                    <span class="password-eye"></span>
                                </div>
                            </div>
                        </div>
                        @error('password')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror

                    </div>

                    <div class="form-group mb-0 text-center">
                        <button class="btn btn-primary btn-block" type="submit">Soumettre</button>
                    </div>
                </form>
                <!-- end form-->

                <!-- Footer-->
                <footer class="footer footer-alt">
                    <p class="text-muted">Pas un administrateur?
                        <a href="{{ route('index') }}" class="text-muted ml-1"><b>retour d'accueil</b></a></p>
                </footer>

            </div> <!-- end .card-body -->
        </div> <!-- end .align-items-center.d-flex.h-100-->
    </div>
    <!-- end auth-fluid-form-box-->

    <!-- Auth fluid right content -->
    <div class="auth-fluid-right text-center">
        <div class="auth-user-testimonial">
            <h2 class="mb-3 text-white">Back-office Administrateur</h2>
            <p class="lead"><i class="mdi mdi-format-quote-open"></i> Lorem ipsum dolor sit amet, consectetur adipiscing
                elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis
                nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in
                reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
            </p>
        </div> <!-- end auth-user-testimonial-->
    </div>
    <!-- end Auth fluid right content -->
</div>
<!-- end auth-fluid-->

<!-- Vendor js -->
<script src="{{ asset('admin_assets/js/vendor.min.js') }}"></script>

<!-- App js -->
<script src="{{ asset('admin_assets/js/app.min.js') }}"></script>

</body>
</html>
