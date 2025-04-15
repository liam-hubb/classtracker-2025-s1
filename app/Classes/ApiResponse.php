<?php

namespace App\Classes;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ApiResponse
{
    /**
     * TODO: Add description and parameters for this method
     */
    public static function rollback($e, $message = "Something went wrong! Process not completed")
    {
        DB::rollBack();
        self::throw($e, $message);
    }

    /**
     * TODO: Add description and parameters for this method
     */
    public static function throw($e, $message = "Something went wrong! Process not completed")
    {
        Log::info($e);
        throw new HttpResponseException(response()->json(["message" => $message], 500));
    }

    /**
     * TODO: Add description and parameters for this method
     */


    public static function sendResponse($result, $message, $success = true, $code = 200)
    {
        $response = [
            'success' => $success,
            'message' => $message ?? null,
            'data' => $result
        ];
        return response()->json($response, $code);
    }

    public static function success($result, $message,$code = 200)
    {
        $success=true;
        return self::sendResponse($result,$message,$success, $code);
    }

    public static function error($result, $message,  $code = 500)
    {
        $success = false;
        return self::sendResponse($result, $message,$success, $code);
    }


    /**
     * End of ApiResponse
     */



}
