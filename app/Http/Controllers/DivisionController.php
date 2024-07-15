<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DivisionController extends Controller
{
    public function index()
    {
        $data = [
            'page_title'    => 'DIVISION LIST',
            'listDepartment'=> Department::whereNotIn('id', function($query) {
                                    $query->select('auth_mst_department_id')
                                        ->from('auth.auth_division_x_department');
                                })->orderBy('department', 'asc')->get(),
        ];
        return view('master-data.division.index', compact('data'));
    }

    public function get_data_department(Request $request)
    {
        //$search = strtoupper($request->input('search')['value']);

        $query = Department::whereNotIn('id', function($query) {
            $query->select('auth_mst_department_id')
                ->from('auth.auth_division_x_department');
        });

        // if (!empty($search)) {
        //     $query->where('department', 'like', "%{$search}%");
        // }

        $data = $query->orderBy('department', 'asc')->get();

        return DataTables()->of($data)->make(true);
    }

    public function get_data(Request $request)
    {
        $search = strtoupper($request->input('search')['value']);

        $query = DB::table('auth.auth_mst_division')
                    ->leftJoin('auth.auth_division_x_department', 'auth.auth_mst_division.id', '=', 'auth.auth_division_x_department.auth_mst_division_id')
                    ->leftJoin('auth.auth_mst_department', 'auth.auth_division_x_department.auth_mst_department_id', '=', 'auth.auth_mst_department.id')
                    ->select(
                        'auth.auth_mst_division.id as id_division',
                        'auth.auth_mst_division.division',
                        DB::raw("STRING_AGG(auth.auth_mst_department.department, ' | ' ORDER BY auth.auth_mst_department.department) as departments")
                    );

        if (!empty($search)) {
            $query->where('auth.auth_mst_division.division', 'like', "%{$search}%");
        }

        $data = $query->groupBy('auth.auth_mst_division.id', 'auth.auth_mst_division.division')
                    ->orderBy('auth.auth_mst_division.division', 'asc')
                    ->get();

        return DataTables()->of($data)
            ->editColumn('departments', function ($datas) {

                if($datas->departments){
                    $departments = explode(' | ', $datas->departments);
                    $departmentList = '';
                    $no = 1;
                    foreach ($departments as $department) {
                        $departmentList .= ($no++) . '. ' . $department . '<br>';
                    }
                    return $departmentList;
                }else{
                    return '';
                }
            })
            ->editColumn('action', function ($datas) {
                return '<a href="javascript:void(0)" onclick="editData(' . $datas->id_division . ')" class="pr-2"><img src="/img/logo/pencil.png"></a><a href="javascript:void(0)" onclick="deleteData(' . $datas->id_division . ')"><img src="/img/logo/delete.png"></a>';
            })
            ->rawColumns(['departments', 'action'])
            ->make(true);
    }



    public function store(Request $request)
    {
        $cekData = DB::table('auth.auth_mst_division')->where('division', strtoupper($request->division))->first();
        if($cekData){
            return response([
                'success'       => false,
                'error'         => 'duplicate',
                'message'       => 'Division ['.strtoupper($request->division).'] already exist'
            ], 200);
        }
        DB::beginTransaction();

        try {
            $data = [
                'division'      => strtoupper($request->division),
                'created_by'    => session()->get('user_module')['username'],
                'created_date'  => date('Y-m-d H:i:s')
            ];
            $idDivision = DB::table('auth.auth_mst_division')->insertGetId($data);

            foreach($request->selectedDepart as $department){
                $data = [
                    'auth_mst_division_id'    => $idDivision,
                    'auth_mst_department_id'  => $department
                ];
                DB::table('auth.auth_division_x_department')->insert($data);
            }
            DB::commit();

            return response([
                'success'       => true,
                'message'       => 'Success Add Division'
            ], 200);

        } catch (\Throwable $th) {
            DB::rollBack();
            return response([
                'success'       => false,
                'message'       => 'Error : '.$th->getMessage()
            ], 500);
        }
    }

    public function edit()
    {
        $data           = DB::table('auth.auth_mst_division')->where('id', request()->id)->first();
        $departments    = DB::table('auth.auth_division_x_department')
                            ->leftJoin('auth.auth_mst_department', 'auth.auth_division_x_department.auth_mst_department_id', '=', 'auth.auth_mst_department.id')
                            ->select('auth.auth_mst_department.id as id_department', 'auth.auth_mst_department.department')
                            ->where('auth_mst_division_id', request()->id)
                            ->orderBy('auth_mst_department.department', 'asc')
                            ->get();

        return response([
            'success'      => true,
            'message'      => 'success',
            'data'         => $data,
            'departments'  => $departments
        ], 200);
    }

    public function update(Request $request)
    {
        $getData = DB::table('auth.auth_mst_division')->where('id', $request->id)->first();
        if($getData && ($request->division != $getData->division)){
            $cekData = DB::table('auth.auth_mst_division')->where('division', strtoupper($request->division))->first();
            if($cekData){
                return response([
                    'success'       => false,
                    'error'         => 'duplicate',
                    'message'       => 'Division '.strtoupper($request->division).' already exist'
                ], 200);
            }
        }

        DB::beginTransaction();

        try {
            $data = [
                'division'      => strtoupper($request->division),
                'updated_by'    => session()->get('user_module')['username'],
                'updated_date'  => date('Y-m-d H:i:s')
            ];

            DB::table('auth.auth_mst_division')->where('id', $request->id)->update($data);

            $existingDepartments = DB::table('auth.auth_division_x_department')
                                    ->where('auth_mst_division_id', $request->id)
                                    ->pluck('auth_mst_department_id')
                                    ->toArray();

            // Tentukan departemen yang harus dihapus
            $departmentsToDelete = array_diff($existingDepartments, $request->selectedDepart);

            // Tentukan departemen yang harus ditambahkan
            $departmentsToAdd = array_diff($request->selectedDepart, $existingDepartments);

            if (!empty($departmentsToDelete)) {
                DB::table('auth.auth_division_x_department')
                    ->where('auth_mst_division_id', $request->id)
                    ->whereIn('auth_mst_department_id', $departmentsToDelete)
                    ->delete();
            }

            foreach ($departmentsToAdd as $department) {
                $data = [
                    'auth_mst_division_id' => $request->id,
                    'auth_mst_department_id' => $department
                ];
                DB::table('auth.auth_division_x_department')->insert($data);
            }

            DB::commit();

            return response([
                'success'       => true,
                'message'       => 'Success Update Division'
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response([
                'success'       => false,
                'message'       => 'Error : '.$th->getMessage()
            ], 500);
        }
    }

    public function delete()
    {
        DB::beginTransaction();
        try {
            DB::table('auth.auth_division_x_department')->where('auth_mst_division_id', request()->id)->delete();
            DB::table('auth.auth_mst_division')->where('id', request()->id)->delete();
            DB::commit();
            return response([
                'status'    => true,
                'message'   => 'Success Delete Division'
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
