<?php


namespace App\Http\Services;

use Carbon\Carbon as Carb;

class Carbon
{

    public function __construct()
    {
        // 
    }


    public function handle($time)
    {
        return Carb::create($time)->diffForHumans(null,true,true,1);
    }


}
