<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('portal/css/styles_custom_login.css') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
</head>
<body>
    <nav class="navbar bg-body-tertiary" id="navbar">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="{{ asset('img/logo/logo-puninar.png') }}" alt="Logo" class="d-inline-block align-text-top">
            </a>
            <a href="{{ url('/') }}" class="btn btn-custom" style="color: #4E54C8 !important;">
                Home
            </a>
        </div>
    </nav>
    <ul class="circles">
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
    </ul>
    <div class="card-container">
        <div class="row">
            <div class="card card-portal">
                <div class="card-header" style="padding-top: 25px !important;padding-bottom: 20px !important;">
                    <h1 class="card-title text-header">
                        PUNINAR PORTAL APP
                    </h1>
                    <p class="card-text text-sub-header">
                        Bridging Apps, Building Futures
                    </p>
                </div>
                <div class="card-body" style="padding:24px !important;">
                    <form method="POST" action="{{ route('login') }}" class="mt-3">
                        @csrf
                        <div class="form-input-login">
                            <input type="text" class="form-control" id="username" name="username" placeholder="Username | NIK | Email" style="height: 56px !important; !important;border-radius:20px !important;" value="<?= isset($_COOKIE['username']) ? $_COOKIE['username'] : ''; ?>">
                            @if ($errors->has('username'))
                                <div class="error-message">
                                    {{ $errors->first('username') }}
                                </div>
                            @endif
                        </div>
                        <br>
                        <div class="input-group position-relative form-input-login">
                            <input type="password" name="password" id="password" placeholder="Password" style="height: 56px !important; width: 100%; border-radius: 20px !important; border: 0px solid !important; padding-left: 16px !important; padding-right: 48px !important; box-sizing: border-box;" value="<?= isset($_COOKIE['password']) ? $_COOKIE['password'] : ''; ?>">
                            <div class="input-group-append" style="position: absolute; right: 16px; top: 0; bottom: 0; display: flex; align-items: center;">
                                <span class="input-group-text toggle-password" style="cursor: pointer; background-color: transparent; border: none; padding: 0;" onclick="togglePassword()">
                                    <i class="nav-icon material-symbols-rounded" style="font-size: 22px !important; color: #2E308A;">visibility_off</i>
                                </span>
                            </div>
                        </div>

                        @if ($errors->has('password'))
                            <div class="error-message">
                                {{ $errors->first('password') }}
                            </div>
                        @endif
                        <br>
                        <div class="row">
                            <div class="col-8">
                                <div class="icheck-primary">
                                    <input type="checkbox" name="remember" id="remember" style="width: 20px !important; height: 20px !important; background-color: transparent !important; border: 1px solid black !important;" >
                                    <label for="remember" style="vertical-align: middle;">
                                        Remember Password
                                    </label>
                                </div>
                            </div>
                            <div class="col-4">
                                <button type="submit" class="btn btn-login" id="login-button">
                                    <span id="login-text" style="display: flex; align-items: center;">
                                        <i class="nav-icon material-symbols-rounded" style="font-size: 22px!important; color: #2E308A; margin-right: 8px;">login</i>
                                        Log In
                                    </span>
                                    <span id="login-spinner" style="display: none;">
                                        <div class="spinner-border spinner-border-sm" role="status">
                                            <i class="fas fa-spinner fa-spin"></i>
                                        </div>
                                    </span>
                                </button>
                            </div>
                        </div>
                        <br>
                    </form>
                </div>
                <div class="card-footer">
                    <p>
                        Copyright &copy; Puninar Logistics 2024
                    </p>
                </div>
            </div>
        </div>
    </div>
    <script>
        const usernameInput = document.getElementById('username');
        const passwordInput = document.getElementById('password');
        const rememberCheckbox = document.getElementById('remember');

        window.addEventListener('load', () => {
            const navbar = document.querySelector('.navbar');
            setTimeout(() => {
                navbar.classList.add('show');
            }, 200);
        });

        function togglePassword() {
            var passwordInput = document.getElementById('password');
            var icon = document.querySelector('.toggle-password i');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.textContent = 'visibility';
            } else {
                passwordInput.type = 'password';
                icon.textContent = 'visibility_off';
            }
        }

        document.addEventListener("DOMContentLoaded", function() {
            var navbar              = document.getElementById('navbar');
            var rememberCheckbox    = document.getElementById('remember');
            var usernameInput       = document.getElementById('username');
            var passwordInput       = document.getElementById('password');

            const loginBtn = document.getElementById('login-button');
            $('#login-button').click(function() {
                $('#login-text').hide();
                $('#login-spinner').show();
            });
        });

    </script>
</body>
</html>
