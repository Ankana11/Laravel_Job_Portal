<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\HomeController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/',[HomeController::class,'index'])->name('home');
Route::get('account/register',[AccountController::class,'registration'])->name('account.registration');
Route::post('account/proccess-register',[AccountController::class,'proccessRegistration'])->name('account.proccessRegistration');
Route::get('account/login',[AccountController::class,'login'])->name('account.login');
