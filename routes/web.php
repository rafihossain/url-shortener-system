<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UrlShortenerController;
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
    return view('auth.login');
});

Route::middleware(['auth', 'verified'])->group(function(){
    Route::get('/dashboard', [UrlShortenerController::class, 'index'])->name('dashboard');
    Route::post('/generate/url/store', [UrlShortenerController::class, 'store'])->name('url.shortener.store');
    Route::get('{shortener_url}', [UrlShortenerController::class, 'shortenLink'])->name('shortener.url.link');
    Route::post('count-link', [UrlShortenerController::class, 'countLink'])->name('shortener.url.link.count');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


