<?php

namespace App\Http\Services\Guest;
use App\Repositories\Guest\GuestRepository;

class GuestService
{

    protected $GuestRepository;
    public function __construct(GuestRepository $GuestRepository)
    {
        $this->GuestRepository = $GuestRepository;
    }
    public function create()
    {
        return $this->GuestRepository->create();
    }

    public function update()
    {
        return $this->GuestRepository->update();
    }

}
