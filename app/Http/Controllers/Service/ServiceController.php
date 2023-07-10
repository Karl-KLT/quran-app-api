<?php
namespace App\Http\Controllers\Service;


use App\Models\Service;
use App\repositories\Quran\QuranRepository;

class ServiceController

{
    protected $QuranRepository;

    public function __construct(QuranRepository $QuranRepository)
    {
        $this->QuranRepository = $QuranRepository;
    }

    public function getAll()
    {
        return response()->json([
            'message' => 'successfully',
            'status' => 200,
            'data' => !empty(Service::all()) ? Service::all() : null
        ],200);
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

            return $this->QuranRepository->getPrayerTime(request()->lat,request()->lng);
        }
    }
}
