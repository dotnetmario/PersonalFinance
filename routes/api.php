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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['prefix' => 'auth'], function () {
    //login route
    Route::post('login', 'AuthController@login');
    //register route
    Route::post('register', 'AuthController@register');
  
    //connected only routes
    Route::group(['middleware' => 'auth:api'], function() {
        //logout route
        Route::get('logout', 'AuthController@logout');
    });
});
Route::get('x', 'IncomesController@x');
Route::group(['prefix' => 'incomes', 'middleware' => 'auth:api'], function() {
    // get incomes an income
    Route::post('/', 'IncomesController@incomes');
    // add an income
    Route::post('/manage', 'IncomesController@manage');
});