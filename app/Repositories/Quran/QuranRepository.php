<?php

namespace App\repositories\Quran;

use Illuminate\Pagination\Paginator;
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


    public function getAllPersonTafir()
    {    
        try{
            $editions = $this->getRequest('http://api.alquran.cloud/v1/edition?type=tafsir&language=ar');
            foreach ($editions as $value) {
                $query[] = [
                    'id' => $value['identifier'],
                    'arabicName' => $value['name'],
                    'englishName' => $value['englishName'],
                ];
            }
            return response()->json([
                'data' => $query,
                'message' => 'successfully',
                'status' => 200,
            ],200);
        }catch(\Throwable $e){
            return response()->json([
                'error' => $e,
                'message' => 'failed',
                'status' => 500,
            ],500);
        }
    }

    public function getAllPersonAudio()
    {    
        try{
            $editions = $this->getRequest('http://api.alquran.cloud/v1/edition?format=audio&language=ar');
            foreach ($editions as $value) {
                $query[] = [
                    'id' => $value['identifier'],
                    'arabicName' => $value['name'],
                    'englishName' => $value['englishName'],
                ];
            }
            return response()->json([
                'data' => $query,
                'message' => 'successfully',
                'status' => 200,
            ],200);
        }catch(\Throwable $e){
            return response()->json([
                'error' => $e,
                'message' => 'failed',
                'status' => 500,
            ],500);
        }
    }













    public function getSurah(int $numberOfSurah)
    {
        $surah = $this->getRequest('http://api.alquran.cloud/v1/surah/'.$numberOfSurah.'/quran-unicode')['ayahs'];
        
        if($numberOfSurah == 1){
            $this->value[] = [
                'number' => $numberOfSurah,
                'text' => "بِسۡمِ ٱللَّهِ ٱلرَّحۡمَـٰنِ ٱلرَّحِیمِ ",
                'color' => null,
                'numberInSurah' =>  1,
            ];
        }else{
            $this->value[] = [
                'number' => $numberOfSurah,
                'text' => "بِسۡمِ ٱللَّهِ ٱلرَّحۡمَـٰنِ ٱلرَّحِیمِ ",
                'color' => null,
                'numberInSurah' =>  0,
            ];
        }


        foreach ($surah as $key => $surahValue) {

            if($surahValue['text'] != "بِسۡمِ ٱللَّهِ ٱلرَّحۡمَـٰنِ ٱلرَّحِیمِ "){
                $this->value[] = [
                    'number' => $numberOfSurah,
                    'text' => $surahValue['text'],
                    'color' => null,
                    'juz' => $surahValue['juz'],
                    'numberInSurah' => $surahValue['numberInSurah'],
                ];
            }
        }
        
        return response()->json([
            'message' => 'successfully',
            'status' => 200,
            'data' => !empty($this->value) ? $this->value : null
        ]);
    }


    public function getTafsir(int $numberOfSurah,string $idOfPerson)
    {
        $surah = $this->getRequest('http://api.alquran.cloud/v1/edition?type=tafsir&language=ar');
        if($numberOfSurah && $idOfPerson){                
            foreach ($surah as $value) {
                if($value['identifier'] == $idOfPerson){
                    
                    $surah = $this->getRequest('http://api.alquran.cloud/v1/surah/'.$numberOfSurah.'/'.$idOfPerson)['ayahs'];
                    
                    $arabicName = $value['name'];
                    $englishName = $value['englishName'];
                    
                    
                    foreach ($surah as $value) {
                        $surahH[] = [
                            'number' => $value['number'],
                            'arabicName' => $arabicName,
                            'englishName' => $englishName,
                            'text' => $value['text'],
                            'numberInSurah' => $value['numberInSurah']
                        ];
                    }
                    return response()->json([
                        'message' => 'id not found',
                        'status' => 500,
                        'data' => $surahH,
                    ],500);
                }
            }
            return response()->json([
                'message' => 'id not found',
                'status' => 500
            ],500);
        }

    }
    public function getAudio(int $numberOfSurah,string $idOfPerson)
    {
        $surah = $this->getRequest('http://api.alquran.cloud/v1/edition?format=audio&language=ar');

        if($numberOfSurah && $idOfPerson){
            foreach ($surah as $value) {
                if($value['identifier'] == $idOfPerson){
                    $surah = $this->getRequest('http://api.alquran.cloud/v1/surah/'.$numberOfSurah.'/'.$idOfPerson)['ayahs'];
                    $arabicName = $value['name'];
                    $englishName = $value['englishName'];
                    
                    
                    foreach ($surah as $value) {
                        $surahH[] = [
                            'number' => $value['number'],
                            'arabicName' => $arabicName,
                            'englishName' => $englishName,
                            'audio' => $value['audio'],
                            'audioSecondary' => !empty($value['audioSecondary']) ? $value['audioSecondary'] : null
                        ];
                    }
                    return response()->json([
                        'data' => $surahH,
                        'message' => 'successfully',
                        'status' => 200
                    ],200);
                }
            }
            return response()->json([
                'message' => 'id not found',
                'status' => 500
            ],500);
        }
    }



































    // 'tafsir' => $this->handleTafsir($numberOfSurah,$surahValue['number']),
    // 'audios' => $this->handleAudio($numberOfSurah,$surahValue['number'])

    // protected function handleAudio($numberOfSurah,$numberOfAyah){
    //     $editions = $this->getRequest('http://api.alquran.cloud/v1/edition?format=audio&language=ar');
    //     $edition = null;
    //     foreach ($editions as $editionsValue) {
    //         $surah = $this->getRequest('http://api.alquran.cloud/v1/surah/'.$numberOfSurah.'/'.$editionsValue['identifier'])['ayahs'];
    //         foreach ($surah as $value) {
    //             if($value['number'] == $numberOfAyah){
    //                 $edition[] = [
    //                     'audios' => [
    //                         'name' => $editionsValue['englishName'],
    //                         'audio' => $value['audio'],
    //                         'audioSecondary' => $value['audioSecondary']
    //                     ]
    //                 ];
    //             }
    //         }
    //     }
    //     return $edition;
    // }

    // protected function handleTafsir($numberOfSurah,$numberOfAyah){
    //     $editions = $this->getRequest('http://api.alquran.cloud/v1/edition?type=tafsir&language=ar');
    //     $edition = null;
    //     foreach ($editions as $editionsValue) {
    //         $surah = $this->getRequest('http://api.alquran.cloud/v1/surah/'.$numberOfSurah.'/'.$editionsValue['identifier'])['ayahs'];
    //         foreach ($surah as $value) {
    //             if($value['number'] == $numberOfAyah){
    //                 $edition[] = [

    //                     'name' => $editionsValue['englishName'],
    //                     'text' => $value['text']

    //                 ];
    //             }
    //         }
    //     }
    //     return $edition;
    // }
}
