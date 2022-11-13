<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\SubmitController;
use App\Http\Controllers\ChallengeController;

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

Route::get('/',[UserController::class,'index'])->middleware("auth")->name("home");

Route::get('/login', function () { 
    return view('users.login'); 
})->name('login');

Route::post('/login',[UserController::class,'login'])->name('login');

Route::group([
    'prefix'=>'user',
    'middleware' => 'auth',
    'as' => 'user.'
], function (){
    Route::get('/me',[UserController::class,'me'])->name('me');
    Route::get('/logout',[UserController::class,'logout'])->name('logout');
    Route::get('/register', function () {
        if (Auth::user()->role_id!=1){
            return redirect()->back()->withErrors("error","You are not a teacher");
        }
        return view('users.register'); })->name('register');
    Route::post('/register',[UserController::class,'register'])->name('register');
    Route::get('/',[UserController::class,'index'])->name('index');
    Route::get('/detail/{id}',[UserController::class,'detail'])->name('detail');
    Route::get('/update/{id}',[UserController::class,"update"])->name('update');
    Route::post('/update/{id}',[UserController::class,'store'])->name('update');
    Route::get('/avatar/{id}',[UserController::class,"updateV2"])->name('avatar');
    Route::post('/avatar/{id}',[UserController::class,'storeV2'])->name('avatar');
    Route::delete('/delete/{id}',[UserController::class,'delete'])->name("delete");
});


Route::group([
    'prefix'=>'comment',
    'middleware' => 'auth',
    'as' => 'comment.'
], function (){
    Route::post('/create',[CommentController::class,'create'])->name('create');
    Route::delete('/delete/{id}',[CommentController::class,'delete'])->name('delete');
    Route::post('/update/{id}',[CommentController::class,'update'])->name('update');
});


Route::group([
    'prefix'=>'test',
    'middleware' => 'auth',
    'as' => 'test.'
], function (){
    Route::get('/',[TestController::class,'index'])->name('index');
    Route::get('/create',[TestController::class,'create'])->name('create');
    Route::post('/create',[TestController::class,'store'])->name('create');
    Route::get('/detail/{id}',[TestController::class,'detail'])->name('detail');
    Route::get('/download/{id}',[TestController::class,'download'])->name('download');
    Route::delete('/delete/{id}',[TestController::class,'delete'])->name('delete');
});


Route::group([
    'prefix'=>'submit',
    'middleware' => 'auth',
    'as' => 'submit.'
], function (){
    Route::post('/create/{id}',[SubmitController::class,'create'])->name('create');
    Route::get('/download/{id}',[SubmitController::class,'download'])->name('download');
});


Route::group([
    'prefix'=>'challenge',
    'middleware' => 'auth',
    'as' => 'challenge.'
], function (){
    Route::get('/',[ChallengeController::class,'index'])->name('index');
    Route::get('/create',[ChallengeController::class,'create'])->name('create');
    Route::post('/create',[ChallengeController::class,'store'])->name('create');
    Route::get('/answer/{id}',[ChallengeController::class,'answer'])->name('answer');
    Route::post('/answer/{id}',[ChallengeController::class,'answer'])->name('answer');
    Route::delete('/delete/{id}',[ChallengeController::class,'delete'])->name('delete');
});
