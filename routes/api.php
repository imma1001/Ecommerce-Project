<?php
use App\Http\Controllers\Api\BasApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::controller(BasApiController::class)-> group(function(){
    Route::post('/login','login');
    Route::post('/register','register');

});
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/logout', [BasApiController::class, 'logout']);
    Route::get('/profile', [BasApiController::class, 'profile']);
});

