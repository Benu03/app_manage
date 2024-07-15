<?php

namespace App\Livewire\AppManagement\Mobile;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Mobile extends Component
{
    public function render()
    {
        $totalData = DB::table('portal.mobile_app');
        $data = [
            'page_title'    => 'MOBILE APPLICATION LIST',
            'totalData'     => $totalData->count(),
            'active'        => $totalData->where('is_active', true)->count(),
            'not_active'    => DB::table('portal.mobile_app')->where('is_active', false)->count(),
            'listData'      => DB::table('portal.mobile_app')->orderBy('app', 'asc')->get()
        ];
        return view('livewire.app-management.mobile.index', compact('data'))->extends('layouts.main')->section('content');
    }
}
