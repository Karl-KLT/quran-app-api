<?php

namespace App\Http\Services\Quran;

use App\repositories\Quran\QuranRepository;

class QuranService
{
    protected $QuranRepository;
    public function __construct(QuranRepository $QuranRepository)
    {
        $this->QuranRepository = $QuranRepository;
    }
    public function getAll()
    {
        return $this->QuranRepository->getAll();
    }

    public function getSurah(int $numberOfSurah)
    {
        return $this->QuranRepository->getSurah($numberOfSurah);
    }
}
