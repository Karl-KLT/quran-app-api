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
        $this->middleware("auth:api",['only'=>['post_saved','get_saved','post_readed','get_readed']]);

    }
    public function getAll()
    {
        return $this->QuranService->getAll();
    }

    public function getAllPersonTafsir()
    {
        return $this->QuranService->getAllPersonTafsir();
    }


    public function getAllPersonAudio()
    {
        return $this->QuranService->getAllPersonAudio();
    }

    public function getSurah(int $numberOfSurah)
    {
        return $this->QuranService->getSurah($numberOfSurah);
    }

    public function quickAccess()
    {
        return $this->QuranService->quickAccess();
    }

    public function getAllJuz()
    {
        return $this->QuranService->getAllJuz();
    }

    public function getRandomJuz()
    {
        return $this->QuranService->getRandomJuz();
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

    public function getTafsir(int $numberOfSurah,string $idOfPerson,int $numberOfAyah = null)
    {
        return $this->QuranService->getTafsir($numberOfSurah,$idOfPerson,$numberOfAyah);
    }
    public function getAudio(int $numberOfSurah,string $idOfPerson,int $numberOfAyah = null)
    {
        return $this->QuranService->getAudio($numberOfSurah,$idOfPerson,$numberOfAyah);
    }


    // Accounts

    public function post_saved()
    {
        return $this->QuranService->post_saved();
    }

    public function get_saved()
    {
        return $this->QuranService->get_saved();
    }

    // end Accounts

    public function post_readed()
    {
        return $this->QuranService->post_readed();
    }

    public function get_readed()
    {
        return $this->QuranService->get_readed();
    }


    // prayerTimes
    public function getPrayerTime(float $lat,float $lng)
    {
        return $this->QuranService->getPrayerTime($lat,$lng);
    }


}
