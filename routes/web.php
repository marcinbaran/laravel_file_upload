<?php

use App\Http\Controllers\FileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [FileController::class, 'index'])->name('dashboard');
    Route::post('/upload', [FileController::class, 'store'])->name('upload');
    Route::get('/download/{file}', [FileController::class, 'download'])->name('download');
    Route::delete('/delete/{file}', [FileController::class, 'destroy'])->name('delete');
});

//require __DIR__.'/auth.php';

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
