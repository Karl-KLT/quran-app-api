<?php

namespace App\Http\Services\Quran;

use App\Repositories\Quran\QuranRepository;

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

    public function getRandomJuz()
    {
        return $this->QuranRepository->getRandomJuz();
    }

    public function getAllPersonTafsir()
    {
        return $this->QuranRepository->getAllPersonTafsir();
    }


    public function getAllPersonAudio()
    {
        return $this->QuranRepository->getAllPersonAudio();
    }

    // /////////////////////////


    public function getSurah(int $numberOfSurah)
    {
        return $this->QuranRepository->getSurah($numberOfSurah);
    }

    public function quickAccess()
    {
        return $this->QuranRepository->quickAccess();
    }

    public function getAllJuz()
    {
        return $this->QuranRepository->getAllJuz();
    }

    public function getJuz($numberOfJuz)
    {
        return $this->QuranRepository->getJuz($numberOfJuz);
    }

    public function getTafsir(int $numberOfSurah,string $idOfPerson,$numberOfAyah)
    {
        return $this->QuranRepository->getTafsir($numberOfSurah,$idOfPerson,$numberOfAyah);
    }
    public function getAudio(int $numberOfSurah,string $idOfPerson,$numberOfAyah)
    {
        return $this->QuranRepository->getAudio($numberOfSurah,$idOfPerson,$numberOfAyah);
    }

    // Accounts

    public function post_saved()
    {
        return $this->QuranRepository->post_saved();
    }

    public function get_saved()
    {
        return $this->QuranRepository->get_saved();
    }
    // end Accounts

    public function post_readed()
    {
        return $this->QuranRepository->post_readed();
    }

    public function get_readed()
    {
        return $this->QuranRepository->get_readed();
    }

    // preyer times
    public function getPrayerTime($lat,$lng)
    {
        return $this->QuranRepository->getPrayerTime($lat,$lng);
    }
}
