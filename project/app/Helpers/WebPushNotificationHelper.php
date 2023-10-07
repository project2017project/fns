<?php

namespace App\Helpers;

class WebPushNotificationHelper
{
    public static function sendNotification($data){
        $end_point          =   env('WEBPUSHR_URL');
        $webpushrKey        =   env('WEBPUSHR_KEY');
        $webpushrAuthToken  =   env('WEBPUSHR_AUTH_TOKEN');
        $target_url         =   $data['target_url'];

        $http_header = array(
            "Content-Type: application/json",
            "webpushrKey: ".$webpushrKey,
            "webpushrAuthToken: ".$webpushrAuthToken
        );

        $req_data = array(
            'title' 		=>  $data['title'],
            'message' 		=>  $data['message'],
            'target_url'	=>  $target_url
        );
        
        if(isset($data['image']) && !empty($data['image'])){
            $req_data['image'] =  $data['image'];
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, $http_header);
        curl_setopt($ch, CURLOPT_URL, $end_point );
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($req_data) );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        return $response;
    }
}
