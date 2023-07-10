<?php

namespace App\repositories\Quran;

use Carbon\Carbon;
use App\Http\Services\Carbon as customCarbon;
use Date;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class QuranRepository
{
    public $value = array();
    protected $customCarbon;
    public function __construct(customCarbon $customCarbon)
    {
        $this->customCarbon = $customCarbon;
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



    public function getRandomSurah()
    {
        return $this->getSurah(random_int(1,114));
    }


    public function getAllJuz()
    {
        $juzArray = array();
        for ($i=1; $i <= 30; $i++) {

            $juz = $this->getRequest("http://api.alquran.cloud/v1/juz/".$i."/quran-simple");

            $juzArray[] = [
                'juz' => $juz['number'],


                'from_name' => collect($juz['surahs'])->first()['name'],
                'from_englishName' => collect($juz['surahs'])->first()['englishName'],
                'from_numberOfAyahs' => collect($juz['surahs'])->first()['numberOfAyahs'],
                'to_name' => collect($juz['surahs'])->last()['name'],
                'to_englishName' => collect($juz['surahs'])->first()['englishName'],
                'to_numberOfAyahs' => collect($juz['surahs'])->last()['numberOfAyahs'],
            ];
        }

        return response()->json([
            'message' => 'successfully',
            'status' => 200,
            'data' => $juzArray
        ],200);
    }


    public function getJuz($numberOfJuz)
    {
        $juz = $this->getRequest("http://api.alquran.cloud/v1/juz/".$numberOfJuz."/quran-simple");

        foreach($juz['surahs'] as $surah){
            $this->value[] = collect($surah)->except('englishNameTranslation');
        }

        return response()->json([
            'message' => 'successfuly',
            'status' => 200,
            'data' => $this->value
        ],200);
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


    // Accounts

    public function post_saved()
    {
        $validate = Validator::make(request()->all(),[
            'idOfSurah' => "required",
            'idOfAyah' => "required"
        ]);

        if($validate->fails()){
            return response()->json([
                'validation' => $validate->getMessageBag(),
                'message' => 'successfully',
                'status' => 500
            ],500);
        }

        $user = auth()->user()->saves();
        $user->create(request()->only('idOfSurah','idOfAyah'));

        if($user){
            return response()->json([
                'message' => 'successfully',
                'status' => 200,
            ],200);
        }

        return response()->json([
            'message' => 'failed',
            'status' => 500
        ],500);






    }

    public function get_saved()
    {

        $data = null;

        $user_saves = auth()->user()->saves;

        foreach ($user_saves as $saves) {
            $surah = $this->getRequest('http://api.alquran.cloud/v1/surah/'.$saves['idOfSurah']);

            foreach ($surah['ayahs'] as $ayahs) {

                if($saves['idOfAyah'] == $ayahs['number']){

                    $data[] = [
                        'number' => $surah['number'],
                        'name' => $surah['name'],
                        'englishName' => $surah['englishName'],
                        'revelationType' => $surah['revelationType'],
                        'numberOfAyahs' => $surah['numberOfAyahs'],
                        'ayah' => [
                            'number' => $ayahs['number'],
                            'text' => $ayahs['text'],
                            'numberInSurah' => $ayahs['numberInSurah'],
                        ],
                        'created_at' => $this->customCarbon->handle($saves['created_at']),
                        'updated_at' => $this->customCarbon->handle($saves['updated_at']),
                    ];
                }
            }


        };


        // return $data;
        return response()->json([
            'message' => 'successfully',
            'Status' => 200,
            'data' => $data
        ]);
    }
    // end Accounts

    public function getPrayerTime($lat,$lng)
    {
        $date = Carbon::create(Date::now())->format('d-m-Y');

        $timing = $this->getRequest("http://api.aladhan.com/v1/timings/$date?latitude=$lat&longitude=$lng&method=7");

        $time = collect($timing)->first();

        // return $time;

        foreach ($time as $key => $value) {

            preg_match("/(..*):(..*)/",$value,$match);

            $blockList = [
                'Sunrise',
                'Sunset',
                'Imsak',
                'Midnight',
                'Firstthird',
                'Lastthird',
            ];

            if(in_array($key,$blockList,true)){continue;}

            $h = intval($match[1]);
            $m = intval($match[2]);

            $date = date("$h:$m a",strtotime($value));

            preg_match("/(..*):((..*) (am|pm))/",$date,$match);

            if($match[1] > 12){
                $match[1] = $match[1] - 12;
            }

            if(strlen($match[3]) == 1){
                $match[3] = "0$match[3]";
            }

            $h = $match[1]; // houre
            $m = $match[3]; // minate
            $a = $match[4]; // am/pm

            $this->value[] = [$key => "$h:$m $a"];
        }

        return response()->json([
            'message' => 'successfully',
            'status' => 200,
            'data' => collect($this->value)
        ],200);
    }



}
