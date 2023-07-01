<?php

namespace App\Http\Controllers;

use App\Http\Controllers\auth\TokenController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;



class AuthController extends TokenController
{
    public function createUser()
    {
        $validator = Validator::make(request()->only('token','device_name'),[
            'device_name' => "required",
            'token' => "required|unique:users,token"
        ]);

        if($validator->fails()){
            return response()->json([
                'validation' => $validator->getMessageBag(),
                'message' => 'validation has failed',
                'status' => 500
            ],500);
        }

        try{

            $user = User::create(request()->only('token','device_name'));

            if($user){
                return response()->json([
                    'message' => 'user has been created successfully',
                    'status' => 200
                ],200);
            }

            return response()->json([
                'message' => 'smth went wrong',
                'status' => 500
            ],500);

        }catch(\Throwable $e){
            return response()->json([
                'error' => $e,
                'message' => "can't create account",
                'status' => 500
            ],500);
        }
    }

    public function updateUser()
    {
        $validator = Validator::make(request()->all(),[
            'token' => "required|exists:users,token"
        ]);

        if($validator->fails()){
            return response()->json([
                'validation' => $validator->getMessageBag(),
                'message' => 'validation has failed',
                'status' => 500
            ],500);
        }

        $user = $this->getUserByToken(request()->token);

        $user->fill(request()->except('count_of_login'));
        $user->count_of_login = $user->count_of_login + 1;

        if($user->update()){

            return response()->json([
                'user' => $user,
                'message' => "successfully",
                'status' => 200
            ],200);

        }

        return response()->json([
            'message' => "we can't found your account",
            'status' => 500
        ],500);


    }
}
