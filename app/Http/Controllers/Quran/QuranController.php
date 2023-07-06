<?php

namespace App\Http\Controllers\Quran;

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

    public function getAllPersonTafir()
    {
        return $this->QuranService->getAllPersonTafir();
    }


    public function getAllPersonAudio()
    {
        return $this->QuranService->getAllPersonAudio();
    }

    public function getSurah(int $numberOfSurah)
    {
        return $this->QuranService->getSurah($numberOfSurah);
    }

    public function getRandomSurah()
    {
        return $this->QuranService->getRandomSurah();
    }

    public function getAllJuz()
    {
        return $this->QuranService->getAllJuz();
    }

    public function getJuz(int $numberOfJuz = null)
    {
        if($numberOfJuz){
            return $this->QuranService->getJuz($numberOfJuz);
        }

        return response()->json([
            'message' => 'no param found',
            'satus' => 500
        ],500);
    }

    public function getTafsir(int $numberOfSurah,string $idOfPerson)
    {
        return $this->QuranService->getTafsir($numberOfSurah,$idOfPerson);
    }
    public function getAudio(int $numberOfSurah,string $idOfPerson)
    {
        return $this->QuranService->getAudio($numberOfSurah,$idOfPerson);
    }
}
