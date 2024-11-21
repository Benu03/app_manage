<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Helpers\Bridge;
use App\Http\Helpers\Builder;
use App\Http\Helpers\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;


class AccessController extends Controller
{

    #login
    public function login(Request $request) {
        $validated = Validator::access_login($request);
        if($validated->fails()){
            return redirect()->route('login_page')->withErrors($validated)->withInput();
        } else {
            $params = [
                'url' => config('_static.api_full_url').'/auth/login',
                'body' => [
                    'username'  => $request->username,
                    'password'  => $request->password,
                ]
            ];

            $response = Bridge::BuildCurlApiPA($params);
            if($response['status'] == 200 && $response['message'] == 'Your account needs to be confirmed|Please confirm your account by following the provided instructions'){
                $msg  = explode('|', $response['message']);
                return redirect()->route('login_page')->withErrors(['password'=>$msg[1]]);
            }else if($response['status'] == 200 && isset($response['data']['user_data']) && $response['data']['user_data']){
                $params = [
                    'session_token' => $response['data']['session']['session_token'],
                    'id'            => $response['data']['user_data']['id'],
                    'username'      => $response['data']['user_data']['username'],
                    'full_name'     => $response['data']['user_data']['full_name'],
                    'email'         => $response['data']['user_data']['email'],
                    'nik'           => $response['data']['user_data']['nik'],
                    'wa_number'     => $response['data']['user_data']['wa_number'],
                ];

                $targetModuleName = "SSO";
                $params['module']   = '';
                $params['role']     = '';
                foreach($response['data']['module'] as $row){
                    if($row['module'] == $targetModuleName){
                        $params['module']   = $row['module'];
                        $params['role']     = $row['role'];
                    }
                }

                if($params['module'] != $targetModuleName){
                    return redirect()->route('login_page')->withErrors(['password'=>'This user does not have the access rights.']);
                }else{
                    Session::put('user', $params);
                    if(isset($request->remember) && !empty($request->remember)){
                        setcookie("username", $request->username, time() + (86400 * 30), "/", "", isset($_SERVER["HTTPS"]), true);
                        setcookie("password", $request->password, time() + (86400 * 30), "/", "", isset($_SERVER["HTTPS"]), true);
                    }
                    return redirect()->route('home');
                }

            }else if($response['status'] == 401){
                $msg  = explode('|', $response['message']);
                return redirect()->route('login_page')->withErrors(['password'=>$msg[1]]);
            }else{
                return redirect()->route('login_page')->withErrors(['password'=>'login failed']);
            }
        }

    }

    public function reset(Request $request) {
        $validated = Validator::email_reset($request);
        if($validated->fails()){
            return redirect()->route('reset_page')->withErrors($validated)->withInput();
        }else {
            $params = [
                'url' => config('_static.api_full_url').'/auth/forgot',
                'body' => [
                    'email'     => $request->email,
                    'reset_by'  => $request->otp_code,
                ]
            ];
            $response = Bridge::BuildCurlApiPA($params);
            $via = '';
            if($request->otp_code == 'EMAIL'){
                $via = 'Email';
            }else{
                $via = 'Whatsapp';
            }

            if($response['status'] == 200){
                $data['username']   = $request->email;
                $data['otp']        = $response['data']['otp'];
                $data['message']    = $response['message'];
                $data['via']        = $via;
                return redirect()->route('otp_page')->with($data);
            }else if($response['status'] == 401){
                return redirect()->route('reset_page')->withErrors(['email'=>'No account found with that email address.']);
            }
        }
    }

    public function reset_password(Request $request) {
        $validated = Validator::password_reset($request);
        if($validated->fails()){
            return redirect()->route('reset_password_page')->withErrors($validated)->withInput();
        }else {
            $params = [
                'url' => config('_static.api_full_url').'/auth/reset-password',
                'body' => [
                    'username'      => $request->email,
                    'new_password'  => $request->password,
                ]
            ];
            $response = Bridge::BuildCurlApiPA($params);

            if($response['status'] == 200){
                return redirect()->route('success_reset')->with(['message' => $response['message']]);
            }else if($response['status'] == 401){
                return redirect()->route('reset_page')->withErrors(['email'=>$response['message']]);
            }
        }
    }

    #logout
    public function logout(Request $request) {
        $params = [
            'url' => config('_static.api_full_url').'auth/logout',
            'body' => [
                'username'      => session()->get('user_module')['username'],
                'session_token' => session()->get('user_module')['session_token'],
            ]
        ];

        $response = Bridge::BuildCurlApiPA($params);

        if($response['status'] == 200){
            session()->flush();
            return redirect(config('static.url_portal_ts3_main').'login');
        }

    }


    public function lobby(Request $request) {
             
            session()->flush();
            return redirect(config('static.url_portal_ts3_main').'/lobby');

    }





    public function sendOtp(Request $request) {
        if($request->otp != $request->otp_old){
            return redirect()->route('otp_page')->withErrors(['otp' => 'otp not match']);
        }else{
            return redirect()->route('reset_password_page')->with(
                [
                    'otp' => $request->otp,
                    'username' => $request->username
                ]);
        }
    }

}
