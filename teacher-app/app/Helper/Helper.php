<?php

namespace App\Helper;

class Helper {
    public static function returnResponse($message = "", $extra = [], $status = 200) {
        return response()->json(array_merge(["message" => $message], $extra), $status);
    }

    public static function returnError($error, $status = 500){
        return response()->json([
            "message" => "Something went wrong",
            "error" => $error->getMessage()
        ], $status);
    }
}