<?php

namespace App\Http\Services\Auth;

use App\repositories\Auth\AuthRepository;
class AuthService
{
    protected $AuthRepository;
    public function __construct(AuthRepository $AuthRepository)
    {
        $this->AuthRepository = $AuthRepository;
    }

    public function createUser()
    {
        return $this->AuthRepository->createUser();
    }

    public function updateUser()
    {
        return $this->AuthRepository->updateUser();
    }
}
