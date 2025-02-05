<?php

use App\Http\Controllers\userAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\memberController;
use App\Models\User;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get("/test",function(){
    return "Hello World";
});

Route::post('signup', [userAuthController::class, 'signup'])->name('signup');
// Route::post('login', [userAuthController::class, 'login'])->name('login');


Route::group(['middleware'=>"auth:sanctum"],function(){
    Route::get("students",[StudentController::class,'list']);
    Route::post("add-student",[StudentController::class,'addStudent']);
    Route::post("update-user",[StudentController::class,'update']);
    Route::get('delete-user/{id}',[StudentController::class,'delete']);
    Route::get('user/{name}',[StudentController::class,'search']);

    Route::resource('member',memberController::class);
});