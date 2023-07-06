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

    public function getAllPersonTafir()
    {
        return $this->QuranRepository->getAllPersonTafir();
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

    public function getRandomSurah()
    {
        return $this->QuranRepository->getRandomSurah();
    }

    public function getAllJuz()
    {
        return $this->QuranRepository->getAllJuz();
    }

    public function getJuz($numberOfJuz)
    {
        return $this->QuranRepository->getJuz($numberOfJuz);
    }

    public function getTafsir(int $numberOfSurah,string $idOfPerson)
    {
        return $this->QuranRepository->getTafsir($numberOfSurah,$idOfPerson);
    }
    public function getAudio(int $numberOfSurah,string $idOfPerson)
    {
        return $this->QuranRepository->getAudio($numberOfSurah,$idOfPerson);
    }
}
