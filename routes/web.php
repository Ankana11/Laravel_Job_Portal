<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JobsController;
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
Route::get('/jobs',[JobsController::class,'index'])->name('jobs');


Route::group(['account'],function(){
    //Guest route

Route::group(['middleware' => 'guest'], function(){
    Route::get('account/register',[AccountController::class,'registration'])->name('account.registration');
    Route::post('account/proccess-register',[AccountController::class,'proccessRegistration'])->name('account.proccessRegistration');
    Route::get('account/login',[AccountController::class,'login'])->name('account.login');
    Route::post('account/authenticate',[AccountController::class,'authenticate'])->name('account.authenticate');
});

//Authenticate route

Route::group(['middleware' => 'auth'], function(){
    Route::get('account/profile',[AccountController::class,'profile'])->name('account.profile');
    Route::put('account/update-profile',[AccountController::class,'updateprofile'])->name('account.updateprofile');
    Route::get('account/logout',[AccountController::class,'logout'])->name('account.logout');
    Route::post('account/update-profile-pic',[AccountController::class,'updateprofilepic'])->name('account.updateprofilepic');
    Route::get('account/create-job',[AccountController::class,'createJob'])->name('account.createJob');
    Route::post('account/save-job',[AccountController::class,'savejob'])->name('account.savejob');
    Route::get('account/my-job',[AccountController::class,'myjob'])->name('account.myjob');
    Route::get('account/edit-job/{jobId}',[AccountController::class,'editjob'])->name('account.editjob');
    Route::post('account/update-job/{jobId}',[AccountController::class,'updatejob'])->name('account.updatejob');
    Route::post('account/delete-job',[AccountController::class,'deletejob'])->name('account.deletejob');

});

});
