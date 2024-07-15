<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        body {
            background-color: #4E54C8 !important;
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .btn-custom {
            background-color: white !important;
            border: 1px solid #4E54C8 !important;
            color: #4E54C8 !important;
            border-radius: 120px !important;
            padding: 4px 16px !important;
            width: 70px !important;
            height: 28px !important;
            font-weight: 600 !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            text-decoration: none !important;
            font-size: 14px !important;
        }

        .card-portal {
            background-color: rgba(255, 255, 255, 0.4) !important;
            border: none;
            border-radius: 50px !important;
            padding: 32px 20px !important;
            padding-top: 10px;
            padding-bottom: 10px;
            margin-bottom: 30px;
            width: 460px;
            height: 467px;
        }

        .card-list-apps {
            background-color: rgba(255, 255, 255, 0.4) !important;
            border: none;
            border-radius: 12px !important;
        }

        .card-list-apps .card-body{
            height: 170px !important;
        }

        .card-container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            width: 100%;
            height: 100%;
            padding-top: 60px;
            box-sizing: border-box;
        }

        .app-image {
            width: 110px;
            height: 110px;
        }

        input[type="checkbox"]{
            background: cyan;
        }

        .btn-login{
            width: 103px !important;
            height: 42px !important;
            border-radius: 24px !important;
            padding: 6px 12px !important;
            background-color: #ffffff !important;
            color: #4E54C8 !important;
            border: none;
        }

    </style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap/bootstrap.min.css') }}">
</head>
<body>
    <nav class="navbar" id="navbar">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="{{ asset('img/logo/logo-puninar.png') }}" alt="Logo" class="d-inline-block align-text-top">
            </a>
            <a href="{{ url('/') }}" class="btn btn-custom" style="color: #4E54C8 !important;">
                Home
            </a>
        </div>
    </nav>
    <div class="card-container">
        <div class="row">
            <div class="card card-portal">
                <div class="card-header border-0" style="background-color: transparent;padding-bottom:0px !important;">
                    <h1 class="card-title" style="color: white;font-size:32px;font-weight: 700;line-height: 38.73px;text-align: center;">
                        PUNINAR PORTAL APP
                    </h1>
                    <p class="card-text" style="color: #623DE6;font-size: 16px;font-weight: 600;line-height: 19.36px;text-align: center;margin-top: -10px;">
                        Bridging Apps, Building Futures
                    </p>
                </div>
                <hr style="border: 1px solid #7A7F8B !important;width:109.5%!important;margin-left:-20px;">
                <div class="card-body" style="margin-top: -20px !important;margin-bottom: 40px !important;">
                    <form action="">
                        <input type="text" class="form-control" name="username" placeholder="Username | NIK | Email" style="height: 56px !important;width:380px !important;border-radius:20px !important;">
                        <br>
                        <div class="input-group" style="position: relative;">
                            <input type="password" name="password" id="passwordInput" placeholder="Password" style="height: 56px !important;width:380px !important;border-radius:20px !important;border:0px solid !important;padding-left: 20px !important;">
                            <div class="input-group-append" style="position: absolute; right: 0; top: 0; bottom: 0; display: flex; align-items: center;">
                                <span class="input-group-text toggle-password" style="cursor: pointer; background-color: transparent; border: none; padding: 0;" onclick="togglePassword()">
                                    <img id="eyeIcon" src="{{ asset('img/logo/eye-close.png') }}" alt="Show Password" style="height: 20px; width: auto;margin-left:-30px !important;">
                                </span>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-8">
                                <div class="icheck-primary">
                                    <input type="checkbox" id="remember" style="width: 20px !important; height: 20px !important; background-color: transparent !important; border: 1px solid black !important;">
                                    <label for="remember" style="vertical-align: middle;">
                                        Remember Password
                                    </label>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-8">
                                <a href="#" style="color: black;">
                                    <u>Forgot Password?</u>
                                </a>
                            </div>
                            <div class="col-4">
                                <button type="submit" class="btn btn-login">
                                    <img src="{{ asset('img/logo/login.png') }}">
                                    Log In
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <hr style="border: 1px solid #7A7F8B !important;width:109.5%!important;margin-left:-20px;margin-top: -40px !important;">
                <div class="card-footer border-0" style="background-color: transparent;">
                    <p style="text-align: center;font-size:12px !important;font-weight:400 !important;line-height:14.52px !important;margin-top: -8px !important;">
                        Copyright &copy; Puninar Logistics 2024
                    </p>
                </div>
            </div>
        </div>
    </div>
    <script>

        function togglePassword() {
            var passwordInput       = document.getElementById("passwordInput");
            var eyeIcon             = document.getElementById("eyeIcon");
            const togglePasswordBtn = document.querySelector('.toggle-password');
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);

            if (type === 'password') {
                togglePasswordBtn.innerHTML = '<img src="{{ asset('img/logo/eye-close.png') }}" alt="" width="20" height="20" style="margin-left:-30px">';
            } else {
                togglePasswordBtn.innerHTML = '<img src="{{ asset('img/logo/eye-open.png') }}" alt="" width="22" height="15" style="margin-bottom:3px;margin-left:-30px">';
            }
        }

    </script>
</body>
</html>
