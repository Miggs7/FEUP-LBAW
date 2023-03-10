<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//Home

use App\Http\Controllers\AuctionController;
use App\Http\Controllers\ManagerController;

Route::get('/', function () {
    return view('pages.home');
});

//FAQ
Route::get('/faq', function () {
    return view('pages.faq');
});

//Contact
Route::get('/contact', function () {
    return view('pages.contact');
});

//about
Route::get('/about', function () {
    return view('pages.about');
});

//user
Route::get('/user/{id}', function () {
    return view('pages.user');
});
Route::put('/user/{id}/edit', 'UserController@update')->name('edit');
Route::put('/user/{id}/ban', 'UserController@ban');
Route::put('/user/{id}/delete','UserController@delete');


//Auction
Route::controller(AuctionController::class)->group(function () {
    Route::get('auction/new', function () {
        return view('pages.auctionNew');
    });
    Route::post('auction/new', 'create');
    Route::get('/auction/{id}', function () {
        return view('pages.auction');
    });
    Route::put('/auction/{id}/bid', 'bid');
    Route::put('/auction/{id}/edit', 'updateAuction');
    Route::delete('/auction/{id}/delete', 'delete');
});

//Payment
Route::post('auction/{id}/pay','PaymentController@payment');


//Manager
Route::controller(ManagerController::class)->group(function () {

Route::put('/manager/{id}/edit', 'updateManager');
Route::get('/manager/{id}', function () {
    return view('pages.manager');
    });
});

// Authentication
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

//Watch List
Route::get('/watchList/{id}', function () {
    return view('pages.watchList');
});
Route::post('watchList/{id}/add', 'WatchListController@addToWatchList');
Route::delete('watchList/{id}/delete', 'WatchListController@removeFromWatchList');

//Auction List
Route::get('/auctionlist/{id}', function () {
    return view('pages.auctionList');
});

//Category pages
Route::get('/auctionCategory/{id}', function () {
    return view('pages.auctionCategory');
});

Route::post('/review/new','ReviewController@create');

Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');
Route::post('password/email', 'Auth\ForgotPasswordController@getEmail')->name('password.email');