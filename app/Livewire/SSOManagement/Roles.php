<?php

namespace App\Livewire\SSOManagement;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Roles extends Component
{
    public $module = '';
    public $role, $status, $id;

    protected function rules()
    {
        return [
            'module'    => 'required|numeric',
            'role'      => 'required',
            'status'    => 'required',
        ];
    }

    protected $listeners = ['moduleSelected'];

    public function moduleSelected($moduleId)
    {
        $this->module = $moduleId;
    }

    public function mount()
    {
        // $this->module = -1;
    }

    public function render()
    {
        $totalData = DB::table('auth.auth_role_module');
        $data = [
            'page_title'    => 'ROLE LIST',
            'totalData'     => $totalData->count(),
            'active'        => $totalData->where('is_active', true)->count(),
            'not_active'    => DB::table('auth.auth_role_module')->where('is_active', false)->count(),
            'listData'      => DB::table('auth.auth_role_module')
                                ->join('auth.auth_module', 'auth.auth_role_module.auth_module_id', '=', 'auth.auth_module.id')
                                ->select(
                                    'auth.auth_role_module.id',
                                    'auth.auth_role_module.role',
                                    'auth.auth_role_module.is_active',
                                    'auth.auth_module.module'
                                )
                                ->orderBy('auth.auth_module.module', 'asc')
                                ->orderBy('auth.auth_role_module.role', 'asc')
                                ->get(),
            'listModule'    => DB::table('auth.auth_module')->orderBy('module', 'asc')->get()
        ];
        return view('livewire.s-s-o-management.roles.roles-show', compact('data'));
    }

    public function saveData()
    {
        $this->validate($this->rules());
        $role = strtoupper($this->role);

        #cek data
        $module     = DB::table('auth.auth_module')->where('id', $this->module)->first();
        $cekData    = DB::table('auth.auth_role_module')->where('auth_module_id', $this->module)->where('role', $role)->first();
        if($cekData){
            $this->addError('role', 'Role '.$role.' in module '.$module->module.' already exist');
            return false;
        }

        #insert data
        DB::table('auth.auth_role_module')->insert([
            'auth_module_id'    => $this->module,
            'role'              => $role,
            'is_active'         => $this->status == 'active' ? true : false,
            'created_by'        => auth()->user()->username,
            'created_date'      => date('Y-m-d H:i:s')
        ]);

        #reset data
        $this->resetInput();
        $this->dispatch('close-modal');
        flash()->success('Data saved successfully!');
    }

    public function updateData()
    {
        $this->validate($this->rules());
        $role = strtoupper($this->role);

        $module     = DB::table('auth.auth_module')->where('id', $this->module)->first();
        $cekData    = DB::table('auth.auth_role_module')->where('auth_module_id', $this->module)->where('role', $role)->first();
        $data       = DB::table('auth.auth_role_module')->where('id', $this->id)->first();

        if($data->role != $role && $cekData){
            $this->addError('role', 'Role '.$role.' in module '.$module->module.' already exist');
            return false;
        }

        DB::table('auth.auth_role_module')->where('id', $this->id)->update([
            'auth_module_id'    => $this->module,
            'role'              => $role,
            'is_active'         => $this->status == 'active' ? true : false,
            'updated_by'        => auth()->user()->username,
            'updated_date'      => date('Y-m-d H:i:s')
        ]);

        $this->resetInput();
        $this->dispatch('close-modal');
        session()->flash('success', 'Data has been updated');
    }

    public function editData($id)
    {
        $data = DB::table('auth.auth_role_module')->where('id', $id)->first();

        if($data){
            $this->module   = $data->auth_module_id;
            $this->role     = $data->role;
            $this->status   = $data->is_active ? 'active' : 'no active';
            $this->id       = $data->id;
        }
    }

    public function closeModal()
    {
        $this->resetInput();
    }

    public function resetInput()
    {
        $this->module   = '';
        $this->role     = '';
        $this->status   = '';
    }
}
