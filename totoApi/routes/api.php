<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(array('prefix' => 'api'), function(){
    Route::get('/' , function(){
        return response()->json(['message' => 'Connected API']);
    });

    Route::post('/login', 'api\LoginController@login');
    Route::get('/logout', 'api\LoginController@logout');
    Route::get('/teste', 'api\LoginController@teste');
});
