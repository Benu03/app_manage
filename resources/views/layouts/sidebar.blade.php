<style>
    .os-content {
        padding: 0px 8px 0px !important;
        height: 100%;
        width: 100%;
    }

    .small-icon {
        font-size: 10px !important;
        transform: scale(0.8);
        color: #525458;
    }

    #logo_wrap {
    transition: all 0.3s ease;
    height: 80px; /* Default ukuran logo */
    width: auto; /* Mempertahankan proporsi */
   
}

/* Ketika sidebar diperbesar */
.sidebar-expanded #logo_wrap {
    height: 500px !important; /* Ukuran diperbesar */
    width: auto; /* Memastikan proporsi tetap */
    margin: 0 auto; /* Centering */
}

/* Penyesuaian tambahan */
.sidebar-expanded .brand-link {
    display: flex;
    justify-content: center; /* Pusatkan konten */
}

</style>

<aside class="main-sidebar sidebar-light-green">
    <!-- Brand Logo -->
    {{-- <a href="{{ route('lobby') }}" class="brand-link py-0 mt-2 ml-2" id="link">
        <img id="logo_wrap" alt="APP Manage" class="brand-image-xl py-1" src="{{ asset('img/logo/logo.png') }}"
            style="height:700px !important;">
    </a> --}}

    <a href="{{ route('lobby') }}" class="brand-link d-flex flex-column align-items-center" >
        <img id="logo_wrap" alt="APP Manage" class="py-1" src="{{ asset('img/logo/logo.png') }}" >
       
      </a>
    <!-- Sidebar -->
    <div id="sidebar" class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="">
            <ul class="nav nav-pills nav-sidebar text-sm flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <li class="nav-link px-1 mb-2 py-0" style="background-color:#EAEAF3;border-radius:6px;color:#9797C4;">
                    <form class="search">
                        <span class="search-icon fa fa-search">

                        </span>
                        <input type="text" id="searchInputt" placeholder="Search Menu.." title="Search Menu.."
                            class="form-control search-menu border-0"
                            style="background-color:transparent !important;cursor:pointer;border:0px !important;font-size: 16px !important;padding:10 10px 0 10px;width:80%;">
                        <p id="close_search_menu" style="padding-top: 1em !important;color: #dc3545;"
                            class="input-group-addon fa fa-xmark px-2">
                        </p>
                    </form>
                </li>
                @php
                // Fetch menu data and their children in a single query
                $menus = \DB::table('auth.auth_mst_menu')
                            ->leftJoin('auth.auth_mst_role_menu', 'auth.auth_mst_menu.id', '=', 'auth.auth_mst_role_menu.id_menu')
                            ->leftJoin('auth.auth_mst_user_role', 'auth.auth_mst_role_menu.id_role', '=', 'auth.auth_mst_user_role.id')
                            ->where('auth_mst_menu.is_active', true)
                            ->orderBy('auth.auth_mst_menu.menu_order', 'asc')
                            ->select('auth.auth_mst_menu.*', 'auth.auth_mst_role_menu.id_role', 'auth.auth_mst_user_role.role_name')
                            ->get();

                // Group the menus by their parent ID
                $menuTree = $menus->groupBy('menu_parent');


                @endphp

                @foreach ($menuTree[0] as $item)
                @php
                $isParentActive = Request::is(ltrim($item->menu_url, '/') . '*');
                $isParentOpen = false;
                @endphp

                <li class="nav-item menu-item mb-0 py-0 {{ $isParentActive ? 'menu-is-opening menu-open' : '' }}"
                    id="navItemx">
                    <a href="{{ in_array(config('static.app_env'), ['development', 'production']) ? config('static.url_portal_ts3').$item->menu_url : url($item->menu_url) }}"
                        class="nav-link text-dark toggle-menu {{ $isParentActive ? 'activex' : '' }}">
                        <i class="nav-icon material-symbols-rounded" style="font-size: 22px!important;color:#2035d4">{{
                            $item->menu_icon }}</i>
                        <p class="menu-name text-dark" style="font-size: 14px;color:#060607;">
                            {{ $item->menu_name }}
                        </p>
                        @if (isset($menuTree[$item->id]) && count($menuTree[$item->id]) > 0)
                        @php
                        foreach ($menuTree[$item->id] as $subItem) {
                        if (Request::is(ltrim($subItem->menu_url, '/') . '*')) {
                        $isParentOpen = true;
                        break;
                        }
                        }
                        @endphp
                        <p>
                            <i class="right material-symbols-rounded arrow-icon"
                                style="margin-left: -10px; float: right; color: #525458; font-size: 15px !important; transform: scale(1.0);">
                                {{ $isParentOpen ? 'keyboard_arrow_down' : 'keyboard_arrow_right' }}
                            </i>
                        </p>
                        @endif
                    </a>

                    {{-- Children Menu --}}
                    @if (isset($menuTree[$item->id]) && count($menuTree[$item->id]) > 0)
                    <ul class="nav nav-treeview text-sm flex-column" style="background-color: #E3EEF0;">
                        @foreach ($menuTree[$item->id] as $subItem)
                        @php
                        $isChildActive = Request::is(ltrim($subItem->menu_url, '/') . '*');
                        @endphp
                        <li class="nav-item menu-item-has-children ps-2 {{ $isChildActive ? 'menu-is-opening menu-open' : '' }}"
                            id="navItem">
                            <a href="{{ in_array(config('static.app_env'), ['development', 'production']) ? config('static.url_portal_ts3').$subItem->menu_url : url($subItem->menu_url) }}"
                                class="nav-link text-primary pl-4 {{ $isChildActive ? 'active' : '' }}">
                                <i class="nav-icon material-symbols-rounded"
                                    style="font-size: 22px!important;color:#2035d4 !important;background-color: #E3EEF0;">
                                    {{ $subItem->menu_icon }}
                                </i>
                                <p class="menu-name text-primary" style="font-size: 14px;color:#060607 !important;">
                                    {{ $subItem->menu_name }}
                                </p>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                    @endif
                </li>
                @endforeach


            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>

<script>
    document.querySelector('#sidebar').addEventListener('transitionend', function () {
    if (document.querySelector('#sidebar').classList.contains('sidebar-expanded')) {
        document.querySelector('#sidebar').classList.remove('sidebar-expanded');
    } else {
        document.querySelector('#sidebar').classList.add('sidebar-expanded');
    }
});
</script>