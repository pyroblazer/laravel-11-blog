<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

use App\Livewire\MyPosts;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('login-page');
})->name('login');

Route::get('/registration/form',[AuthController::class,'loadRegisterForm']);
Route::post('/register/user',[AuthController::class,'registerUser'])->name('registerUser');

Route::get('/login/form',[AuthController::class,'loadLoginPage']);

Route::post('/login/user',[AuthController::class,'LoginUser'])->name('LoginUser');

Route::get('/logout',[AuthController::class,'LogoutUser']);

Route::get('/forgot/password',[AuthController::class,'forgotPassword']);

Route::post('/forgot',[AuthController::class,'forgot'])->name('forgot');

Route::get('/reset/password',[AuthController::class,'loadResetPassword']);

Route::post('/reset/user/password',[AuthController::class,'ResetPassword'])->name('ResetPassword');

Route::get('/404',[AuthController::class,'load404']);
// create controllers for each user
Route::get('user/home',[UserController::class,'loadHomePage'])->middleware('user')->middleware('verified');
Route::get('posts/user', [UserController::class,'loadMyPosts'])->middleware('user');
Route::get('posts/bookmarked', [UserController::class,'loadBookmarkedPosts'])->middleware('user');
Route::get('create/post', [UserController::class,'loadCreatePost'])->middleware('user');
Route::get('/edit/post/{post_id}', [UserController::class,'loadEditPost'])->middleware('user');
Route::get('/view/post/{id}',[UserController::class,'loadPostPage'])->middleware('user');
Route::get('/profile',[UserController::class,'loadProfile'])->middleware('user');
Route::get('/view/profile/{user_id}',[UserController::class,'loadGuestProfile'])->middleware('user');


Route::get('admin/home',[AdminController::class,'loadHomePage'])->middleware('admin');

// Email verification

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
 
    return redirect('/');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    if ($request->user()->hasVerifiedEmail()) {
        return redirect()->route('login')->with('message', 'Your email is already verified.');
    }

    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'A new verification link has been sent to your email address.');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');