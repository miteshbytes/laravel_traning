<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::resource('/login', "LoginController");

Route::group(['middleware' => ['isAuth']], function () {

    Route::resource('/roles', "RoleController")->middleware('admin');

    Route::post('student/search', 'StudentController@search')->name('student.search');
    Route::resource('/students', "StudentController");

    Route::get('/logout', function (Request $request) {
        $request->session()->forget('user_data');
        return redirect()->route('login.index')->with('success', 'Logout sucessfully.');
    });

    Route::get('users/search', 'UserController@search')->name('user.search');
    Route::post('users/search', 'UserController@search')->name('user.search');
    Route::get('users', ['uses'=>'UserController@index', 'as'=>'users.index']);

});


