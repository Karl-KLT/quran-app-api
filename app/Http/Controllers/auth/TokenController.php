<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class TokenController extends Controller
{
    public function getUserByToken($token = null)
    {
        
        $user = User::all()->where('token',$token)->first() ?? null;

        if($user){
            return $user;
        }

        return false;
    }
}
