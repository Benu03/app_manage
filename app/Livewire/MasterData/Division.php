<?php

namespace App\Livewire\MasterData;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Division extends Component
{
    public function render()
    {
        $data = [
            'page_title'    => 'DIVISION LIST',
            'listData'      => DB::table('auth.auth_mst_division')->orderBy('division', 'asc')->get()
        ];
        return view('livewire.master-data.division', compact('data'))->extends('layouts.main')->section('content');
    }
}
