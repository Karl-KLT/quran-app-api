<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Http\Services\Auth\AuthService;

class AuthController extends Controller
{
    protected $AuthService;
    public function __construct(AuthService $AuthService)
    {
        $this->AuthService = $AuthService;
    }
    public function createUser()
    {
        return $this->AuthService->createUser();
    }

    public function updateUser()
    {
        return $this->AuthService->updateUser();
    }
}
