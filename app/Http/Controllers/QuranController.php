<?php

namespace App\Http\Controllers;

use App\Http\Controllers\helper\RequestController;
use Illuminate\Http\Request;

class QuranController extends RequestController
{
    public function getAll()
    {
        return $this->getRequest('')->json()['data'];
    }
}
