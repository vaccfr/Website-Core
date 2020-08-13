<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/atis/{atis_letter}/{deprwy}/{arrrwy}/{app}/{dep}', 'ATC\AtisController@Index');
Route::get('/atisurl', function() {
  return config('app.url')."/api/atis/\$atiscode/\$deprwy(\$atisairport)/\$arrrwy(\$atisairport)/<b>APPROACH TYPE</b>/<b>SID</b>/?m=\$metar(\$atisairport)";
});

// http://vatfrance.build/api/c/04R/04L/ILS/6W?m=LFPG%20130900Z%2019008KT%20150V210%20CAVOK%2025/17%20Q1013%20NOSIG

// /$atiscode/$deprwy($atisairport)/$arrrwy($atisairport)/<b>ILS</b>/<b>SID</b>/?m=$metar($atisairport)