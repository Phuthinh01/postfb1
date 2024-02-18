<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ToolFB;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/{notice?}', function () {
    return view('welcome');
});
Route::post('/get-token', [ToolFB::class, 'getToken'])->name('getToken');
Route::post('/post', [ToolFB::class, 'post'])->name('post');
