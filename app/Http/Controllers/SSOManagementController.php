<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Modules;
use App\Models\Apk;
use App\Models\UserAuth;
use App\Models\UserAuthPersonal;
use App\Models\UserPersonal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Log;

class SSOManagementController extends Controller
{
    public function modules_show()
    {
        $totalData = DB::table('auth.auth_module');
        $data = [
            'page_title'    => 'MODULE LIST',
            'totalData'     => $totalData->count(),
            'active'        => $totalData->where('is_active', true)->count(),
            'not_active'    => Modules::where('is_active', false)->count()
        ];
        return view('sso-management.modules.index', compact('data'));
    }


    public function apk_show()
    {
        $totalData = DB::table('auth.auth_version_apk');
        $data = [
            'page_title'    => 'APK VERSION LIST',
            'totalData'     => $totalData->count(),
            'active'        => $totalData->where('is_active', true)->count(),
            'not_active'    => Modules::where('is_active', false)->count()
        ];
        return view('sso-management.apk.index', compact('data'));
    }

    public function modules_get_data()
    {

        $data = Modules::orderBy('module', 'asc')->get();

        return DataTables()->of($data)
            ->editColumn('action', function ($datas) {
                return '<a href="javascript:void(0)" onclick="editData(' . $datas->id . ')"><img src="/img/logo/pencil.png"></a>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }


    public function apk_get_data()
    {
        $data = Apk::orderBy('name_app', 'asc')->get();


        return DataTables()->of($data)
            ->editColumn('action', function ($datas) {
                return '<a href="javascript:void(0)" onclick="editData(' . $datas->id . ')"><img src="/img/logo/pencil.png"></a>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function modules_get_count()
    {
        $totalData = DB::table('auth.auth_module');
        $data = [
            'totalData'     => $totalData->count(),
            'active'        => $totalData->where('is_active', true)->count(),
            'not_active'    => Modules::where('is_active', false)->count()
        ];

        return response()->json([
            'data' => $data,
            'success' => true,
            'code' => 200
        ]);
    }


    public function apk_get_count()
    {
        $totalData = DB::table('auth.auth_version_apk');
        $data = [
            'totalData'     => $totalData->count(),
            'active'        => $totalData->where('is_active', true)->count(),
            'not_active'    => Apk::where('is_active', false)->count()
        ];

        return response()->json([
            'data' => $data,
            'success' => true,
            'code' => 200
        ]);
    }

    public function modules_store(Request $request)
    {
        $cekData = DB::table('auth.auth_module')->where('module', strtoupper($request->module))->first();
        if($cekData){
            return response([
                'success'       => false,
                'error'         => 'duplicate',
                'message'       => 'Module ['.strtoupper($request->module).'] already exist'
            ], 200);
        }
       
        $platforms = $request->platform;
        $platform = null;
    
        if (!is_null($platforms) && is_array($platforms)) {
            if (count($platforms) > 1) {
                $platform = implode(',', $platforms); 
            } elseif (count($platforms) == 1) {
                $platform = $platforms[0]; 
            }
        }
    

        DB::beginTransaction();

        try {
            $data = [
                'module'        => strtoupper($request->module),
                'key_module'    => hash('sha256',Str::random(128)),
                'dev_url'       =>  $request->dev_url,
                'prod_url'      =>  $request->pro_url,
                'local_url'     => $request->local_url,
                'api_url'       =>  $request->api_url,
                'platform'      => $platform,
                'desc'          => $request->desc,
                'version'       => $request->version,
                'is_active'     => $request->status == 'active' ? true : false,
                'created_by'    => session()->get('user_module')['username'],
                'created_date'  => date('Y-m-d H:i:s')
            ];
            Log::info($data);
            Modules::create($data);
            DB::commit();

            return response([
                'success'       => true,
                'message'       => 'Success add module'
            ], 200);

        } catch (\Throwable $th) {
            DB::rollBack();
            return response([
                'success'       => false,
                'message'       => 'Error : '.$th->getMessage()
            ], 500);
        }
    }

    public function apk_store(Request $request)
    {
        $cekData = DB::table('auth.auth_version_apk')->where('name_app', strtoupper($request->apk))
        ->where('name_app', $request->version)->first();
        if ($cekData) {
            return response([
                'success' => false,
                'error'   => 'duplicate',
                'message' => 'APK [' . strtoupper($request->apk) . '] already exist ' . $request->version 
            ], 200);
        }
       
      
        DB::beginTransaction();

        try {
            $data = [
                'name_app'        => strtoupper($request->apk),
                'description'          => $request->desc,
                'version'       => $request->version,
                'is_active'     => $request->status == 'active' ? true : false,
                'created_by'    => session()->get('user_module')['username'],
                'created_date'  => date('Y-m-d H:i:s')
            ];
            Log::info($data);
            Apk::create($data);
            DB::commit();

            return response([
                'success'       => true,
                'message'       => 'Success add apk'
            ], 200);

        } catch (\Throwable $th) {
            DB::rollBack();
            return response([
                'success'       => false,
                'message'       => 'Error : '.$th->getMessage()
            ], 500);
        }
    }

    public function modules_edit()
    {
        $data = Modules::where('id', request()->id)->first();
        return response([
            'success'   => true,
            'message'   => 'success',
            'data'      => $data
        ], 200);
    }

    public function apk_edit()
    {
        $data = Apk::where('id', request()->id)->first();
        return response([
            'success'   => true,
            'message'   => 'success',
            'data'      => $data
        ], 200);
    }

    public function modules_update(Request $request)
    {
        $module = DB::table('auth.auth_module')->where('id', $request->id)->first();
        if($module && ($request->module != $module->module)){
            $cekData = DB::table('auth.auth_module')->where('module', strtoupper($request->module))->first();
            if($cekData){
                return response([
                    'success'       => false,
                    'error'         => 'duplicate',
                    'message'       => 'Module ['.strtoupper($request->module).'] already exist'
                ], 200);
            }
        }

        $platforms = $request->platform;
        $platform = null;
    
        if (!is_null($platforms) && is_array($platforms)) {
            if (count($platforms) > 1) {
                $platform = implode(',', $platforms); 
            } elseif (count($platforms) == 1) {
                $platform = $platforms[0]; 
            }
        }

        DB::beginTransaction();

        try {

            

            $data = [
                'module'        => strtoupper($request->module),
                'desc'          => $request->desc,
                'dev_url'       =>  $request->dev_url,
                'prod_url'      =>  $request->pro_url,
                'local_url'     => $request->local_url,
                'api_url'       =>  $request->api_url,
                'platform'      => $platform,
                'version'       => $request->version,
                'is_active'     => $request->status == 'active' ? true : false,
                'updated_by'    => session()->get('user_module')['username'],
                'updated_date'  => date('Y-m-d H:i:s')
            ];

            Modules::where('id', $request->id)->update($data);
            DB::commit();

            return response([
                'success'       => true,
                'message'       => 'Success update module'
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response([
                'success'       => false,
                'message'       => 'Error : '.$th->getMessage()
            ], 500);
        }
    }

    public function apk_update(Request $request)
    {
        $apk = DB::table('auth.auth_version_apk')->where('id', $request->id)->first();
        if($apk && ($request->apk != $apk->name_app)){
            $cekData = DB::table('auth.auth_version_apk')->where('name_app', strtoupper($request->apk))
            ->where('name_app', $request->version)->first();
            if ($cekData) {
                return response([
                    'success' => false,
                    'error'   => 'duplicate',
                    'message' => 'APK [' . strtoupper($request->apk) . '] already exist ' . $request->version 
                ], 200);
            }
        }

      
        DB::beginTransaction();

        try {
            $data = [
                'name_app'        => strtoupper($request->apk),
                'description'          => $request->desc,
                'version'       => $request->version,
                'is_active'     => $request->status == 'active' ? true : false,
                'updated_by'    => session()->get('user_module')['username'],
                'updated_date'  => date('Y-m-d H:i:s')
            ];

            Apk::where('id', $request->id)->update($data);
            DB::commit();

            return response([
                'success'       => true,
                'message'       => 'Success update Apk'
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response([
                'success'       => false,
                'message'       => 'Error : '.$th->getMessage()
            ], 500);
        }
    }

    public function roles_show()
    {
        $totalData = DB::table('auth.auth_role_module');
        $data = [
            'page_title'    => 'ROLE LIST',
            'totalData'     => $totalData->count(),
            'active'        => $totalData->where('is_active', true)->count(),
            'not_active'    => DB::table('auth.auth_role_module')->where('is_active', false)->count(),
            'listModule'    => DB::table('auth.auth_module')->orderBy('module', 'asc')->get()
        ];
        return view('sso-management.roles.index', compact('data'));
    }

    public function roles_get_data()
    {

        $data = DB::table('auth.auth_role_module')
                    ->join('auth.auth_module', 'auth.auth_role_module.auth_module_id', '=', 'auth.auth_module.id')
                    ->select(
                        'auth.auth_role_module.id',
                        'auth.auth_role_module.role',
                        'auth.auth_role_module.is_active',
                        'auth.auth_module.module'
                    )
                    ->orderBy('auth.auth_module.module', 'asc')
                    ->orderBy('auth.auth_role_module.role', 'asc')
                    ->get();

        return DataTables()->of($data)
            ->editColumn('action', function ($datas) {
                return '<a href="javascript:void(0)" onclick="editData(' . $datas->id . ')"><img src="/img/logo/pencil.png"></a>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function roles_get_count()
    {
        $totalData = DB::table('auth.auth_role_module');
        $data = [
            'totalData'     => $totalData->count(),
            'active'        => $totalData->where('is_active', true)->count(),
            'not_active'    => DB::table('auth.auth_role_module')->where('is_active', false)->count(),
        ];

        return response()->json([
            'data' => $data,
            'success' => true,
            'code' => 200
        ]);
    }

    public function roles_store(Request $request)
    {
        $role = strtoupper($request->role);

        #cek data
        $module     = DB::table('auth.auth_module')->where('id', $request->module)->first();
        $cekData    = DB::table('auth.auth_role_module')
                            ->where('auth_module_id', $request->module)
                            ->where('role', $role)
                            ->first();
        if($cekData){
            return response([
                'success'       => false,
                'error'         => 'duplicate',
                'message'       => 'Role '.$role.' in module '.$module->module.' already exist'
            ], 200);
        }
        DB::beginTransaction();

        try {
            $data = [
                'auth_module_id'    => $request->module,
                'role'              => $role,
                'is_active'         => $request->status == 'active' ? true : false,
                'created_by'        => session()->get('user_module')['username'],
                'created_date'      => date('Y-m-d H:i:s')
            ];
            DB::table('auth.auth_role_module')->insert($data);
            DB::commit();
            return response([
                'success'       => true,
                'message'       => 'Success Add Roles'
            ], 200);

        } catch (\Throwable $th) {
            DB::rollBack();
            return response([
                'success'       => false,
                'message'       => 'Error : '.$th->getMessage()
            ], 500);
        }
    }

    public function roles_edit()
    {
        $data = DB::table('auth.auth_role_module')->where('id', request()->id)->first();
        return response([
            'success'   => true,
            'message'   => 'success',
            'data'      => $data
        ], 200);
    }

    public function roles_update(Request $request)
    {
        $role       = strtoupper($request->role);
        $module     = DB::table('auth.auth_module')->where('id', $request->module)->first();
        $roles      = DB::table('auth.auth_role_module')->where('id', $request->id)->first();
        if($roles && ($role != $roles->role)){
            $cekData    = DB::table('auth.auth_role_module')
                            ->where('auth_module_id', $request->module)
                            ->where('role', $role)
                            ->first();
            if($cekData){
                return response([
                    'success'       => false,
                    'error'         => 'duplicate',
                    'message'       => 'Role '.$role.' in module '.$module->module.' already exist'
                ], 200);
            }
        }

        DB::beginTransaction();

        try {
            $data = [
                'auth_module_id'    => $request->module,
                'role'              => $role,
                'is_active'         => $request->status == 'active' ? true : false,
                'updated_by'        => session()->get('user_module')['username'],
                'updated_date'      => date('Y-m-d H:i:s')
            ];

            DB::table('auth.auth_role_module')->where('id', $request->id)->update($data);
            DB::commit();

            return response([
                'success'       => true,
                'message'       => 'Success Update Roles'
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response([
                'success'       => false,
                'message'       => 'Error : '.$th->getMessage()
            ], 500);
        }
    }


    public function users_get_data()
    {
        $data = DB::table('auth.v_auth_user_personal_show')
                    ->orderBy('auth.v_auth_user_personal_show.username', 'asc')
                    ->get();

        return DataTables()->of($data)->make(true);
    }

    public function users_show()
    {
        $totalData = DB::table('auth.v_auth_user_personal_show');
        $data = [
            'page_title'    => 'USER LIST',
            'totalData'     => $totalData->count(),
            'active'        => $totalData->where('is_active', true)->count(),
            'not_active'    => DB::table('auth.auth_users')->where('is_active', false)->count(),
        ];
        return view('sso-management.users.index', compact('data'));
    }

    public function users_create()
    {
        $data = [
            'entity'        =>  DB::table('auth.auth_entity')->where('is_active', true)->orderBy('entity', 'asc')->get(),
            'type'          =>  DB::table('auth.auth_type')->orderBy('type', 'asc')->get(),
            'division'      =>  DB::table('auth.auth_mst_division')->orderBy('division', 'asc')->get(),
            'department'    =>  DB::table('auth.auth_mst_department')->orderBy('department', 'asc')->get(),
            'position'      =>  DB::table('auth.auth_mst_position')->orderBy('position', 'asc')->get(),
        ];
        return view('sso-management.users.create', compact('data'));
    }

    public function users_detail($id)
    {
        $user = DB::table('auth.auth_users')
                    ->join('auth.auth_personal', 'auth.auth_users.email', '=', 'auth.auth_personal.email')
                    ->join('auth.auth_type', 'auth.auth_personal.auth_type_id', '=', 'auth.auth_type.id')
                    ->leftJoin('auth.auth_entity', 'auth.auth_personal.auth_entity_id', '=', 'auth.auth_entity.id')
                    ->leftJoin('auth.auth_mst_division', 'auth.auth_personal.auth_mst_division_id', '=', 'auth.auth_mst_division.id')
                    ->leftJoin('auth.auth_mst_department', 'auth.auth_personal.auth_mst_department_id', '=', 'auth.auth_mst_department.id')
                    ->leftJoin('auth.auth_mst_position', 'auth.auth_personal.auth_mst_position_id', '=', 'auth.auth_mst_position.id')
                    ->select(
                        'auth.auth_users.username as username',
                        'auth.auth_users.id as id_users',
                        'auth.auth_users.is_active',
                        'auth.auth_personal.*',
                        'auth.auth_type.type',
                        'auth.auth_entity.entity',
                        'auth.auth_mst_division.division',
                        'auth.auth_mst_department.department',
                        'auth.auth_mst_position.position'
                    )
                    ->where('auth.auth_users.id', $id)->first();

        $role  = DB::table('auth.auth_user_x_role_module')
                        ->leftJoin('auth.auth_role_module', 'auth.auth_user_x_role_module.auth_role_module_id', '=', 'auth.auth_role_module.id')
                        ->leftJoin('auth.auth_module', 'auth.auth_role_module.auth_module_id', '=', 'auth.auth_module.id')
                        ->where('auth.auth_user_x_role_module.auth_users_id', $id)->get();
        $module = Modules::where('is_active', true)->orderBy('module', 'asc')->get();

        return view('sso-management.users.show', compact('user', 'role', 'module'));
    }

    public function users_store(Request $request)
    {
        $errors = [];

        if ($request->nik) {
            $cekData = UserAuthPersonal::where('nik', $request->nik)->first();
            if ($cekData) {
                $errors[] = [
                    'tags'    => 'nikError',
                    'target'  => 'nik',
                    'message' => "User with nik [". $request->nik ."] already exists"
                ];
            }
        }

        if ($request->email) {
            $cekData = UserAuthPersonal::where('email', $request->email)->first();
            if ($cekData) {
                $errors[] = [
                    'tags'    => 'emailError',
                    'target'  => 'email',
                    'message' => "User with email [". $request->email ."] already exists"
                ];
            }
        }

        if ($request->username) {
            $cekData = UserAuthPersonal::whereRaw('LOWER(username) = ?', [strtolower($request->username)])->first();
            if ($cekData) {
                $errors[] = [
                    'tags'    => 'usernameError',
                    'target'  => 'username',
                    'message' => "User with username [". $request->username ."] already exists"
                ];
            }
        }

        if ($request->phone) {
            $cekData = UserAuthPersonal::where('phone', $request->phone)->first();
            if ($cekData) {
                $errors[] = [
                    'tags'    => 'phoneError',
                    'target'  => 'phone',
                    'message' => "User with phone number : [". $request->phone ."] already exists"
                ];
            }
        }

        if ($request->whatsapp) {
            $cekData = UserAuthPersonal::where('wa_number', $request->whatsapp)->first();
            if ($cekData) {
                $errors[] = [
                    'tags'    => 'whatsappError',
                    'target'  => 'whatsapp',
                    'message' => "User with whatsapp number : [". $request->whatsapp ."] already exists"
                ];
            }
        }

        if (!empty($errors)) {
            return response()->json([
                'success' => false,
                'errors'  => $errors,
                'code'    => 409
            ]);
        }

        try {
            DB::beginTransaction();

            $paramUser = [
                'username'          => $request->username,
                'email'             => $request->email,
                'password'          => sha1($request->password),
                'is_active'         => $request->status == 'active' ? 1 : 0,
                'created_by'        => session()->get('user_module')['username'],
                'created_date'      => now(),
            ];

            $paramPersonal = [
                'nik'                   => $request->nik,
                'fullname'              => $request->fullname,
                'email'                 => $request->email,
                'address'               => $request->address,
                'phone'                 => $request->phone,
                'wa_number'             => $request->whatsapp,
                'auth_type_id'          => $request->type,
                'auth_entity_id'        => $request->entity,
                'auth_mst_division_id'  => $request->division,
                'auth_mst_department_id'=> $request->department,
                'auth_mst_position_id'  => $request->position,
                'validity_period'       => $request->validity,
                'valid_till'            => $request->validity == 'Permanent' ? null : $request->validTill,
                'created_by'            => session()->get('user_module')['username'],
                'created_date'          => now(),
            ];

            UserAuth::create($paramUser);
            UserPersonal::create($paramPersonal);

            DB::commit();

            return response()->json([
                'success'       => true,
                'message'       => 'Success create user',
                'redirect_url'  => route('users.index'),
                'code'          => 200
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $th->getMessage(),
                'code'    => 500
            ]);
        }
    }

    public function user_edit($id)
    {
        $user = UserAuth::find($id);
        $data = [
            'entity'        =>  DB::table('auth.auth_entity')->orderBy('entity', 'asc')->get(),
            'type'          =>  DB::table('auth.auth_type')->orderBy('type', 'asc')->get(),
            'division'      =>  DB::table('auth.auth_mst_division')->orderBy('division', 'asc')->get(),
            'department'    =>  DB::table('auth.auth_mst_department')->orderBy('department', 'asc')->get(),
            'position'      =>  DB::table('auth.auth_mst_position')->orderBy('position', 'asc')->get(),
        ];
        return view('sso-management.users.edit', compact('user', 'data'));
    }

    public function user_update(Request $request)
    {
        $errors = [];

        if ($request->nik != $request->nik_old) {
            $cekData = UserAuthPersonal::where('nik', $request->nik)->first();
            if ($cekData) {
                $errors[] = [
                    'tags'    => 'nikError',
                    'target'  => 'nik',
                    'message' => "User with nik [". $request->nik ."] already exists"
                ];
            }
        }

        if ($request->email != $request->email_old) {
            $cekData = UserAuthPersonal::where('email', $request->email)->first();
            if ($cekData) {
                $errors[] = [
                    'tags'    => 'emailError',
                    'target'  => 'email',
                    'message' => "User with email [". $request->email ."] already exists"
                ];
            }
        }

        if ($request->username != $request->username_old) {
            $cekData = UserAuthPersonal::whereRaw('LOWER(username) = ?', [strtolower($request->username)])->first();
            if ($cekData) {
                $errors[] = [
                    'tags'    => 'usernameError',
                    'target'  => 'username',
                    'message' => "User with username [". $request->username ."] already exists"
                ];
            }
        }

        if ($request->phone != $request->phone_old) {
            $cekData = UserAuthPersonal::where('phone', $request->phone)->first();
            if ($cekData) {
                $errors[] = [
                    'tags'    => 'phoneError',
                    'target'  => 'phone',
                    'message' => "User with phone number : [". $request->phone ."] already exists"
                ];
            }
        }

        if ($request->whatsapp != $request->whatsapp_old) {
            $cekData = UserAuthPersonal::where('wa_number', $request->whatsapp)->first();
            if ($cekData) {
                $errors[] = [
                    'tags'    => 'whatsappError',
                    'target'  => 'whatsapp',
                    'message' => "User with whatsapp number : [". $request->whatsapp ."] already exists"
                ];
            }
        }

        if (!empty($errors)) {
            return response()->json([
                'success' => false,
                'errors'  => $errors,
                'code'    => 409
            ]);
        }

        try {
            DB::beginTransaction();

            $paramUser = [
                'username'          => $request->username,
                'email'             => $request->email,
                'is_active'         => $request->status == 'active' ? 1 : 0,
                'updated_by'        => session()->get('user_module')['username'],
                'updated_date'      => date('Y-m-d H:i:s'),
            ];

            #untuk tabel Personal
            $paramPersonal = [
                'nik'                   => $request->nik,
                'fullname'              => $request->fullname,
                'email'                 => $request->email,
                'address'               => $request->address,
                'phone'                 => $request->phone,
                'wa_number'             => $request->whatsapp,
                'auth_type_id'          => $request->type,
                'auth_entity_id'        => $request->entity,
                'auth_mst_division_id'  => $request->division,
                'auth_mst_department_id'=> $request->department,
                'auth_mst_position_id'  => $request->position,
                'validity_period'       => $request->validity,
                'valid_till'            => $request->validTill,
                'updated_by'            => session()->get('user_module')['username'],
                'updated_date'          => date('Y-m-d H:i:s'),
            ];

            #insert user
            UserAuth::where('id', $request->id)->update($paramUser);

            #insert user Personal
            UserPersonal::where('id', $request->id_personal)->update($paramPersonal);

            DB::commit();
            return response()->json([
                'success'       => true,
                'message'       => 'Success update user',
                'redirect_url'  => route('users.index'),
                'code'          => 200
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $th->getMessage(),
                'code'    => 500
            ]);
        }
    }

    public function get_data()
    {
        $data = DB::table('auth.auth_user_x_role_module')
                    ->leftJoin('auth.auth_role_module', 'auth.auth_user_x_role_module.auth_role_module_id', '=', 'auth.auth_role_module.id')
                    ->leftJoin('auth.auth_module', 'auth.auth_role_module.auth_module_id', '=', 'auth.auth_module.id')
                    ->select(
                        'auth.auth_user_x_role_module.*',
                        'auth.auth_user_x_role_module.id as user_role_module_id',
                        'auth.auth_role_module.*',
                        'auth.auth_module.*'
                    )
                    ->where('auth.auth_user_x_role_module.auth_users_id', request()->id)
                    ->orderBy('auth_module.module', 'asc')
                    ->get();


        return DataTables()->of($data)
            ->editColumn('delete', function ($datas) {
                return '<a href="javascript:void(0)" onclick="deleteData(' . $datas->user_role_module_id . ')"><i class="fas fa-times" style="color: red !important;cursor: pointer"></i></a>';
            })
            ->rawColumns(['delete'])
            ->make(true);
    }

    public function get_roles()
    {
        $data = DB::table('auth.auth_role_module')
                    ->where('auth.auth_role_module.auth_module_id', request()->id)
                    ->where('auth.auth_role_module.is_active', true)
                    ->select('auth.auth_role_module.*')
                    ->whereNotIn('auth.auth_role_module.id', function($query) {
                        $query->select('auth.auth_user_x_role_module.auth_role_module_id')
                            ->from('auth.auth_user_x_role_module')
                            ->where('auth.auth_user_x_role_module.auth_users_id', request()->user_id);
                    })
                    ->orderBy('auth.auth_role_module.role', 'asc')
                    ->get();


        return response([
            'status' => true,
            'message' => 'success',
            'data' => $data
        ], 200);
    }

    public function update_module()
    {
        DB::beginTransaction();
        try {
            DB::table('auth.auth_user_x_role_module')->insert([
                'auth_users_id'         => request()->id,
                'auth_role_module_id'   => request()->role,
                'created_by'            => session()->get('user_module')['username'],
                'created_date'          => date('Y-m-d H:i:s'),
            ]);

            #buat is confirm
            $isConfirm = UserAuth::where('id', request()->id)->value('is_confirm');

            if (!$isConfirm) {
                UserAuth::where('id', request()->id)->update([
                    'is_confirm'    => true,
                    'updated_by'    => session()->get('user_module')['username'],
                    'updated_date'  => date('Y-m-d H:i:s'),
                ]);
            }

            DB::commit();
            return response([
                'status'    => true,
                'message'   => 'Success Add Module'
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response([
                'status'    => false,
                'message'   => 'Error : '.$th->getMessage()
            ], 500);
        }
    }

    public function delete_module()
    {
        DB::beginTransaction();
        try {
            DB::table('auth.auth_user_x_role_module')->where('id', request()->id)->delete();
            DB::commit();
            return response([
                'status'    => true,
                'message'   => 'Success Delete Module'
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response([
                'status'    => false,
                'message'   => 'Error : '.$th->getMessage()
            ], 500);
        }
    }

    public function update_password()
    {
        DB::beginTransaction();
        try {
            $param = [
                'password' => hash('sha1',request()->password),
            ];
            DB::table('auth.auth_users')->where('id', request()->id)->update($param);
            DB::commit();
            return response([
                'status'    => true,
                'message'   => 'Success update password'
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
