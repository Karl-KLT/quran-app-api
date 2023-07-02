<?php

namespace App\repositories\Quran;

use Illuminate\Support\Facades\Http;

class QuranRepository
{
    public $value = array();
    public function __construct()
    {
        // http://api.alquran.cloud/v1/edition?format=audio&language=ar
    }
    public function getRequest(string $url)
    {
        return Http::get($url)->json()['data'];
    }

    public function getAll()
    {
        $sorahs = $this->getRequest('http://api.alquran.cloud/v1/surah');

        foreach ($sorahs as $value) {
            $this->value[] = [
                'number' => $value['number'],
                'name' => $value['name'],
                'englishName' => $value['englishName'],
                'numberOfAyahs' => $value['numberOfAyahs'],
                'revelationType' => $value['revelationType']
            ];
        }

        return response()->json([
            'data' => !empty($this->value) ? $this->value : null,
            'message' => 'successfully',
            'status' => 200
        ]);
    }

    public function getSurah(int $numberOfSurah)
    {
        $surah = $this->getRequest('http://api.alquran.cloud/v1/surah/'.$numberOfSurah.'/quran-simple')['ayahs'];

        foreach ($surah as $surahValue) {
            $this->value[] = [
                'number' => $surahValue['number'],
                'text' => $surahValue['text'],
                'color' => null,
                'numberInSurah' => $surahValue['numberInSurah'],
                'tafsir' => $this->handleTafsir($numberOfSurah,$surahValue['number']),
                'audios' => $this->handleAudio($numberOfSurah,$surahValue['number'])
            ];
        }

        return response()->json([
            'data' => !empty($this->value) ? $this->value : null,
            'message' => 'successfully',
            'status' => 200
        ]);
    }



    protected function handleAudio($numberOfSurah,$numberOfAyah){
        $editions = $this->getRequest('http://api.alquran.cloud/v1/edition?format=audio&language=ar');
        $edition = null;
        foreach ($editions as $editionsValue) {
            $surah = $this->getRequest('http://api.alquran.cloud/v1/surah/'.$numberOfSurah.'/'.$editionsValue['identifier'])['ayahs'];
            foreach ($surah as $value) {
                if($value['number'] == $numberOfAyah){
                    $edition[] = [
                        'audios' => [
                            'name' => $editionsValue['englishName'],
                            'audio' => $value['audio'],
                            'audioSecondary' => $value['audioSecondary']
                        ]
                    ];
                }
            }
        }
        return $edition;
    }

    protected function handleTafsir($numberOfSurah,$numberOfAyah){
        $editions = $this->getRequest('http://api.alquran.cloud/v1/edition?type=tafsir&language=ar');
        $edition = null;
        foreach ($editions as $editionsValue) {
            $surah = $this->getRequest('http://api.alquran.cloud/v1/surah/'.$numberOfSurah.'/'.$editionsValue['identifier'])['ayahs'];
            foreach ($surah as $value) {
                if($value['number'] == $numberOfAyah){
                    $edition[] = [

                        'name' => $editionsValue['englishName'],
                        'text' => $value['text']

                    ];
                }
            }
        }
        return $edition;
    }
}
