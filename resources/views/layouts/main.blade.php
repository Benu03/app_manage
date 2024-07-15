<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="cache-control" content="no-cache" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>{{ config('app.name', 'Laravel') }} - Main Page</title>
    @include('layouts.header')
    @stack('css')
    @livewireStyles

    <style>
        .navbar-time {
            font-size: 15px !important;
        }

        .clocktime {
            font-size: 15px !important;
        }


        .dropdown-menu-xl {
            max-width: 400px;
            min-width: 400px;
            padding: 0;
            padding-top: 0px;
            padding-right: 0px;
            padding-bottom: 0px;
            padding-left: 0px;
        }
    </style>

</head>

{{-- {{ request()->routeIs('/') ? 'sidebar-collapse' : '' }} --}}

<body class="hold-transition sidebar-mini layout-fixed sidebar-collapse"
    id="sidebarx">
    <div class="wrapper" style="background-color: #F2F2F2">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light text-sm"
            style="border-radius:0px !important;border-bottom-right-radius: 24px !important;">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button" id="fullscreen">
                        <i class="fas fa-bars"></i>
                    </a>
                </li>
            </ul>
            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link" id="role_name" data-toggle="dropdown" href="#" style="color: #2E308A !important;font-size:16px !important;font-weight:400;">
                        <i class="fa fa-user"></i> &nbsp;{{ Str::title(session()->get('modules')['role'] ?? 'Admin') }}
                        <span class="fas fa-chevron-down" style="padding-left:5px;"></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <span class="dropdown-item dropdown-header"> Hello <strong>
                            {{ ucwords(session()->get('user')['full_name'] ?? 'Admin') }}!
                            </strong></span>
                        <div class="dropdown-divider"></div>
                        <a class="nav-link loglog text-center"
                            onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();"
                            href="javascript:void(0);">
                            <i class="nav-icon fas fa-sign-out-alt"></i> Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->
        @include('layouts.sidebar')
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" id="viewPage">
            <div class="content-header py-2">
            </div>
           {{-- {{ $slot }} --}}
           @yield('content')
        </div>
        <!-- /.content-wrapper -->
        @livewireScripts
        @include('layouts.footer')
        @stack('js')
        @stack('js-custom')
        @yield('script')
    </div>
</body>
<script type="text/javascript">
    $(document).ready(function() {
        $('.arrow-icon').on('click', function() {
            let expandedIcon = $(this).data('expanded-icon');
            let collapsedIcon = $(this).data('collapsed-icon');
            let currentIcon = $(this).text();

            if (currentIcon === expandedIcon) {
                $(this).text(collapsedIcon);
            } else {
                $(this).text(expandedIcon);
            }

            let submenu = $(this).siblings('.nav-treeview');
            submenu.slideToggle();
        });

        $('.arrow-icon').each(function() {
            // Mengecek apakah URL pada elemen sesuai dengan URL saat ini
            if ($(this).attr('data-url') === window.location.href) {
                $(this).addClass('expanded-icon');
            }
        });
    });

    function formatDate(datex){
        let dateString = datex;
        let date = new Date(dateString);
        let monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
        var day = date.getDate();
        var monthIndex = date.getMonth();
        var year = date.getFullYear();

        var formattedDate = day + '-' + monthNames[monthIndex] + '-' + year + ' ' + ('0' + date.getHours()).slice(-2) + ':' + ('0' + date.getMinutes()).slice(-2);

        return formattedDate;
    }


</script>

</html>
