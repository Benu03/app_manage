<div>
    <style>
        #viewPage {
            background-color: #EFF0F5 !important;
        }

        .small-box {
            background-color: white !important;
            border: 1px solid #4053EE !important;
            border-radius: 6px !important;
            padding: 20px !important;
            width: 100%;
            height: auto !important;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .box-dashboard {
            margin-bottom: 20px !important;
            cursor: pointer;
        }

        .box-dashboard p {
            color: #4053EE;
            font-size: 18px !important;
            font-weight: 600;
        }

        .box-dashboard h3 {
            color: #4053EE !important;
            font-size: 24px !important;
            font-weight: 700;
        }

        .icon {
            color: #4053EE !important;
        }

        @media (max-width: 576px) {
            .box-dashboard h3 {
                font-size: 20px !important;
            }
            .box-dashboard p {
                font-size: 16px !important;
            }
            .small-box {
                flex-direction: column;
                text-align: center;
            }
            .small-box img {
                margin: 10px 0 !important;
            }
        }

        .small-box img {
            max-width: 50%;
            height: auto;
        }
    </style>
    <div class="container-fluid">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-9">
                    <label class="text-dark text-lg" style="font-weight: 600;font-size:20px !important;">
                        {{ $data['page_title'] }}
                    </label>
                </div>
            </div>
            {{-- <div class="row">
                <div class="col-lg-2 col-md-3 col-sm-6 col-12 box-dashboard" wire:click="redirectUrl('users-url')">
                    <div class="small-box">
                        <div>
                            <p style="margin-bottom: 0px;">Users</p>
                            <h3>{{ $data['users'] }}</h3>
                        </div>
                        <img src="{{ asset('img/dashboard-img/Users.png') }}" alt="">
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-6 col-12 box-dashboard" wire:click="redirectUrl('roles-url')">
                    <div class="small-box">
                        <div>
                            <p style="margin-bottom: 0px;">Roles</p>
                            <h3>{{ $data['roles'] }}</h3>
                        </div>
                        <img src="{{ asset('img/dashboard-img/Roles.png') }}" alt="">
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-6 col-12 box-dashboard" wire:click="redirectUrl('modules-url')">
                    <div class="small-box">
                        <div>
                            <p style="margin-bottom: 0px;">Modules</p>
                            <h3>{{ $data['modules'] }}</h3>
                        </div>
                        <img src="{{ asset('img/dashboard-img/Modules.png') }}" alt="">
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-6 col-12 box-dashboard" wire:click="redirectUrl('mobile-url')">
                    <div class="small-box">
                        <div>
                            <p style="margin-bottom: 0px;">Mobile Apps</p>
                            <h3>{{ $data['mobile_apps'] }}</h3>
                        </div>
                        <img src="{{ asset('img/dashboard-img/Apps.png') }}" alt="">
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-6 col-12 box-dashboard" wire:click="redirectUrl('web-url')">
                    <div class="small-box">
                        <div>
                            <p style="margin-bottom: 0px;">Web Apps</p>
                            <h3>{{ $data['web_apps'] }}</h3>
                        </div>
                        <img src="{{ asset('img/dashboard-img/web-apps.png') }}" alt="">
                    </div>
                </div>
            </div> --}}
            <div class="row">
                <div class="col-lg-2 col-md-3 col-sm-6 col-12 box-dashboard">
                    <a href="{{ route('users.index') }}" class="small-box">
                        <div>
                            <p style="margin-bottom: 0px;">Users</p>
                            <h3>{{ $data['users'] }}</h3>
                        </div>
                        <img src="{{ asset('img/dashboard-img/Users.png') }}" alt="">
                    </a>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-6 col-12 box-dashboard">
                    <a href="{{ route('roles.index') }}" class="small-box">
                        <div>
                            <p style="margin-bottom: 0px;">Roles</p>
                            <h3>{{ $data['roles'] }}</h3>
                        </div>
                        <img src="{{ asset('img/dashboard-img/Roles.png') }}" alt="">
                    </a>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-6 col-12 box-dashboard">
                    <a href="{{ route('modules.index') }}" class="small-box">
                        <div>
                            <p style="margin-bottom: 0px;">Modules</p>
                            <h3>{{ $data['modules'] }}</h3>
                        </div>
                        <img src="{{ asset('img/dashboard-img/Modules.png') }}" alt="">
                    </a>
                </div>

            </div>
            
        </div>
    </div>
</div>
