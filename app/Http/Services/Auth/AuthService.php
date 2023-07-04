<?php

namespace App\Http\Services\Auth;

use App\Repositories\Auth\AuthRepository;
class AuthService
{
    protected $AuthRepository;
    public function __construct(AuthRepository $AuthRepository)
    {
        $this->AuthRepository = $AuthRepository;
    }

    public function create()
    {
        return $this->AuthRepository->create();
    }

    public function login()
    {
        return $this->AuthRepository->login();
    }

    public function profile()
    {
        return $this->AuthRepository->profile();
    }
}
