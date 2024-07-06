<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\UserController;
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
Route::get('/jobs/detail/{id}',[JobsController::class,'detail'])->name('jobDetail');
Route::post('/apply-job',[JobsController::class,'applyJob'])->name('applyJob');
Route::post('/save-job',[JobsController::class,'saveJob'])->name('saveJob');



Route::group(['prefix' => 'admin','middleware' => 'checkRole'], function(){
    Route::get('/dashboard',[DashboardController::class,'index'])->name('admin.dashboard');
    Route::get('/users',[UserController::class,'index'])->name('admin.users');
    Route::get('/users/{id}',[UserController::class,'edit'])->name('admin.users.edit');
    Route::get('/users/{id}',[UserController::class,'edit'])->name('admin.users.edit');
    Route::put('/users/{id}',[UserController::class,'update'])->name('admin.users.update');
    // Route::delete('/users',[UserController::class,'destroy'])->name('admin.users.destroy');
    // Route::get('/jobs',[JobController::class,'index'])->name('admin.jobs');
    // Route::get('/jobs/edit/{id}',[JobController::class,'edit'])->name('admin.jobs.edit');
    // Route::put('/jobs/{id}',[JobController::class,'update'])->name('admin.jobs.update');
    // Route::delete('/jobs',[JobController::class,'destroy'])->name('admin.jobs.destroy');
    // Route::get('/job-applications',[JobApplicationController::class,'index'])->name('admin.jobApplications');
    // Route::delete('/job-applications',[JobApplicationController::class,'destroy'])->name('admin.jobApplications.destroy');
});


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
    Route::get('account/my-job-applications',[AccountController::class,'myJobApplications'])->name('account.myJobApplications');
    Route::post('account/remove-job',[AccountController::class,'removeJobs'])->name('account.removeJobs');
    Route::get('account/saved-job',[AccountController::class,'savedJobs'])->name('account.savedJobs');
    Route::post('account/remove-saved-job',[AccountController::class,'removeSavedJob'])->name('account.removeSavedJob');
    Route::post('account/change-password',[AccountController::class,'updatePassword'])->name('account.updatePassword');
});

});
