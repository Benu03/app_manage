<div>
    <div class="card-container">
        <div class="row">
            <div class="card card-portal">
                <div class="card-header" style="padding-top: 25px !important;padding-bottom: 20px !important;">
                    <h1 class="card-title" style="color: white;font-size:32px;font-weight: 700;line-height: 38.73px;text-align: center;">
                        PUNINAR PORTAL APP
                    </h1>
                    <p class="card-text" style="color: #623DE6;font-size: 16px;font-weight: 600;line-height: 19.36px;text-align: center;margin-top: -10px;">
                        Bridging Apps, Building Futures
                    </p>
                </div>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="card-body" style="padding:24px !important;">
                    <form method="POST" action="{{ route('login') }}" class="mt-3">
                        @csrf
                        <div>
                            <input type="text" class="form-control" id="username" name="username" placeholder="Username | NIK | Email" style="height: 56px !important;width:412px !important;border-radius:20px !important;">
                            @if ($errors->has('username'))
                                <div>
                                    <font color="yellow">
                                        {{ $errors->first('username') }}
                                    </font>
                                </div>
                            @endif
                        </div>
                        <br>
                        <div class="input-group" style="position: relative;">
                            <input type="password" name="password" id="password" placeholder="Password" style="height: 56px !important;width:412px !important;border-radius:20px !important;border:0px solid !important;padding-left: 24px !important;">
                            <div class="input-group-append" style="position: absolute; right: 0; top: 0; bottom: 0; display: flex; align-items: center;">
                                <span class="input-group-text toggle-password" style="cursor: pointer; background-color: transparent; border: none; padding: 0;" onclick="togglePassword()">
                                    <img id="eyeIcon" src="{{ asset('img/logo/eye-close.png') }}" alt="Show Password" style="margin-left:-30px !important;">
                                </span>
                            </div>
                        </div>
                        @if ($errors->has('password'))
                            <div>
                                <font color="yellow">
                                    {{ $errors->first('username') }}
                                </font>
                            </div>
                        @endif
                        <br>
                        <div class="row">
                            <div class="col-8">
                                <div class="icheck-primary">
                                    <input type="checkbox" wire:model.defer="remember" name="remember" id="remember" style="width: 20px !important; height: 20px !important; background-color: transparent !important; border: 1px solid black !important;">
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
                                <button type="submit" class="btn btn-login" id="login-button">
                                    <span id="login-text">
                                        <img src="{{ asset('img/logo/login.png') }}" alt="Login Icon">
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
        function togglePassword() {
            var passwordInput       = document.getElementById("password");
            var eyeIcon             = document.getElementById("eyeIcon");
            const togglePasswordBtn = document.querySelector('.toggle-password');
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);

            if (type === 'password') {
                togglePasswordBtn.innerHTML = '<img src="{{ asset('img/logo/eye-close.png') }}" style="margin-left:-30px">';
            } else {
                togglePasswordBtn.innerHTML = '<img src="{{ asset('img/logo/eye-open.png') }}" style="margin-bottom:3px;margin-left:-30px">';
            }
        }

        document.addEventListener("DOMContentLoaded", function() {
            var navbar = document.getElementById('navbar');
            navbar.classList.add('show');

            const loginBtn = document.getElementById('login-button');
            $('#login-button').click(function() {
                $('#login-text').hide();
                $('#login-spinner').show();
            });
        });

    </script>
</div>
