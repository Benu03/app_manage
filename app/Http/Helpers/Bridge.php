<?php

namespace App\Http\Helpers;
use GuzzleHttp\Psr7\Request as GuzzleRequest;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Session;

class Bridge {

    #login
    public static function BuildCurlApiPA($params,$headers = null,$menu = null) {
        if(!$headers){
            $headers = [
                'key-puninar'   => config('_static.api_key'),
                'timestamp'     => config('_static.api_time'),
                'Content-Type'  => 'application/json',
            ];
        }
        $client = new Client([
            'verify' => false,
            'http_errors' => false,
        ]);

        $body           = json_encode($params['body']);
        $request        = new GuzzleRequest('POST', $params['url'], $headers, $body);
        $res            = $client->sendAsync($request)->wait();
        $content_json   = $res->getBody()->getContents();
        $content_arr    = json_decode($content_json,1);


        /* IF TOKEN EXPIRED */
       
        if($content_arr['status'] == 403)
        {
            $params_ = [
                'url' => config('_static.api_pa_full_url').'/login-app',
                'body' => [
                    'user_name' => session()->get('pa_result')['user']['user_name'],
                    'password'  => session()->get('pa_result')['user']['password'],
                    'app_id'    => config('_static.app_id')
                ]
            ];
            $response = self::BuildCurlApiPA($params_);
            $params_ = [
                'app_token' => $response['app_token'],
                'app_menu'  => Builder::menu_sidebar_configuration($response['app_menu']),
                'user'      => $response['user'][0],
                'role'      => $response['role'][0],
                'password'  => $request->password,
            ];
            $params_['user']['password'] = $request->password;

            if($params_['app_token']){
                Session::put('pa_result',$params_);
                $headers = [
                    'Content-Type' => 'application/json',
                    'apptoken' => $response['app_token'],
                    'appmenu' => $menu
                ];
                self::BuildCurlApiPA($params);
            }
        }

        return $content_arr;
    }

    #get list Company
    public static function getCompanyPuninar($params,$headers = null)
    {
        if(!$headers){
            $headers = [
                'key-puninar'   => config('_static.api_key'),
                'timestamp'     => config('_static.api_time'),
                'Content-Type'  => 'application/json',
            ];
        }
        $client = new Client([
            'verify' => false,
            'http_errors' => false,
        ]);

        $body           = json_encode($params['body']);
        $request        = new GuzzleRequest('POST', $params['url'], $headers, $body);
        $res            = $client->sendAsync($request)->wait();
        $content_json   = $res->getBody()->getContents();
        $content_arr    = json_decode($content_json,1);
        return $content_arr;
    }

    #get list users, used Audit Module
    public static function getListUsers($params,$headers = null)
    {
        if(!$headers){
            $headers = [
                'key-puninar'   => config('_static.api_key'),
                'timestamp'     => config('_static.api_time'),
                'Content-Type'  => 'application/json',
            ];
        }
        $client = new Client([
            'verify' => false,
            'http_errors' => false,
        ]);
        $body           = json_encode($params['body']);
        $request        = new GuzzleRequest('POST', $params['url'], $headers, $body);
        $res            = $client->sendAsync($request)->wait();
        $content_json   = $res->getBody()->getContents();
        $content_arr    = json_decode($content_json,1);
        return $content_arr;
    }

    #send whatsapp
    public static function sendWhatsapp($params,$headers = null)
    {
        if(!$headers){
            $headers = [
                'token'         => config('_static.wa_token'),
                'Content-Type'  => 'application/json',
            ];
        }

        $client = new Client([
            'verify' => false,
            'http_errors' => false,
        ]);

        $body           = json_encode($params['body']);
        $request        = new GuzzleRequest('POST', $params['url'], $headers, $body);
        $res            = $client->sendAsync($request)->wait();
        $content_json   = $res->getBody()->getContents();
        $content_arr    = json_decode($content_json,1);
        return $content_arr;
    }
}
