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
Route::apiResource('dogs', 'api\DogController');

Route::apiResource('login', 'api\Logincontroller');



Route::group([
    'prefix' => 'auth',
    'namespace' => 'api',
], function () {
    Route::post('login', 'AuthController@login');
    Route::post('register', 'AuthController@register');
    Route::post('password/reset', 'AuthController@reset');
    Route::group([
        'middleware' => 'auth:api'
    ], function() {
          Route::get('logout', 'AuthController@logout');
          Route::get('user', 'AuthController@user');
          Route::post('user', 'AuthController@profile');
    });
});



    
Route::group(array('prefix' => 'api',   'middleware' => 'cors'), function()
{

  Route::get('/', function () {
      return response()->json(['message' => 'Hernandes Api', 'status' => 'Connected']);;
  });

  Route::resource('/login', 'api\LoginController');
});
