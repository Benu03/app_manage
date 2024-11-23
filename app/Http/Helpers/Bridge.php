<?php

namespace App\Http\Helpers;
use GuzzleHttp\Psr7\Request as GuzzleRequest;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Session;

class Bridge {

    #login
    public static function BuildCurlApiPA($params,$headers = null,$menu = null) {
          date_default_timezone_set('Asia/Jakarta');
        if(!$headers){
            $headers = [
                'key-service'   => config('static.api_key'),
                'timestamp'     => config('static.api_time'),
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
                'key-service'   => config('static.api_key'),
                'timestamp'     => config('static.api_time'),
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
