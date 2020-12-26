<?php

namespace App\Http\Controllers\doctor;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class PreTestItemController extends Controller
{
    public function __construct(){
        $this->middleware(['authorized','doctor']);
    }
}
