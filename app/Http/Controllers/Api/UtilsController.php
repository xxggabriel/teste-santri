<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UtilsController extends Controller
{
    public static function retorno($data = [], $error = false, $message = null)
    {
        return [
            "error"     => $error,
            "message"   => $message,
            "data"      => $data
        ];
    }
}
