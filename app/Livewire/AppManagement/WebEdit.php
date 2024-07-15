<?php

namespace App\Livewire\AppManagement;

use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\Attributes\Layout;

class WebEdit extends Component
{
    public $id;
    #[Layout('layouts.main')]
    public function render()
    {
        try {
            $module = DB::table('auth.auth_module')->where('id', $this->id)->first();
        } catch (\Exception $e) {
            session()->flash('error', 'Something goes wrong!!');
        }
        $data = [
            'listModule' =>  DB::table('auth.auth_module')->orderBy('module', 'asc')->get()
        ];
        return view('livewire.app-management.web.edit', compact('data'));
    }


    public function edit($id)
    {
        try {
            $module = DB::table('auth.auth_module')->where('id', $id)->first();
        } catch (\Exception $e) {
            session()->flash('error', 'Something goes wrong!!');
        }
    }

}
