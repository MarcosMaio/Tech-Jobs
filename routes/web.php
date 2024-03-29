<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\fileUploadController;
use App\Http\Controllers\JobListingController;
use App\Http\Controllers\PostJobController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

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

Route::get('/', [JobListingController::class, 'index'])->name('index');
Route::get('/job/{listing:slug}', [JobListingController::class, 'show'])->name('job.show');
Route::get('/company/{id}', [JobListingController::class, 'company'])->name('company');

Route::post ('/resume/upload', [fileUploadController::class, 'store'])->middleware('auth');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/login');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::get('/register/seeker', [UserController::class, 'createSeeker'])->name('create.seeker');
Route::post('/register/seeker', [UserController::class, 'storeSeeker'])->name('store.seeker');

Route::get('/register/employer', [UserController::class, 'createEmployer'])->name('create.employer');
Route::post('/register/employer', [UserController::class, 'storeEmployer'])->name('store.employer');

Route::get('/login', [UserController::class, 'login'])->name('login');
Route::post('/login', [UserController::class, 'postLogin'])->name('login.post');
route::post('/logout', [UserController::class, 'logout'])->name('logout');

Route::get('user/profile', [UserController::class, 'profile'])->name('user.profile');
Route::get('user/profile/seeker', [UserController::class, 'seekerProfile'])->name('user.profile.seeker');
Route::post('user/update/profile', [UserController::class, 'updateProfile'])->name('user.update.profile');
Route::post('user/password', [UserController::class, 'changePassword'])->name('user.password')->middleware('auth');
Route::post('upload/resume', [UserController::class, 'uploadResume'])->name('upload.resume')->middleware('auth');
Route::get('user/job/applied', [UserController::class, 'jobApplied'])->name('job.applied')
->middleware(['auth','verified']);

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('verified')->name('dashboard');
Route::get('/verify', [DashboardController::class, 'verify'])->name('verification.notice');

Route::get('/resend/verification/email', [DashboardController::class, 'resend'])->name('resend.email');

Route::get('/subscribe', [SubscriptionController::class, 'subscribe'])->name('subscribe');
Route::get('/pay/weekly', [SubscriptionController::class, 'initiatePayment'])->name('pay.weekly');
Route::get('/pay/monthly', [SubscriptionController::class, 'initiatePayment'])->name('pay.monthly');
Route::get('/pay/yearly', [SubscriptionController::class, 'initiatePayment'])->name('pay.yearly');
Route::get('/payment/success', [SubscriptionController::class, 'paymentSuccess'])->name('payment.success');
Route::get('/payment/cancel', [SubscriptionController::class, 'paymentCancel'])->name('payment.cancel');

Route::get('job', [PostJobController::class, 'index'])->name('job.index');
Route::get('jobcreate', [PostJobController::class, 'create'])->name('job.create');
Route::post('job/store', [PostJobController::class, 'store'])->name('job.store');
Route::get('job/{id}/edit', [PostJobController::class, 'edit'])->name('job.edit');
Route::put('job/{id}/update', [PostJobController::class, 'update'])->name('job.update');
Route::delete('job/{id}/delete', [PostJobController::class, 'destroy'])->name('job.delete');

Route::get('applicants', [ApplicationController::class, 'index'])->name('applicants.index');
Route::get('applicants/{listing:slug}', [ApplicationController::class, 'show'])->name('applicants.show');
Route::post('shortlist/{listingId}/{userId}', [ApplicationController::class, 'shortlist'])->name('applicants.shortlist');
Route::post('application/{listingId}/submit', [ApplicationController::class, 'apply'])->name('application.submit');
