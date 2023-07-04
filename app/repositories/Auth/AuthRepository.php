<?php

namespace App\Repositories\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use App\Models\CustomUser;
class AuthRepository
{

    public function create()
    {
        $validator = Validator::make(request()->all(),[
            "name" => "required",
            'email' => "required|unique:users,email",
            'phone_number' => "required|unique:users,phone_number",
            "country" => "required",
            "city" => "required",
            "image" => "file",
            "password" => "required",
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => 'validation has failed',
                'status' => 500,
                'validation' => $validator->getMessageBag(),
            ],500);
        }


        try{
            $user = new User;

            $user->fill(request()->except('password'));
            $user->password = \Hash::make(request()->password);
            $user->save();

            return response()->json([
                'message' => 'account has been created successfully',
                'status' => 200,
            ],200);
        }catch(\Throwable $e){
            return response()->json([
                'message' => 'error',
                'status' => 500,
                'error' => $e
            ],500);
        }
    }


    // login
    public function login()
    {
        // email / phone_number
        $validator = Validator::make(request()->all(),[
            'email' => "exists:users,email|required_unless:phone_number,".request()->phone_number,
            'phone_number' => "exists:users,phone_number|required_unless:email,".request()->email,
            'password' => "required",
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => 'validation has failed',
                'status' => 500,
                'validation' => $validator->getMessageBag(),
            ],500);
        }

        if(request()->filled('email')){
            $auth = auth()->attempt(request()->only('email','password'));
        }else{
            $auth = auth()->attempt(request()->only('phone_number','password'));
        }

        if($auth){
            return $this->respondWithToken($auth);
        }
        return response()->json([
            'message' => "can't login, check email or phone_number and password",
            'status' => 500,
        ],500);

    }

    public function profile()
    {
        return response()->json([
            'message' => 'successfully',
            'status' => 200,
            'user' => auth()->user()
        ]);
    }










    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'message' => 'successfully',
            'status' => 200,
            'access_token' => 'bearer '.$token,


            // 'token_type' => 'bearer',
            // 'expires_in' => auth()->factory()->getTTL() * 60

        ]);
    }
}
