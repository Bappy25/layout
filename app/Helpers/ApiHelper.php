<?php
namespace App\Helpers;

use Log;
use Validator;

class ApiHelper
{

    public static function success($message='Operation Successful!', $data=[]){
        return response(["result" => true, "message" => $message, "data" => $data]);
    }

    public static function fail($message="server error", $code=5001, $details=[]){
        Log::error($message);
        return response(["result" => false, "code" => $code, "message" => $message, "details" => $details]);
    }

    public static function failedValidation($validation_messages, $message='Parameter validation failed!'){
        Log::info($validation_messages);
        return self::fail($message, 4001, $validation_messages);
    }

    public static function validator($request, array $rules = []) {
        $validator = Validator::make($request, $rules);
        if ($validator->fails()) {
            $response['response'] = $validator->messages();
            return self::failedValidation($validator->messages());
        }
    }
    
}