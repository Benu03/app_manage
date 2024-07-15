<?php

namespace App\Livewire\SSOManagement;

use App\Models\Modules as ModelsModules;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Modules extends Component
{
    public $module, $desc, $version, $status, $id;
    protected function rules()
    {
        return [
            'module'    => 'required',
            'desc'      => 'required',
            'version'   => 'required',
            'status'    => 'required',
        ];
    }

    public function render()
    {
        $totalData = DB::table('auth.auth_module');
        $data = [
            'page_title'    => 'MODULE LIST',
            'totalData'     => $totalData->count(),
            'active'        => $totalData->where('is_active', true)->count(),
            'not_active'    => ModelsModules::where('is_active', false)->count()
        ];
        return view('livewire.s-s-o-management.modules.modules-show', compact('data'));
    }


    public function saveData()
    {
        $this->validate($this->rules());

        #cek data
        $cekData = DB::table('auth.auth_module')->where('module', strtoupper($this->module))->first();
        if($cekData){
            $this->addError('module', 'Module '.strtoupper($this->module).' already exist');
            return false;
        }

        #insert data
        DB::table('auth.auth_module')->insert([
            'module'        => strtoupper($this->module),
            'desc'          => $this->desc,
            'version'       => $this->version,
            'is_active'     => $this->status == 'active' ? true : false,
            'created_by'    => auth()->user()->username,
            'created_date'  => date('Y-m-d H:i:s')
        ]);

        #reset data
        $this->resetInput();
        $this->dispatch('close-modal');
        $this->dispatch('show-datatable');
        $this->render();
        session()->flash('success', 'Data has been saved');
    }

    public function updateData()
    {
        $module = strtoupper($this->module);
        $this->validate($this->rules());

        $data = DB::table('auth.auth_module')->where('id', $this->id)->first();
        $cekData = DB::table('auth.auth_module')->where('module', strtoupper($module))->first();

        if($data->module != $module && $cekData){
            $this->addError('module', 'Module '.strtoupper($module).' already exist');
            return false;
        }

        DB::table('auth.auth_module')->where('id', $this->id)->update([
            'module'        => $module,
            'desc'          => $this->desc,
            'version'       => $this->version,
            'is_active'     => $this->status == 'active' ? true : false,
            'updated_by'    => auth()->user()->username,
            'updated_date'  => date('Y-m-d H:i:s')
        ]);

        $this->resetInput();
        $this->dispatch('close-modal');
        $this->dispatch('show-datatable');
        session()->flash('success', 'Data has been updated');
    }

    public function editData($id)
    {
        $data = DB::table('auth.auth_module')->where('id', $id)->first();

        if($data){
            $this->module   = $data->module;
            $this->desc     = $data->desc;
            $this->version  = $data->version;
            $this->status   = $data->is_active ? 'active' : 'no active';
            $this->id       = $data->id;

            $this->dispatch('open-edit-modal');
        }
    }

    public function closeModal()
    {
        $this->resetInput();
    }

    public function resetInput()
    {
        $this->module = '';
        $this->desc = '';
        $this->version = '';
        $this->status = null;
    }
}
