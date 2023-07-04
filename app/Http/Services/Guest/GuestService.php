<?php

namespace App\Http\Services\Guest;
use App\repositories\Guest\GuestRepository;

class GuestService
{

    protected $GuestRepository;
    public function __construct(GuestRepository $GuestRepository)
    {
        $this->GuestRepository = $GuestRepository;
    }
    public function createUser()
    {
        return $this->GuestRepository->createUser();
    }

    public function updateUser()
    {
        return $this->GuestRepository->updateUser();
    }

}
