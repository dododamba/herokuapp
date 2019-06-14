<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Log;

class LogController extends Controller
{
   public function index()
   {
       $log = Log::orderBy('id','desc')->paginate(10);
       return response()->json(['meta' => $log]);
   }
}
