<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

use function Laravel\Prompts\table;

class WelcomeController extends Controller
{
    public function get_data_portal()
    {
        $type = '';
        if(request()->type == 'mobile'){
            $data       = DB::table('portal.mobile_app')->orderBy('app', 'asc')->where('is_active', true)->get();
            $type       = 'mobile-app';

        }else if(request()->type == 'web'){
            $data = DB::table('portal.portal_app')->orderBy('app', 'asc')->where('is_active', true)->get();
            $type = 'portal-app';
        }



        foreach ($data as $item) {
            if (!file_exists(public_path('img/' . $type . $item->image_url)) || $item->image_url == '' || $item->image_url == null) {
                $item->image_url = '/default-logo.png';
            }
        }

        return response()->json([
            'data' => $data
        ], 200);
    }

    public function get_detail_app()
    {
        $dataDev        = DB::table('portal.mobile_development_url')->where('mobile_app_id', request()->id)->where('is_active', true)->get();
        $dataProdAndro  = DB::table('portal.mobile_version')->where('mobile_app_id', request()->id)->where('type', 'android')->where('is_active', true)->get();
        $dataProdIos    = DB::table('portal.mobile_version')->where('mobile_app_id', request()->id)->where('type', 'ios')->where('is_active', true)->get();
        return response()->json([
            'dataDev'       => $dataDev,
            'dataProdAndro' => $dataProdAndro,
            'dataProdIos'   => $dataProdIos
        ], 200);
    }
}
