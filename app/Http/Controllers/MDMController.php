<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MDMController extends Controller
{
    public function index()
    {
        $data = [
            'page_title'    =>  "MASTER DATA MANAGEMENT",
            'listData'      =>  DB::table('mdm.mdm_master')->orderBy('name_master', 'asc')->get(),
        ];
        return view('mdm.index', compact('data'));
    }

    public function get_data()
    {
        $data =  DB::table('mdm.mdm_master')->whereNull('deleted_date')->orderBy('id', 'asc')->get();

        return DataTables()->of($data)
            ->editColumn('Action', function ($datas) {
                return '<a href="javascript:void(0)" onclick="editData(' . $datas->id . ')" class="pr-2"><img src="/img/logo/pencil.png" alt=""></a><a href="javascript:void(0)" class="btn-delete" data-remote="' . $datas->id . ','.$datas->name_master.'"><img src="img/logo/delete.png" alt=""></a>';
            })
            ->rawColumns(['Action'])
            ->make(true);
    }

    public function get_id()
    {
        $maxId = DB::table('mdm.mdm_master')->max('id');
        $newId = $maxId + 1;
        return response()->json(['id' => $newId]);
    }

    public function store(Request $request)
    {
        $data = [
            'name_master'   =>  $request->name_master,
            'source'        =>  $request->source,
            'desc'          =>  $request->desc,
            'type'          =>  $request->type,
            'query_master'  =>  $request->query_master,
            'created_by'    =>  session()->get('user_module')['username'],
            'created_date'  =>  date('Y-m-d H:i:s'),

        ];
        $isSuccess = DB::table('mdm.mdm_master')->insert($data);
        if(!$isSuccess){
            return response()->json(['status' => 400, 'message' => 'Add Data Failed']);
        }
        return response()->json(['status' => 200, 'message' => 'Add Data Success']);
    }

    public function edit()
    {
        $data =  DB::table('mdm.mdm_master')->where('id', request('id'))->first();
        return response()->json(['data' => $data]);
    }

    public function update(Request $request)
    {
        $data = [
            'name_master'   =>  $request->name_master,
            'source'        =>  $request->source,
            'desc'          =>  $request->desc,
            'type'          =>  $request->type,
            'query_master'  =>  $request->query_master,
            'updated_by'    =>  session()->get('user_module')['username'],
            'updated_date'  =>  date('Y-m-d H:i:s'),

        ];
        $isSuccess = DB::table('mdm.mdm_master')->where('id', $request->id)->update($data);

        if (!$isSuccess) {
            return response()->json(['status' => 400, 'message' => 'Update Data Failed']);
        }

        return response()->json(['status' => 200, 'message' => 'Update Data Success']);
    }

    public function delete(Request $request)
    {
        $isSuccess = DB::table('mdm.mdm_master')
                ->where('id', $request->id)
                ->update([
                        'deleted_by' => session()->get('user_module')['username'],
                        'deleted_date' => date('Y-m-d H:i:s')
                    ]);

        if(!$isSuccess){
            return response()->json(['status' => 400, 'message' => 'Delete Data Failed']);
        }

        return response()->json(['status' => 200, 'message' => 'Delete Data Success']);
    }
}
