<?php

use App\Http\Controllers\Frontend\LanguageController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\ProfileController;
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

Route::get('/', [HomeController::class,'index'])->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::get('language',LanguageController::class)->name('language');

//News Detail Routes

Route::get('news-details/{slug}',[HomeController::class,'showNews'])->name('news-details');

//News Routes

Route::get('news',[HomeController::class,'news'])->name('news');

//News Comment Routes

Route::post('news-comment',[HomeController::class,'handleComment'])->name('news-comment');
Route::post('news-comment-reply',[HomeController::class,'handleReply'])->name('news-comment-reply');
Route::delete('news-comment-destory',[HomeController::class,'commentDestory'])->name('news-comment-destory');

// Newsletter Routes
Route::post('subscribe-newsletter', [HomeController::class, 'SubscribeNewsLetter'])->name('subscribe-newsletter');

// About Page Route
Route::get('about', [HomeController::class, 'about'])->name('about');

// Contact Page Route
Route::get('contact', [HomeController::class, 'contact'])->name('contact');

// Contact Page Route
Route::post('contact', [HomeController::class, 'handleContactFrom'])->name('contact.submit');
