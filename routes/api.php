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
    //login route (done)
    Route::post('login', 'AuthController@login');
    //register route (done)
    Route::post('register', 'AuthController@register');
  
    //connected only routes
    Route::group(['middleware' => 'auth:api'], function() {
        //logout route
        Route::get('logout', 'AuthController@logout');
    });
});
Route::get('x', 'IncomesController@x');
// incomes routes
Route::group(['prefix' => 'incomes', 'middleware' => 'auth:api'], function() {
    // get incomes (done)
    Route::post('/', 'IncomesController@incomes');
    // add/edit/delete income (done)
    Route::post('/manage', 'IncomesController@manage');

    // prices
    Route::group(['prefix' => 'prices'], function() {
        // get income prices (done)
        Route::post('/', 'IncomePricesController@prices');
        // manage income prices add/edit/delete (done)
        Route::post('/manage', 'IncomePricesController@manage');
    });

    // transactions
    Route::group(['prefix' => 'transactions'], function() {
        // get income transactions (done)
        Route::post('/', 'IncomeTransactionsController@transactions');
        // manage income transactions add/edit/delete (done)
        Route::post('/manage', 'IncomeTransactionsController@manage');
    });
});

// expences routes
Route::group(['prefix' => 'expences', 'middleware' => 'auth:api'], function() {
    // get expences (done)
    Route::post('/', 'ExpencesController@expences');
    // add/edit/delete expence (done)
    Route::post('/manage', 'ExpencesController@manage');

    // prices
    Route::group(['prefix' => 'prices'], function() {
        // get income prices (done)
        Route::post('/', 'ExpencePricesController@prices');
        // manage income prices add/edit/delete (done)
        Route::post('/manage', 'ExpencePricesController@manage');
    });

    // transactions
    Route::group(['prefix' => 'transactions'], function() {
        // get income transactions (done)
        Route::post('/', 'ExpenceTransactionsController@transactions');
        // manage income transactions add/edit/delete (done)
        Route::post('/manage', 'ExpenceTransactionsController@manage');
    });
});