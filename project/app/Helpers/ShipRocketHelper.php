<?php

namespace App\Helpers;

class ShipRocketHelper
{
    public static function Authentication(){
        $url = 'auth/login';
        $header = [
            'Content-Type: application/json'
        ];
        $data = [
            "email"     =>  env('SHIPROCKET_EMAIL'),
            "password"  =>  env('SHIPROCKET_PASSWORD')
        ];
        $returnData =   self::___cUrlExecute($url, $header, $data, 'POST');
        $response   =   self::___readResponseData($returnData);
        return (array)$response;    
    }
    
    public static function CreateCustomOrder($ShipRocketToken, $items, $orderData){
        $url = 'orders/create/adhoc';
        $header = [
            'Content-Type: application/json',
            'Authorization: Bearer '.$ShipRocketToken
        ];
    
        $orderData['order_items'] = $items;
        $returnData =   self::___cUrlExecute($url, $header, $orderData, 'POST');
        $response   =   self::___readResponseData($returnData);    
        
        return (array)$response;    
    }
    
    public static function GenerateAWB($ShipRocketToken, $ShipmentId, $CourierId){
        $url = 'courier/assign/awb';
        $header = [
            'Content-Type: application/json',
            'Authorization: Bearer '.$ShipRocketToken
        ];
        $data = [
            "shipment_id"   =>  $ShipmentId,
            "courier_id"    =>  $CourierId
        ];
        $returnData =   self::___cUrlExecute($url, $header, $data, 'POST');
        $response   =   self::___readResponseData($returnData);    
    
        return (array)$response;    
    }
    
    public function GetTrackingthroughAWB($ShipRocketToken, $awb_code){
        $url = 'courier/track/awb/'.$awb_code;
        $header = [
            'Content-Type: application/json',
            'Authorization: Bearer '.$ShipRocketToken
        ];
        $returnData =   self::___cUrlExecute($url, $header, array(), 'GET');
        $response   =   self::___readResponseData($returnData);    
    
        return (array)$response;     
    } 
    
    public static function ListofCouriers($ShipRocketToken){
        $url = 'courier/courierListWithCounts';
        $header = [
            'Content-Type: application/json',
            'Authorization: Bearer '.$ShipRocketToken
        ];
        $returnData =   self::___cUrlExecute($url, $header, array(), 'GET');
        $response   =   self::___readResponseData($returnData);
        return (array)$response;
    }
    
    public static function ___readResponseData($returnData){
        $response = array();
        if(isset($returnData['response']))
            $response = (array)$returnData['response'];
        return $response;
    }
    
    public static function ___cUrlExecute($url, $header, $data, $method){
        $curl = curl_init();
        if(is_array($data) && count($data)>0){
            $cUrlOptions = [
                CURLOPT_URL             =>  env('SHIPROCKET_API_URL').$url,
                CURLOPT_RETURNTRANSFER  =>  true,
                CURLOPT_ENCODING        =>  '',
                CURLOPT_MAXREDIRS       =>  10,
                CURLOPT_TIMEOUT         =>  0,
                CURLOPT_FOLLOWLOCATION  =>  true,
                CURLOPT_HTTP_VERSION    =>  CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST   =>  $method,
                CURLOPT_POST            =>  true,
                CURLOPT_POSTFIELDS      =>  json_encode($data),
                CURLOPT_HTTPHEADER      =>  $header
            ];
        }
        else{
            $cUrlOptions = [
                CURLOPT_URL             =>  env('SHIPROCKET_API_URL').$url,
                CURLOPT_RETURNTRANSFER  =>  true,
                CURLOPT_ENCODING        =>  '',
                CURLOPT_MAXREDIRS       =>  10,
                CURLOPT_TIMEOUT         =>  0,
                CURLOPT_FOLLOWLOCATION  =>  true,
                CURLOPT_HTTP_VERSION    =>  CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST   =>  $method,
                CURLOPT_HTTPHEADER      =>  $header
            ];
        }
        curl_setopt_array($curl, $cUrlOptions);
        $response   =   curl_exec($curl);
        $statusCode =   curl_getinfo($curl, CURLINFO_HTTP_CODE);
        
        if($statusCode==200){
            return [
                'status'        =>  'true',
                'response'      =>  json_decode($response),
                'message'       =>  '',
                'statusCode'    =>  $statusCode
            ];
        }
        else{
            return [
                'status'        =>  'false',
                'response'      =>  $response,
                'message'       =>  curl_error($curl),
                'statusCode'    =>  $statusCode
            ];
        }
        curl_close($curl);
    }
}
