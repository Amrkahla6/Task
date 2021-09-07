<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    public function returnData($key, $value)
    {
        return response()->json([
            'responseCode'    => 1000,
            'responseMessage' => "Success",
             $key => $value,
        ]);
    }

    public function returnError($errNum, $msg)
    {
        return response()->json([
            'responseCode' => $errNum,
            'responseMessage' => $msg
        ]);
    }

    public function returnCodeAccordingToInput($validator)
    {
        $inputs = array_keys($validator->errors()->toArray());
        $code = $this->getErrorCode($inputs[0]);
        return $code;
    }


    public function returnValidationError($code = "E001", $validator)
    {
        return $this->returnError($code, $validator->errors()->first());
    }
}
