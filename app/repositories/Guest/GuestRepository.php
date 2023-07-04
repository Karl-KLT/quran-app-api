<?php

namespace App\Repositories\Guest;
use App\Models\Guest;
use Illuminate\Support\Facades\Validator;


class GuestRepository
{
        // custom user
        protected function getUserByToken($token = null)
        {

            $user = Guest::all()->where('token',$token)->first() ?? null;

            if($user){
                return $user;
            }

            return false;
        }


        public function createUser()
        {
            $validator = Validator::make(request()->only('token','device_name'),[
                'device_name' => "required",
                'token' => "required|unique:guests,token"
            ]);

            if($validator->fails()){
                return response()->json([
                    'message' => 'validation has failed',
                    'status' => 500,
                    'validation' => $validator->getMessageBag(),
                ],500);
            }

            try{

                $user = Guest::create(request()->only('token','device_name'));

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
                    'message' => "can't create account",
                    'status' => 500,
                    'error' => $e,
                ],500);
            }
        }

        // update
        public function updateUser()
        {
            $validator = Validator::make(request()->all(),[
                'token' => "required|exists:guests,token"
            ]);

            if($validator->fails()){
                return response()->json([
                    'message' => 'validation has failed',
                    'status' => 500,
                    'validation' => $validator->getMessageBag(),
                ],500);
            }

            $user = $this->getUserByToken(request()->token);

            $user->fill(request()->except('count_of_login'));
            $user->count_of_login = $user->count_of_login + 1;

            if($user->update()){

                return response()->json([
                    'message' => "successfully",
                    'status' => 200,
                    'user' => $user,
                ],200);

            }

            return response()->json([
                'message' => "we can't found your account",
                'status' => 500
            ],500);
        }
}
