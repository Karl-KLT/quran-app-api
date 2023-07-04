<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Services\Auth\AuthService;

class AuthController extends Controller
{
    protected $AuthService;
    public function __construct(AuthService $AuthService)
    {
        $this->AuthService = $AuthService;
        $this->middleware('auth:api',['except'=>['create','login']]);
    }

    // accounts
    public function create()
    {
        return $this->AuthService->create();
    }

    public function login()
    {
        return $this->AuthService->login();
    }

    public function profile()
    {
        return $this->AuthService->profile();
    }

}
