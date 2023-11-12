<?php

namespace Pickmap\ServiceRequest;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

trait ServiceRequest{

    public static function getToken($refreshToken = false)
    {
        if (! Cache::has('token') || $refreshToken)
        {                
            $token      = self::requestToKeyCloak();
            $timeToLive = now()->addHours(6);

            Cache::put('token',$token,$timeToLive);
        }

        $token = Cache::get('token');
        return $token;
    }

    public static function requestToKeyCloak()
    {
        $user = [
            "client_id"     =>  env('OAUTH_CLIENT_ID'),
            "client_secret" =>  env('OAUTH_CLIENT_SECRET'),
            "grant_type"    =>  'client_credentials'
        ];
        $keycloakUrl = env('OAUTH_TOKEN_URL');

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $keycloakUrl);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));   
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($user));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
        $result = curl_exec($ch);
        $result = json_decode($result);
        return 'Bearer '.$result->access_token;   
    }

    public static function HeadersProcess($newHeader)
    {
        return array_merge(['Authorization' => self::getToken()],$newHeader);
    }

    public static function requestPost(string $url,array $data = [],$headers = [])
    {
        $headers = self::HeadersProcess($headers);
        $response = Http::withHeaders($headers)->post($url,$data);
        return $response;
    }

    public static function requestGet(string $url,array $data = [],$headers = [])
    {
        $headers = self::HeadersProcess($headers);
        $response = Http::withHeaders($headers)->get($url,$data);
        return $response;
    }
}
