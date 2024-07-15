<?php

namespace App\Livewire\AppManagement;

use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\Attributes\Layout;

class Web extends Component
{
    // #[Layout('layouts.main')]
    public function render()
    {
        $totalData = DB::table('portal.portal_app');
        $data = [
            'page_title'    => 'WEB APPLICATION LIST',
            'totalData'     => $totalData->count(),
            'active'        => $totalData->where('is_active', true)->count(),
            'not_active'    => DB::table('portal.portal_app')->where('is_active', false)->count(),
            'listData'      => DB::table('portal.portal_app')->orderBy('app', 'asc')->get()
        ];

        return view('livewire.app-management.web.index', compact('data'))->extends('layouts.main')->section('content');
    }

}
