<?php
namespace App\Http\Controllers\Service;


use App\Models\Service;
use App\Repositories\Quran\QuranRepository;

class ServiceController

{
    protected $QuranRepository;

    public function __construct(QuranRepository $QuranRepository)
    {
        $this->QuranRepository = $QuranRepository;
    }

    public function getAll()
    {
        function fixUnique()
        {
            $uniqueList = array();
            for ($i=0; $i < Service::all()->count(); $i++) {
                $rand = Service::all()->unique()->random()['id'];

                if(!in_array($rand,$uniqueList))
                {
                    $services[] = Service::find($rand);
                    $uniqueList[] = $rand;
                }else{
                    foreach (Service::all() as $service) {
                        if(!in_array($service->id,$uniqueList)){
                            $services[] = $service;
                            $uniqueList[] = $service->id;
                        }
                    }
                }
            }

            return $services;
        }


        if(count(Service::all())){


            return response()->json([
                'message' => 'successfully',
                'status' => 200,
                'data' => fixUnique()
            ],200);

        }

        return response()->json([
            'message' => 'faield',
            'status' => 500,
        ],500);

    }

    public function getService(int $id = null)
    {
        $validate = \Validator::make([
            'id' => $id
        ],[
            'id' => 'required|exists:services,id'
        ],[
            'id.exists' => "service not found"
        ]);

        if($validate->fails()){
            return response()->json([
                'validation' => $validate->getMessageBag(),
                'message' => 'failed',
                'status' => 500
            ],500);
        }

        $id = Service::find($id)->id;

        if($id == 1){
            $validate = \Validator::make(request()->all(),[
                'lat' => "required",
                'lng' => "required"
            ]);

            if($validate->fails()){
                return response()->json([
                    'validation' => $validate->getMessageBag(),
                    'message' => 'failed',
                    'status' => 500
                ],500);
            }

            return $this->QuranRepository->getPrayerTime(request()->post('lat'),request()->post('lng'));
        }
    }

    public function collection()
    {
        return response()->json([
            'message' => 'successfully',
            'status' => 200,
            'data' => !empty(Service::all()) ? Service::all() : null
        ],200);
    }
}
