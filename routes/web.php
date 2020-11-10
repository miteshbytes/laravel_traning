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

Route::resource('/roles', "RoleController")->middleware('admin');

Route::resource('/students', "StudentController");

Route::get('/logout', function (Request $request) {
    $request->session()->forget('user_data');
    return redirect()->route('login.index')->with('success', 'Logout sucessfully.');
});
