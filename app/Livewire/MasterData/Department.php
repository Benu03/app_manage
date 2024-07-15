<?php

namespace App\Livewire\MasterData;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Department extends Component
{
    public function render()
    {
        $data = [
            'page_title'    => 'DEPARTMENT LIST',
            'listData'      => DB::table('auth.auth_mst_department')->orderBy('department', 'asc')->get()
        ];
        return view('livewire.master-data.department.show', compact('data'));
    }
}
