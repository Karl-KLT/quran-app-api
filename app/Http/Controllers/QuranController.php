<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Services\Quran\QuranService;
use Illuminate\Http\Request;

class QuranController extends Controller
{
    protected $QuranService;
    public function __construct(QuranService $QuranService)
    {
        $this->QuranService = $QuranService;
    }
    public function getAll()
    {
        return $this->QuranService->getAll();
    }

    public function getSurah(int $numberOfSurah)
    {
        return $this->QuranService->getSurah($numberOfSurah);
    }
}
