<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Entity;
use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MasterDataController extends Controller
{

    public function entity_show()
    {
        $totalData = DB::table('auth.auth_entity');
        $data = [
            'page_title'    => 'ENTITY LIST',
            'totalData'     => $totalData->count(),
            'active'        => $totalData->where('is_active', true)->count(),
            'not_active'    => Entity::where('is_active', false)->count(),
        ];
        return view('master-data.entity.index', compact('data'));
    }

    public function entity_get_count()
    {
        $totalData = DB::table('auth.auth_entity');
        $data = [
            'totalData'     => $totalData->count(),
            'active'        => $totalData->where('is_active', true)->count(),
            'not_active'    => Entity::where('is_active', false)->count(),
        ];

        return response()->json([
            'data' => $data,
            'success' => true,
            'code' => 200
        ]);
    }

    public function entity_get_data()
    {

        $data = Entity::orderBy('entity', 'asc')->get();

        return DataTables()->of($data)
            ->editColumn('action', function ($datas) {
                return '<a href="javascript:void(0)" onclick="editData(' . $datas->id . ')" class="pr-2"><img src="/img/logo/pencil.png"></a><a href="javascript:void(0)" onclick="deleteData(' . $datas->id . ')"><img src="/img/logo/delete.png"></a>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function entity_store(Request $request)
    {
        $cekData = Entity::where('entity', strtoupper($request->entity))->first();
        if($cekData){
            return response([
                'success'       => false,
                'error'         => 'duplicate',
                'message'       => 'Entity '.strtoupper($request->entity).' already exist'
            ], 200);
        }
        DB::beginTransaction();

        try {
            $data = [
                'entity'        => strtoupper($request->entity),
                'desc'          => $request->desc,
                'is_active'     => $request->status == 'active' ? true : false,
                'created_by'    => session()->get('user_module')['username'],
                'created_date'  => date('Y-m-d H:i:s')
            ];
            Entity::create($data);
            DB::commit();

            return response([
                'success'       => true,
                'message'       => 'Success add Entity'
            ], 200);

        } catch (\Throwable $th) {
            DB::rollBack();
            return response([
                'success'       => false,
                'message'       => 'Error : '.$th->getMessage()
            ], 500);
        }
    }

    public function entity_edit()
    {
        $data = Entity::where('id', request()->id)->first();
        return response([
            'success'   => true,
            'message'   => 'success',
            'data'      => $data
        ], 200);
    }

    public function entity_update(Request $request)
    {
        $getData = Entity::where('id', $request->id)->first();
        if($getData && ($request->entity != $getData->entity)){
            $cekData = Entity::where('entity', strtoupper($request->entity))->first();
            if($cekData){
                return response([
                    'success'       => false,
                    'error'         => 'duplicate',
                    'message'       => 'Entity '.strtoupper($request->entity).' already exist'
                ], 200);
            }
        }

        DB::beginTransaction();

        try {
            $data = [
                'entity'        => strtoupper($request->entity),
                'desc'          => $request->desc,
                'is_active'     => $request->status == 'active' ? true : false,
                'updated_by'    => session()->get('user_module')['username'],
                'updated_date'  => date('Y-m-d H:i:s')
            ];

            Entity::where('id', $request->id)->update($data);
            DB::commit();

            return response([
                'success'       => true,
                'message'       => 'Success update entity'
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response([
                'success'       => false,
                'message'       => 'Error : '.$th->getMessage()
            ], 500);
        }
    }

    public function delete_entity()
    {
        DB::beginTransaction();
        try {
            Entity::where('id', request()->id)->delete();
            DB::commit();
            return response([
                'status'    => true,
                'message'   => 'Success delete entity'
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response([
                'status'    => false,
                'message'   => 'Error : '.$th->getMessage()
            ], 500);
        }
    }

    public function depart_show()
    {
        $data = [
            'page_title'    => 'DEPARTMENT LIST',
        ];

        return view('master-data.department.index', compact('data'));
    }

    public function depart_get_data(Request $request)
    {

        $search = strtoupper($request->input('search')['value']);

        $query = Department::query();

        if (!empty($search)) {
            $query->where('department', 'like', "%{$search}%");
        }

        $query->orderBy('department', 'asc');

        $data = $query->get();

        // $data = Department::orderBy('department', 'asc')->get();

        return DataTables()->of($data)
            ->editColumn('action', function ($datas) {
                return '<a href="javascript:void(0)" onclick="editData(' . $datas->id . ')" class="pr-2"><img src="/img/logo/pencil.png"></a><a href="javascript:void(0)" onclick="deleteData(' . $datas->id . ')"><img src="/img/logo/delete.png"></a>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function depart_store(Request $request)
    {
        $cekData = Department::where('department', strtoupper($request->department))->first();
        if($cekData){
            return response([
                'success'       => false,
                'error'         => 'duplicate',
                'message'       => 'Department '.strtoupper($request->department).' already exist'
            ], 200);
        }
        DB::beginTransaction();

        try {
            $data = [
                'department'    => strtoupper($request->department),
                'created_by'    => session()->get('user_module')['username'],
                'created_date'  => date('Y-m-d H:i:s')
            ];
            Department::create($data);
            DB::commit();

            return response([
                'success'       => true,
                'message'       => 'Success Add Department'
            ], 200);

        } catch (\Throwable $th) {
            DB::rollBack();
            return response([
                'success'       => false,
                'message'       => 'Error : '.$th->getMessage()
            ], 500);
        }
    }

    public function depart_edit()
    {
        $data = Department::where('id', request()->id)->first();
        return response([
            'success'   => true,
            'message'   => 'success',
            'data'      => $data
        ], 200);
    }

    public function depart_update(Request $request)
    {
        $getData = Department::where('id', $request->id)->first();
        if($getData && ($request->department != $getData->department)){
            $cekData = Department::where('department', strtoupper($request->department))->first();
            if($cekData){
                return response([
                    'success'       => false,
                    'error'         => 'duplicate',
                    'message'       => 'Department '.strtoupper($request->department).' already exist'
                ], 200);
            }
        }

        DB::beginTransaction();

        try {
            $data = [
                'department'    => strtoupper($request->department),
                'updated_by'    => session()->get('user_module')['username'],
                'updated_date'  => date('Y-m-d H:i:s')
            ];

            Department::where('id', $request->id)->update($data);
            DB::commit();

            return response([
                'success'       => true,
                'message'       => 'Success Update Department'
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response([
                'success'       => false,
                'message'       => 'Error : '.$th->getMessage()
            ], 500);
        }
    }

    public function delete_depart()
    {
        DB::beginTransaction();
        try {
            Department::where('id', request()->id)->delete();
            DB::commit();
            return response([
                'status'    => true,
                'message'   => 'Success Delete Department'
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response([
                'status'    => false,
                'message'   => 'Error : '.$th->getMessage()
            ], 500);
        }
    }

    public function position_show()
    {
        $data = [
            'page_title'    => 'POSITION LIST',
        ];

        return view('master-data.position.index', compact('data'));
    }

    public function position_get_data()
    {

        $data = Position::orderBy('position', 'asc')->get();

        return DataTables()->of($data)
            ->editColumn('action', function ($datas) {
                return '<a href="javascript:void(0)" onclick="editData(' . $datas->id . ')" class="pr-2"><img src="/img/logo/pencil.png"></a><a href="javascript:void(0)" onclick="deleteData(' . $datas->id . ')"><img src="/img/logo/delete.png"></a>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function position_store(Request $request)
    {
        $cekData = Position::where('position', strtoupper($request->position))->first();
        if($cekData){
            return response([
                'success'       => false,
                'error'         => 'duplicate',
                'message'       => 'Position '.strtoupper($request->position).' already exist'
            ], 200);
        }
        DB::beginTransaction();

        try {
            $data = [
                'position'      => strtoupper($request->position),
                'created_by'    => session()->get('user_module')['username'],
                'created_date'  => date('Y-m-d H:i:s')
            ];
            Position::create($data);
            DB::commit();

            return response([
                'success'       => true,
                'message'       => 'Success Add Position'
            ], 200);

        } catch (\Throwable $th) {
            DB::rollBack();
            return response([
                'success'       => false,
                'message'       => 'Error : '.$th->getMessage()
            ], 500);
        }
    }

    public function position_edit()
    {
        $data = Position::where('id', request()->id)->first();
        return response([
            'success'   => true,
            'message'   => 'success',
            'data'      => $data
        ], 200);
    }

    public function position_update(Request $request)
    {
        $getData = Position::where('id', $request->id)->first();
        if($getData && ($request->position != $getData->position)){
            $cekData = Position::where('position', strtoupper($request->position))->first();
            if($cekData){
                return response([
                    'success'       => false,
                    'error'         => 'duplicate',
                    'message'       => 'Position '.strtoupper($request->position).' already exist'
                ], 200);
            }
        }

        DB::beginTransaction();

        try {
            $data = [
                'position'      => strtoupper($request->position),
                'updated_by'    => session()->get('user_module')['username'],
                'updated_date'  => date('Y-m-d H:i:s')
            ];

            Position::where('id', $request->id)->update($data);
            DB::commit();

            return response([
                'success'       => true,
                'message'       => 'Success Update Position'
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response([
                'success'       => false,
                'message'       => 'Error : '.$th->getMessage()
            ], 500);
        }
    }

    public function delete_position()
    {
        DB::beginTransaction();
        try {
            Position::where('id', request()->id)->delete();
            DB::commit();
            return response([
                'status'    => true,
                'message'   => 'Success Delete Position'
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response([
                'status'    => false,
                'message'   => 'Error : '.$th->getMessage()
            ], 500);
        }
    }
}
