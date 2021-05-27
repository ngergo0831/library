<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\BorrowController;
use App\Http\Controllers\ProfileController;

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
    return redirect()->route('books.index');
})->name('home');

Route::get('/home', function () {
    return redirect()->route('books.index');
});

Auth::routes();

Route::resource('books', BookController::class);
Route::resource('genres', GenreController::class);
Route::resource('borrows', BorrowController::class);
Route::resource('profile', ProfileController::class);
