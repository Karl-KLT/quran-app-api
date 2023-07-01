<?php

namespace App\repositories\Quran;

use Illuminate\Support\Facades\Http;

class QuranRepository
{
    public $value = array();
    public function __construct()
    {

    }
    public function getRequest(string $url)
    {
        return Http::get($url)->json()['data'];
    }

    public function getAll()
    {
        $sorahs = $this->getRequest('http://api.alquran.cloud/v1/surah');

        foreach ($sorahs as $value) {
            $this->value[] =[
                'number' => $value['number'],
                'name' => $value['name'],
                'englishName' => $value['englishName'],
                'numberOfAyahs' => $value['numberOfAyahs'],
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
        $sorah = $this->getRequest('http://api.alquran.cloud/v1/surah/'.$numberOfSurah);

        $this->value = $sorah;

        return response()->json([
            'data' => !empty($this->value) ? $this->value : null,
            'message' => 'successfully',
            'status' => 200
        ]);
    }
}
