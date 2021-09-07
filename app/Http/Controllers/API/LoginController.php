<?php

namespace App\Http\Controllers\API;

use Validator;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\User\UserResource;
use App\Http\Controllers\API\BaseController as BaseController;

class LoginController extends BaseController
{
    public function login(Request $request){
            $validator = Validator::make($request->all(), [
                'email'          => 'required',
                'password'       => 'required',
            ], [
                'phone.required'        => "Email Is Required",
                'password.required'     => "Password Is Required",
            ]);

                if ($validator->fails()) {
                    $code = $this->returnCodeAccordingToInput($validator);
                    return $this->returnValidationError($code, $validator);
                }
                $password = $request->password;
                $user = User::where('email', $request->email)->first();
                if($user){
                    $user = new UserResource(User::where('email', $request->email)->first());
                    $user->password;
                    if(Hash::check($password, $user->password)) {
                        $user->updated_at = Carbon::now()->toDateTimeString();
                        $user->save;

                        return $this->returnData('user', $user);
                    }else{
                        return $this->returnError(401, "User_Not_Found");
                    }
                }else{
                    return $this->returnError(401, "User_Not_Found");
                }
    }
}
