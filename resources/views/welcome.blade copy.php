<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('portal/css/styles_custom.css') }}">
    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
</head>

<body>
    <nav class="navbar bg-body-tertiary animate-left-to-right">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="{{ asset('img/logo/logo-puninar.png') }}" alt="Logo"
                    class="d-inline-block align-text-top">
            </a>
            <a href="{{ url('login') }}" class="btn btn-custom">
                Login
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
        <div class="row justify-content-between">
            <div class="card card-portal">
                <div class="card-body">
                    <h1 class="card-title" style="color: white;font-size:48px;font-weight: 700;line-height: 58.09px;">
                        PUNINAR PORTAL APP
                    </h1>
                    <p class="card-text"
                        style="color: #623DE6;font-size: 20px;font-weight: 600;line-height: 24.2px;text-align: center;margin-top: -10px;">
                        Bridging Apps, Building Futures
                    </p>
                </div>
            </div>
        </div>
        <div class="container mb-5">
            <div class="col-md-12">
                <div class="row d-flex justify-content-between align-items-center">
                    <div class="col-md-6 col-sm-12 d-flex justify-content-center justify-content-md-start  mb-3 mb-md-0">
                        <button id="web" class="btn btn-portal active me-2" onclick="getProjects('web')">
                            Web
                        </button>
                        <button id="mobile" class="btn btn-portal not-active ms-1" onclick="getProjects('mobile')">
                            Mobile
                        </button>
                    </div>
                    <div class="col-md-6 col-sm-12 col-xs-12 d-flex justify-content-center justify-content-md-end align-items-center search-container">
                        <div class="form-inline" style="width: 100%; max-width: 400px;">
                            <div class="input-group" data-widget="sidebar-search" style="width: 100%;">
                                <input id="searchInput" class="form-control" type="search" placeholder="Search projects" aria-label="Search">
                                <div class="input-group-append">
                                    <button class="btn btn-sidebar" style="border-top-right-radius: 20px; border-bottom-right-radius: 20px;">
                                        <img src="{{ asset('img/logo/search.png') }}" width="20" height="20" style="margin-top:-5px;">
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="col-md-12" style="padding-left: -20px !important;">
                <div class="row" id="appContainer"></div>
            </div>
        </div>
    </div>
    <div class="modal" tabindex="-1" role="dialog" id="showDetailModalWeb">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="margin-bottom: 0px;height:80px !important;">
                    <div class="img-container" id="imgShow">
                        <img src="{{ asset('img/portal-app/ASSEM.png') }}" alt="App Image" class="app-image">
                    </div>
                    <div class="text-container">
                        <h5 class="app-namex" id="appName">&nbsp;</h5>
                        <p class="app-description">About this app</p>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="font-size: 24px;">
                        <span aria-hidden="true" style="font-size: 30px !important;">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p id="desc" style="text-align:justify!important;">
                        &nbsp;
                    </p>
                </div>
                <div class="modal-footer d-flex justify-content-start">
                    <div class="w-100">
                        <p class="mb-0">Link</p>
                        <div id="link">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal" tabindex="-1" role="dialog" id="showDetailModalApp">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="margin-bottom: 0px;height:80px !important;">
                    <div class="img-container" id="imgShowx">
                        <img src="{{ asset('img/portal-app/ASSEM.png') }}" alt="App Image" class="app-image">
                    </div>
                    <div class="text-container">
                        <h5 class="app-namex" id="appNamex">&nbsp;</h5>
                        <p class="app-description">About this app</p>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="font-size: 24px;">
                        <span aria-hidden="true" style="font-size: 30px !important;">&times;</span>
                    </button>
                </div>
                <div class="modal-body mb-2">
                    <p id="descx" style="text-align:justify!important;">
                        &nbsp;
                    </p>
                    <p id="note" style="text-align:justify!important;">
                        &nbsp;
                    </p>
                    <hr>
                    <div class="w-100" id="developmentLinks"></div>
                    <div class="w-100" id="productionAndroidLinks"></div>
                    <div id="batasAndroidIos"></div>
                    <div class="w-100" id="productionIosLinks"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script>
        var searchInput = document.getElementById('searchInput');
        var appContainer = document.getElementById('appContainer');
        var appItems = appContainer.getElementsByClassName('app-item');


        $(document).ready(function() {
            var initialType = getQueryParam('type') || 'web';
            setActiveButton(initialType);
            getProjects(initialType);
        });

        function showDetail(id){
            let urlx      = new URL(window.location.href);
            let params    = new URLSearchParams(urlx.search);
            let type      = params.get('type');

            let status          = "{{ config('_static.app_env') }}";
            const divElement    = document.querySelector(`[data-id="${id}"]`);
            const app           = divElement.getAttribute('data-app');
            const imageUrl      = divElement.getAttribute('data-image-url');
            const urlDev        = divElement.getAttribute('data-url-dev');
            const urlProd       = divElement.getAttribute('data-url-prod');
            const desc          = divElement.getAttribute('data-description');

            let url             = status == 'development' ? urlDev : urlProd;
            let fullUrl         = url != 'null' ? `<a href="${url}" id="link" target="_blank">${url}</a>` : '-';
            let folder          = type == 'web' ? 'portal-app' : 'mobile-app';
            let fullDesc        = desc != 'null' ? desc : '-';

            $('#imgShow').html(`<img src="{{ asset('img/${folder}') }}${imageUrl}" alt="" style="border: 1px solid #D9D9D9;border-radius: 5.52px;" height="45" width="45">`);
            $('#appName').html(app);
            $('#desc').html(fullDesc);
            $('#link').html(fullUrl);

            $('#showDetailModalWeb').modal({
                backdrop: 'static',
                keyboard: false
            });
        }

        function showDetailApp(id){
            let urlx      = new URL(window.location.href);
            let params    = new URLSearchParams(urlx.search);
            let type      = params.get('type');
            let status    = "{{ config('_static.app_env') }}";
            const divElement    = document.querySelector(`[data-id="${id}"]`);
            const app     = divElement.getAttribute('data-app');
            const image   = divElement.getAttribute('data-image-url');
            const desc    = divElement.getAttribute('data-description');
            const note    = divElement.getAttribute('data-note');

            let fullDesc  = desc != 'null' ? desc : '-';
            let fullNote  = note != 'null' ? note : '-';

            let link = '';

            $.ajax({
                type: "GET",
                url: "{{ route('get_detail_app') }}",
                data: {
                    id:id
                },
                success: function (response) {
                    console.log(response);
                    $('#imgShowx').html(`<img src="{{ asset('img/mobile-app') }}${image}" alt="" style="border: 1px solid #D9D9D9;border-radius: 5.52px;" height="45" width="45">`);
                    $('#appNamex').html(app);
                    $('#descx').html(fullDesc);
                    $('#note').html(`Note : ${fullNote}`);
                    let link = `<h5 style="font-weight:700;font-size:14px;color:#212529;" >Development</h5>`;
                    if(status == 'development'){
                        if (response.dataDev.length > 0) {
                            $.each(response.dataDev, function(index, dev) {
                                link += `Version ${dev.version}<br>`;
                                link += `<a href="${dev.url}" id="link" target="_blank">${dev.url}</a><br><br>`;
                            });
                        }else{
                            link += '-';
                        }
                        $('#developmentLinks').html(link);
                        $('#productionAndroidLinks').empty();
                        $('#productionIosLinks').empty();
                    }else{
                        let prodAndroidLinks = `<h5 style="font-weight:700;font-size:14px;color:#212529;">Production (Android)</h5>`;
                        if (response.dataProdAndro.length > 0) {
                            $.each(response.dataProdAndro, function(index, android) {
                                prodAndroidLinks += `<a href="${android.prod_url}" id="link" target="_blank">${android.prod_url}</a><br><br>`;
                            });
                        }else{
                            prodAndroidLinks += '-';
                        }
                        $('#productionAndroidLinks').html(prodAndroidLinks);
                        $('#batasAndroidIos').html('<hr>');
                        let prodIosLinks = `<h5 style="font-weight:700;font-size:14px;color:#212529;">Production (IOS)</h5>`;
                        if (response.dataProdIos.length > 0) {
                            $.each(response.dataProdIos, function(index, ios) {
                                prodIosLinks += `<a href="${ios.prod_url}" id="link" target="_blank" class="mb-2">${ios.prod_url}</a><br><br>`;
                            });
                        }else{
                            prodIosLinks += '-';
                        }
                        $('#productionIosLinks').html(prodIosLinks);

                        $('#developmentLinks').empty();
                    }

                    $('#showDetailModalApp').modal({
                        backdrop: 'static',
                        keyboard: false
                    });
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            searchInput.addEventListener('input', function() {
                var filter = searchInput.value.toLowerCase();
                for (var i = 0; i < appItems.length; i++) {
                    var appItem = appItems[i];
                    var appName = appItem.getAttribute('data-app').toLowerCase();
                    if (appName.includes(filter)) {
                        appItem.style.display = '';
                    } else {
                        appItem.style.display = 'none';
                    }
                }
            });
        });


        function getProjects(type = null)
        {
            const url = new URL(window.location);
            url.searchParams.set('type', type);
            window.history.pushState({}, '', url);
            setActiveButton(type);

            $.ajax({
                type: "GET",
                url: "{{ route('get_projects') }}",
                data: {
                    type: type
                },
                success: function (response) {
                    renderProjects(response.data, type);
                }
            });
        }

        function renderProjects(data, type) {
            $('#appContainer').empty();
            appContainer.innerHTML = '';
            let path = '';
            if(type == 'mobile'){
                path = 'mobile-app';
            }else if(type == 'web'){
                path = 'portal-app';
            }

            data.forEach(function (item) {
                var appItem = document.createElement('div');
                appItem.className = 'col-6 col-sm-6 col-md-3 col-lg-2 mb-4 app-item slide-out';

                if(type == 'web'){
                    appItem.setAttribute('onclick', 'showDetail(' + item.id + ')');
                }else if(type == 'mobile'){
                    appItem.setAttribute('onclick', 'showDetailApp(' + item.id + ')');
                }

                appItem.setAttribute('style', 'cursor:pointer;');
                appItem.setAttribute('data-id', item.id);
                appItem.setAttribute('data-app', item.app);
                appItem.setAttribute('data-image-url', item.image_url);
                appItem.setAttribute('data-url-prod', item.prod_url);
                appItem.setAttribute('data-url-dev', item.dev_url);
                appItem.setAttribute('data-description', item.description);
                if(type == 'mobile'){
                    appItem.setAttribute('data-note', item.note);
                }
                appItem.innerHTML = `
                    <div class="card card-list-apps h-100">
                        <div class="card-body">
                            <img src="/img/${path}${item.image_url}" alt="Image" class="img-fluid square-img">
                            <br>
                            <p class="mt-3 app-name">
                                ${item.app}
                            </p>
                        </div>
                    </div>
                `;
                appContainer.appendChild(appItem);
                setTimeout(function() {
                    appItem.classList.remove('slide-out');
                    appItem.classList.add('slide-in');
                }, 100);
            });
        }

        function setActiveButton(type)
        {
            if(type == 'web'){
                $('#web').addClass('active');
                $('#web').removeClass('not-active');
                $('#mobile').removeClass('active');
                $('#mobile').addClass('not-active');

            }else if(type == 'mobile'){
                $('#mobile').addClass('active');
                $('#mobile').removeClass('not-active');
                $('#web').removeClass('active');
                $('#web').addClass('not-active');
            }
        }

        function getQueryParam(param) {
            const urlParams = new URLSearchParams(window.location.search);
            return urlParams.get(param);
        }

    </script>
</body>
</html>
