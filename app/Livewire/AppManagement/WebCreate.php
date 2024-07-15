<?php

namespace App\Livewire\AppManagement;

use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithFileUploads;

class WebCreate extends Component
{
    use WithFileUploads;
    public $app, $status, $description, $module, $dev_url, $prod_url, $logo;
    public $selectedModules;
    public function render()
    {
        $data = [
            'listModule' =>  DB::table('auth.auth_module')->orderBy('module', 'asc')->get()
        ];
        return view('livewire.app-management.web.create', compact('data'))->extends('layouts.main')->section('content');
    }

    public function rules()
    {
        return [
            'app'           => ['required'],
            'status'        => ['required'],
            'description'   => ['required'],
            'photo'         => 'image|max:2048',
        ];
    }

    public function edit($id)
    {
        try {
            $module = DB::table('auth.auth_module')->where('id', $id)->first();
        } catch (\Exception $e) {
            session()->flash('error', 'Something goes wrong!!');
        }
    }


    public function submit()
    {
        dd($this->logo);
        $this->validate($this->rules());
    }

}
