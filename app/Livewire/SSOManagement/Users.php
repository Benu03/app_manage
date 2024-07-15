<?php

namespace App\Livewire\SSOManagement;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Users extends Component
{
    public function render()
    {
        $totalData = DB::table('auth.v_auth_user_personal_show');
        $data = [
            'page_title'    => 'USER LIST',
            'totalData'     => $totalData->count(),
            'active'        => $totalData->where('is_active', true)->count(),
            'not_active'    => DB::table('auth.auth_users')->where('is_active', false)->count(),
            'listData'      => DB::table('auth.v_auth_user_personal_show')
                                ->orderBy('auth.v_auth_user_personal_show.username', 'asc')
                                ->get()
        ];
        return view('livewire.s-s-o-management.users.index', compact('data'));
    }
}
