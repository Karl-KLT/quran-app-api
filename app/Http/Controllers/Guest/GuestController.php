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
    public function create()
    {
        return $this->GuestService->create();
    }

    public function update()
    {
        return $this->GuestService->update();
    }
}
