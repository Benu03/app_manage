<?php

namespace App\Livewire\MasterData;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Entity extends Component
{
    public function render()
    {
        $totalData = DB::table('auth.auth_entity');
        $data = [
            'page_title'    => 'ENTITY LIST',
            'totalData'     => $totalData->count(),
            'active'        => $totalData->where('is_active', true)->count(),
            'not_active'    => DB::table('auth.auth_entity')->where('is_active', false)->count(),
            'listData'      => DB::table('auth.auth_entity')->orderBy('entity', 'asc')->get()
        ];
        return view('livewire.master-data.entity', compact('data'))->extends('layouts.main')->section('content');
    }
}
