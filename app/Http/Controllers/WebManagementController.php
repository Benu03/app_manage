<?php

namespace App\Http\Controllers;

use App\Http\Helpers\Validator;
use App\Models\DevModel;
use App\Models\MobileVersion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator as FacadesValidator;
use Illuminate\Support\Facades\Log;

class WebManagementController extends Controller
{
    public function index_web()
    {
        $totalData = DB::table('portal.portal_app');
        $data = [
            'page_title'    => 'WEB APPLICATION LIST',
            'totalData'     => $totalData->count(),
            'active'        => $totalData->where('is_active', true)->count(),
            'not_active'    => DB::table('portal.portal_app')->where('is_active', false)->count(),
        ];
        return view('app_management.webapp.index', compact('data'));
    }

    public function index_mobile()
    {
        $totalData = DB::table('portal.mobile_app');
        $data = [
            'page_title'    => 'MOBILE APPLICATION LIST',
            'totalData'     => $totalData->count(),
            'active'        => $totalData->where('is_active', true)->count(),
            'not_active'    => DB::table('portal.mobile_app')->where('is_active', false)->count(),
        ];
        return view('app_management.mobileapp.index', compact('data'));
    }

    public function create_web()
    {
        $data = [
            'listModule' =>  DB::table('auth.auth_module')->orderBy('module', 'asc')->get()
        ];

        return view('app_management.webapp.create', compact('data'));
    }


    public function edit($id)
    {
        try {
            $portal = DB::table('portal.portal_app')->where('id', $id)->first();
            $data = [
                'portal'        => $portal,
                'listModule'    => DB::table('auth.auth_module')->orderBy('module', 'asc')->get(),
                'portalModule'  => DB::table('portal.portal_module as pm')
                                    ->join('auth.auth_module as am', 'pm.auth_module_id', '=', 'am.id')
                                    ->where('pm.portal_app_id', $id)
                                    ->select('am.id', 'am.module')
                                    ->get()
            ];

            return view('app_management.webapp.edit', compact('data'));
        } catch (\Exception $e) {
            session()->flash('error', 'Something goes wrong!!');
            return redirect()->back();
        }
    }


    public function app_edit($id)
    {
        try {
            $mobile = DB::table('portal.mobile_app')->where('id', $id)->first();
            $data = [
                'mobile'        => $mobile,
                'listModule'    => DB::table('auth.auth_module')->orderBy('module', 'asc')->get(),
                'listDev'       => DB::table('portal.mobile_development_url')
                                        ->where('mobile_app_id', $id)
                                        ->orderBy('created_date', 'desc')
                                        ->get(),
                'listProdAndro' => DB::table('portal.mobile_version')
                                        ->where('mobile_app_id', $id)
                                        ->where('type', 'android')
                                        ->orderBy('version', 'asc')
                                        ->get(),
                'listProdIOS'   => DB::table('portal.mobile_version')->where('mobile_app_id', $id)
                                        ->where('type', 'ios')
                                        ->orderBy('version', 'asc')
                                        ->get(),
                'mobileModule'  => DB::table('portal.mobile_module as pm')
                                    ->join('auth.auth_module as am', 'pm.auth_module_id', '=', 'am.id')
                                    ->where('pm.mobile_app_id', $id)
                                    ->select('am.id', 'am.module')
                                    ->get()
            ];

            return view('app_management.mobileapp.edit', compact('data'));
        } catch (\Exception $e) {
            session()->flash('error', 'Something goes wrong!!');
            return redirect()->back();
        }
    }


    public function mobileCreate()
    {
        $data = [
            'listModule'    => DB::table('auth.auth_module')->orderBy('module', 'asc')->get()
        ];
        return view('app_management.mobileapp.create', compact('data'));
    }

    #create web management - web modul
    public function web_store(Request $request)
    {
        $validated = FacadesValidator::make($request->all(), [
            'app'           => 'required',
            'status'        => 'required',
            'description'   => 'required',
            'logo'          => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if($validated->fails()) {
            return response()->json([
                'success'   => false,
                'message'   => 'Validation failed.',
                'errors'    => $validated->errors()->all(),
                'code'      => 422
            ]);
        }

        $cekData = DB::table('portal.portal_app')->where('app', strtoupper($request->app))->first();
        if($cekData){
            return response()->json([
                'success'   => false,
                'message'   => "App [". strtoupper($request->app) ."] already exist",
                'code'      => 409
            ]);
        }

        try {
            DB::beginTransaction();
            $filename = '';
            if($request->hasFile('croppedLogo')){
                $filename = $request->file('croppedLogo')->getClientOriginalName();
                $request->file('croppedLogo')->move(public_path('img/portal-app'), $filename);
            }

            if(!$request->hasFile('croppedLogo') && $request->hasFile('logo')){
                $filename = $request->file('logo')->getClientOriginalName();
                $request->file('logo')->move(public_path('img/portal-app'), $filename);
            }

            $param = [
                'app'           => strtoupper($request->app),
                'dev_url'       => $request->dev_url,
                'prod_url'      => $request->prod_url,
                'image_url'     => $filename == '' ? null : '/'.$filename,
                'description'   => $request->description,
                'is_active'     => $request->status == 'active' ? true : false,
                'created_by'    => session()->get('user_module')['username'],
                'created_date'  => now(),
            ];

            $getId = DB::table('portal.portal_app')->insertGetId($param);

            if($request->module_ids){
                $totalModule = count($request->module_ids);

                for($i = 0; $i < $totalModule; $i++){
                    DB::table('portal.portal_module')->insert([
                        'portal_app_id'     => $getId,
                        'auth_module_id'    => $request->module_ids[$i],
                        'created_by'        => session()->get('user_module')['username'],
                        'created_date'      => now(),
                    ]);
                }
            }
            DB::commit();

            return response()->json([
                'success'       => true,
                'message'       => 'Success add app',
                'redirect_url'  => route('web-management.index'),
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

    #update web management - web modul
    public function web_update(Request $request)
    {
        $validated = FacadesValidator::make($request->all(), [
            'app'           => 'required',
            'status'        => 'required',
            'description'   => 'required',
            'logo'          => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if($validated->fails()) {
            return response()->json([
                'success'   => false,
                'message'   => 'Validation failed.',
                'errors'    => $validated->errors()->all(),
                'code'      => 422
            ]);
        }

        if($request->app != $request->app_old){
            $cekData = DB::table('portal.portal_app')->where('app', strtoupper($request->app))->first();
            if($cekData){
                return response()->json([
                    'success'   => false,
                    'message'   => "App [". strtoupper($request->app) ."] already exist",
                    'code'      => 409
                ]);
            }
        }

        try {
            DB::beginTransaction();
            $filename = '';

            $detailData = DB::table('portal.portal_app')->where('id', $request->id)->first();
            $param['image_url'] = $detailData->image_url;

            if($request->hasFile('croppedLogo')){
                #unlink data terdahulu
                if($detailData->image_url){
                    $imagePath = public_path('img/portal-app'.$detailData->image_url);
                    if (file_exists($imagePath)) {
                        unlink($imagePath);
                    }
                }

                #uplodat logo cropped
                $filename   = $request->file('croppedLogo')->getClientOriginalName();
                $request->file('croppedLogo')->move(public_path('img/portal-app'), $filename);

                $param['image_url'] = '/'.$filename;
            }

            if(!$request->hasFile('croppedLogo') && $request->hasFile('logo')){
                #unlink data terdahulu
                if($detailData->image_url){
                    $imagePath = public_path('img/portal-app'.$detailData->image_url);
                    if (file_exists($imagePath)) {
                        unlink($imagePath);
                    }
                }

                #upload logo non cropped
                $filename   = $request->file('logo')->getClientOriginalName();
                $request->file('logo')->move(public_path('img/portal-app'), $filename);

                $param['image_url'] = '/'.$filename;
            }

            $param = array_merge($param, [
                'app'           => strtoupper($request->app),
                'dev_url'       => $request->dev_url,
                'prod_url'      => $request->prod_url,
                'description'   => $request->description,
                'is_active'     => $request->status == 'active' ? true : false,
                'updated_by'    => session()->get('user_module')['username'],
                'updated_date'  => date('Y-m-d H:i:s'),
            ]);

            #update data module 

            DB::table('portal.portal_app')->where('id', $request->id)->update($param);


            if ($request->has('module_ids')) {
                $fileImage = isset($param['image_url']) ? $param['image_url'] : '/default-logo.png';
                Log::info($fileImage);
                $urlImagemodule = config('static.url_puninar_app') . 'img/portal-app' . $fileImage;
            
                DB::table('auth.auth_module')->whereIn('id', $request->module_ids)
                    ->update([
                        'image_module' => $urlImagemodule,
                        'platform' => 'web'
                    ]);
            }
            


            #cek update modul
            if($request->module_ids){
                $this->updateModules($request, $request->id, 'web-app');
            }

            DB::commit();
            return response()->json([
                'success'       => true,
                'message'       => 'Success update app',
                'redirect_url'  => route('web-management.index'),
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


    #create web management - app modul
    public function app_store(Request $request)
    {
        $validated = FacadesValidator::make($request->all(), [
            'app'           => 'required',
            'status'        => 'required',
            'description'   => 'required',
            'logo'          => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if($validated->fails()) {
            return response()->json([
                'success'   => false,
                'message'   => 'Validation failed.',
                'errors'    => $validated->errors()->all(),
                'code'      => 422
            ]);
        }

        $dataDev           = json_decode($request->input('tableDataDev'), true);
        $dataProdAndro     = json_decode($request->input('tableDataProdAndro'), true);
        $dataProdIOS       = json_decode($request->input('tableDataProdIOS'), true);

        $cekData = DB::table('portal.mobile_app')->where('app', strtoupper($request->app))->first();
        if($cekData){
            return response()->json([
                'success'   => false,
                'message'   => "App [". strtoupper($request->app) ."] already exist",
                'code'      => 409
            ]);
        }

        try {
            DB::beginTransaction();
            $filename = '';
            if($request->hasFile('croppedLogo')){
                $filename   = $request->file('croppedLogo')->getClientOriginalName();
                $request->file('croppedLogo')->move(public_path('img/mobile-app'), $filename);
            }

            if(!$request->hasFile('croppedLogo') && $request->hasFile('logo')){
                $filename   = $request->file('logo')->getClientOriginalName();
                $request->file('logo')->move(public_path('img/mobile-app'), $filename);
            }

            $param = [
                'app'               => strtoupper($request->app),
                'prod_android_url'  => $request->url_android,
                'prod_ios_url'      => $request->url_app_store,
                'image_url'         => $filename == '' ? null : '/'.$filename,
                'description'       => $request->description,
                'is_active'         => $request->status == 'active' ? true : false,
                'note'              => $request->note,
                'created_by'        => session()->get('user_module')['username'],
                'created_date'      => date('Y-m-d H:i:s'),
            ];

            $getId = DB::table('portal.mobile_app')->insertGetId($param);

            if($request->module_ids){
                $totalModule = count($request->module_ids);

                for($i = 0; $i < $totalModule; $i++){
                    DB::table('portal.mobile_module')->insert([
                        'mobile_app_id'     => $getId,
                        'auth_module_id'    => $request->module_ids[$i],
                        'created_by'        => session()->get('user_module')['username'],
                        'created_date'      => date('Y-m-d H:i:s'),
                    ]);
                }
            }

            if($dataDev){
                foreach ($dataDev as $itemDev) {
                    DB::table('portal.mobile_development_url')->insert([
                        'mobile_app_id' => $getId,
                        'url'           => $itemDev['url'],
                        'version'       => $itemDev['version'],
                        'remark'        => $itemDev['remark'],
                        'is_active'     => $itemDev['status'] == 'Active' ? true : false,
                        'created_by'    => session()->get('user_module')['username'],
                        'created_date'  => date('Y-m-d H:i:s'),
                    ]);
                }
            }

            if($dataProdAndro || $dataProdIOS){
                foreach ($dataProdAndro as $itemAndro) {
                    DB::table('portal.mobile_version')->insert([
                        'mobile_app_id' => $getId,
                        'prod_url'      => $request->url_android,
                        'version'       => $itemAndro['version'],
                        'remark'        => $itemAndro['remark'],
                        'is_active'     => $itemAndro['status'] == 'Active' ? true : false,
                        'type'          => 'android',
                        'created_by'    => session()->get('user_module')['username'],
                        'created_date'  => date('Y-m-d H:i:s'),
                    ]);
                }

                foreach ($dataProdIOS as $itemIOS) {
                    DB::table('portal.mobile_version')->insert([
                        'mobile_app_id' => $getId,
                        'prod_url'      => $request->url_app_store,
                        'version'       => $itemIOS['version'],
                        'remark'        => $itemIOS['remark'],
                        'is_active'     => $itemIOS['status'] == 'Active' ? true : false,
                        'type'          => 'ios',
                        'created_by'    => session()->get('user_module')['username'],
                        'created_date'  => date('Y-m-d H:i:s'),
                    ]);
                }
            }

            DB::commit();
            return response()->json([
                'success'       => true,
                'message'       => 'Success add app',
                'redirect_url'  => route('mobile-management.index'),
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

    public function app_update(Request $request)
    {
        $validated = FacadesValidator::make($request->all(), [
            'app'           => 'required',
            'status'        => 'required',
            'description'   => 'required',
            'logo'          => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if($validated->fails()) {
            return response()->json([
                'success'   => false,
                'message'   => 'Validation failed.',
                'errors'    => $validated->errors()->all(),
                'code'      => 422
            ]);
        }

        $dataDev           = json_decode($request->input('tableDataDev'), true);
        $dataProdAndro     = json_decode($request->input('tableDataProdAndro'), true);
        $dataProdIOS       = json_decode($request->input('tableDataProdIOS'), true);

        if($request->app != $request->app_old){
            $cekData = DB::table('portal.mobile_app')->where('app', strtoupper($request->app))->first();
            if($cekData){
                return response()->json([
                    'success'   => false,
                    'message'   => "App [". strtoupper($request->app) ."] already exist",
                    'code'      => 409
                ]);
            }
        }

        try {
            DB::beginTransaction();
            $filename = '';

            $detailData = DB::table('portal.mobile_app')->where('id', $request->id)->first();
            $param['image_url'] = $detailData->image_url;

            if($request->hasFile('croppedLogo')){
                #unlink data terdahulu
                if($detailData->image_url){
                    $imagePath = public_path('img/mobile-app'.$detailData->image_url);
                    if (file_exists($imagePath)) {
                        unlink($imagePath);
                    }
                }

                #uplodat logo cropped
                $filename   = $request->file('croppedLogo')->getClientOriginalName();
                $request->file('croppedLogo')->move(public_path('img/mobile-app'), $filename);

                $param['image_url'] = '/'.$filename;
            }

            if(!$request->hasFile('croppedLogo') && $request->hasFile('logo')){
                #unlink data terdahulu
                if($detailData->image_url){
                    $imagePath = public_path('img/mobile-app'.$detailData->image_url);
                    if (file_exists($imagePath)) {
                        unlink($imagePath);
                    }
                }

                #upload logo non cropped
                $filename   = $request->file('logo')->getClientOriginalName();
                $request->file('logo')->move(public_path('img/mobile-app'), $filename);

                $param['image_url'] = '/'.$filename;
            }

            $param = array_merge($param, [
                'app'               => strtoupper($request->app),
                'description'       => $request->description,
                'is_active'         => $request->status == 'active' ? true : false,
                'prod_ios_url'      => $request->url_app_store,
                'prod_android_url'  => $request->url_android,
                'note'              => $request->note,
                'updated_by'        => session()->get('user_module')['username'],
                'updated_date'      => date('Y-m-d H:i:s'),
            ]);

            #update data
            DB::table('portal.mobile_app')->where('id', $request->id)->update($param);

            #cek update modul
            if($request->module_ids){
                $this->updateModules($request, $request->id, 'mobile-app');
            }

            #cek update development
            if($dataDev){
                $this->updateDataDev($dataDev, $request->id);
            }else{
                DevModel::where('mobile_app_id', $request->id)->delete();
            }

            #cek update prod android
            if($dataProdAndro){
                $this->updateDataProd($dataProdAndro, $request->id, $request->url_android, 'android');
            }else{
                MobileVersion::where('mobile_app_id', $request->id)->where('type', 'android')->delete();
            }

            #cek update prod ios
            if($dataProdIOS){
                $this->updateDataProd($dataProdIOS, $request->id, $request->url_app_store, 'ios');
            }else{
                MobileVersion::where('mobile_app_id', $request->id)->where('type', 'ios')->delete();
            }

            DB::commit();
            return response()->json([
                'success'       => true,
                'message'       => 'Success update app',
                'redirect_url'  => route('mobile-management.index'),
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


    public function updateModules(Request $request, $getId, $type)
    {
        $table = $type == 'web-app' ? 'portal.portal_module' : 'portal.mobile_module';
        $column = $type == 'web-app' ? 'portal_app_id' : 'mobile_app_id';

        $existingModules = DB::table($table)
                            ->where($column, $getId)
                            ->pluck('auth_module_id')
                            ->toArray();

        // Modul baru
        $newModules = $request->module_ids ?? [];

        // Modul yang ditambahkan
        $modulesToAdd = array_diff($newModules, $existingModules);

        // Modul yang dihapus
        $modulesToDelete = array_diff($existingModules, $newModules);

        // Tambahkan modul baru
        foreach ($modulesToAdd as $moduleId) {
            DB::table($table)->insert([
                $column            => $getId,
                'auth_module_id'   => $moduleId,
                'created_by'       => session()->get('user_module')['username'],
                'created_date'     => now(),
            ]);
        }

        // Hapus modul yang tidak ada
        DB::table($table)
            ->where($column, $getId)
            ->whereIn('auth_module_id', $modulesToDelete)
            ->delete();
    }

    public function updateDataProd($data, $id, $url, $type)
    {
        $existingData = DB::table('portal.mobile_version')
                            ->where('mobile_app_id', $id)
                            ->where('type', $type)
                            ->pluck('id')
                            ->toArray();

        $receivedIds = [];
        foreach ($data as $value) {
            $receivedIds[] = $value['id'];
            if(!empty($value['id'])){
                MobileVersion::where('id', $value['id'])->update([
                    'version'       => $value['version'],
                    'is_active'     => $value['status'] == 'Active' ? true : false,
                    'remark'        => $value['remark'],
                    'prod_url'      => $url,
                    'updated_by'    => session()->get('user_module')['username'],
                    'updated_date'  => date('Y-m-d H:i:s'),
                ]);
            }else{
                MobileVersion::insert([
                    'mobile_app_id' => $id,
                    'version'       => $value['version'],
                    'is_active'     => $value['status'] == 'Active' ? true : false,
                    'remark'        => $value['remark'],
                    'prod_url'      => $url,
                    'type'          => $type,
                    'created_by'    => session()->get('user_module')['username'],
                    'created_date'  => date('Y-m-d H:i:s'),
                ]);
            }
        }

        #cek delete data
        $idsToDelete = array_diff($existingData, $receivedIds);

        #delete data
        MobileVersion::whereIn('id', $idsToDelete)->delete();
    }


    public function updateDataDev($data, $id)
    {
        $existingData = DB::table('portal.mobile_development_url')
                            ->where('mobile_app_id', $id)
                            ->pluck('id')
                            ->toArray();

        $receivedIds = [];
        foreach ($data as $value) {
            $receivedIds[] = $value['id'];
            if(!empty($value['id'])){
                DevModel::where('id', $value['id'])->update([
                    'url'           => $value['url'],
                    'version'       => $value['version'],
                    'remark'        => $value['remark'],
                    'is_active'     => $value['status'] == 'Active' ? true : false,
                    'updated_by'    => session()->get('user_module')['username'],
                    'updated_date'  => date('Y-m-d H:i:s'),
                ]);
            }else{
                DevModel::insert([
                    'mobile_app_id'    => $id,
                    'url'              => $value['url'],
                    'version'          => $value['version'],
                    'remark'           => $value['remark'],
                    'is_active'        => $value['status'] == 'Active' ? true : false,
                    'created_by'       => session()->get('user_module')['username'],
                    'created_date'     => date('Y-m-d H:i:s'),
                ]);
            }
        }

        #cek delete data
        $idsToDelete = array_diff($existingData, $receivedIds);

        #delete data
        DevModel::whereIn('id', $idsToDelete)->delete();
    }

    public function get_data_web()
    {
        $data = DB::table('portal.portal_app')->orderBy('app', 'asc')->get();
        foreach ($data as $app) {
            $imagePath = public_path('img/portal-app' . $app->image_url);
            if (!file_exists($imagePath)) {
                $app->image_url = '/default-logo.png';
            }
        }
        return DataTables()->of($data)->make(true);
    }

    public function get_data_app()
    {
        $data = DB::table('portal.mobile_app')->orderBy('app', 'asc')->get();
        foreach ($data as $app) {
            $imagePath = public_path('img/mobile-app' . $app->image_url);
            if (file_exists($imagePath)) {
                $app->image_url = $app->image_url;
            }else{
                $app->image_url = '/default-logo.png';
            }
        }
        return DataTables()->of($data)->make(true);
    }

}
