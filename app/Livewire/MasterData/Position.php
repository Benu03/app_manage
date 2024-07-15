<?php

namespace App\Livewire\MasterData;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Position extends Component
{
    public function render()
    {
        $data = [
            'page_title'    => 'POSITION LIST',
            'listData'      => DB::table('auth.auth_mst_position')->orderBy('position', 'asc')->get()
        ];
        return view('livewire.master-data.position', compact('data'))->extends('layouts.main')->section('content');
    }
}
