<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Http\Services\Guest\GuestService;
use Illuminate\Http\Request;

class GuestController extends Controller
{
    protected $GuestService;
    public function __construct(GuestService $GuestService)
    {
        $this->GuestService = $GuestService;
    }
    public function createUser()
    {
        return $this->GuestService->createUser();
    }

    public function updateUser()
    {
        return $this->GuestService->updateUser();
    }
}
