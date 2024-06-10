<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>Login | Back-office Admin | Vidlearn</title>
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
                                <img src="{{ asset('assets/logo.png') }}" alt="" height="32">
                            </span>
                        </a>
                    </div>
                </div>

                <!-- title-->
                <h4 class="mt-0">Back-office Admin - Vidlearn</h4>
                @include('admin.layouts.alerts')
                <p class="text-muted mb-4">Enter your email address and your password to access your back-office admin.</p>

                <!-- form -->
                <form action="{{ route('admin.login') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="emailaddress">Email</label>
                        <input class="form-control @error('email') is-invalid @enderror" type="email"
                               id="emailaddress" required=""
                               value="{{ old('email') }}"
                               name="email"
                               autofocus
                               placeholder="Enter your Email">
                        @error('email')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <a href="{{route('admin.password.request')}}" class="text-muted float-right">
                            <small>Forgot password?</small>
                        </a>

                        <label for="password">Password</label>
                        <div class="input-group input-group-merge">
                            <input type="password" id="password"
                                   name="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   placeholder="Enter your password">
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

                    <div class="form-group mb-3">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="checkbox-signin">
                            <label class="custom-control-label" for="checkbox-signin">Remember me</label>
                        </div>
                    </div>
                    <div class="form-group mb-0 text-center">
                        <button class="btn btn-primary btn-block" type="submit">Submit</button>
                    </div>
                </form>
                <!-- end form-->

                <!-- Footer-->
                <footer class="footer footer-alt">
                    <p class="text-muted">Not an Admin?
                        <a href="{{ route('index') }}" class="text-muted ml-1"><b>back to home</b></a></p>
                </footer>

            </div> <!-- end .card-body -->
        </div> <!-- end .align-items-center.d-flex.h-100-->
    </div>
    <!-- end auth-fluid-form-box-->

    <!-- Auth fluid right content -->
    <div class="auth-fluid-right text-center">
        <p class="lead" style="color:darkorange; font-weight: bold;"> @credit-picture Marc Robitaille - Université Laval.</p>

        <div class="auth-user-testimonial">
            <h2 class="mb-3 text-white">Back-office Admin - Vidlearn</h2>
            <p class="lead" style="color:darkorange; font-weight: bold;"> &copy; Vidlearn. <br>All rights reserved <script>document.write(new Date().getFullYear())</script>.
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
