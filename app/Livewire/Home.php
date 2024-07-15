<?php

namespace App\Livewire;

use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\Attributes\Layout;

class Home extends Component
{
    // #[Layout('layouts.main')]
    public function render()
    {
        $data = [
            'page_title' => 'Dashboard',
            'users'      => DB::table('auth.auth_users')->count(),
            'roles'      => DB::table('auth.auth_role_module')->count(),
            'modules'    => DB::table('auth.auth_module')->count(),
            // 'mobile_apps'=> DB::table('portal.mobile_app')->count(),
            // 'web_apps'   => DB::table('portal.portal_app')->count(),
            'apk'    => DB::table('auth.auth_version_apk')->count(),
        ];

        return view('livewire.home', compact('data'))->extends('layouts.main')->section('content');
    }

    public function redirectUrl($urlKey)
    {
        $urls = [
            // 'web-url'       => '/app-management-web',
            // 'mobile-url'    => '/app-management-mobile',
            'apk-url'    => '/sso-management-apk',
            'users-url'     => '/sso-management-users',
            'roles-url'     => '/sso-management-roles',
            'modules-url'   => '/sso-management-modules'
        ];

        if (isset($urls[$urlKey])) {
            return redirect()->to($urls[$urlKey]);
        }

        return abort(404);
    }
}
