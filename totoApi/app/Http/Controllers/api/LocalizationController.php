<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Localization;
use anlutro\LaravelSettings\SettingStore;

class LocalizationController extends Controller
{

    public function store(Request $request){
        setting(['latitude' => $request->latitude, 'longitude' => $request->longitude])->save();

        return response()->json(["message" => " localizacao adicionada"], 200);
    }

    public function index(){

        $data = [
            'latitude' => setting('latitude'),
            'longitude' => setting('longitude')
        ];

        return response()->json(["message" => "localization", "data" => $data], 200);
    }
}
