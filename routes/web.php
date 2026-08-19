<?php

use App\Http\Controllers\FaviconController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ActivityPageController;
use App\Http\Controllers\AlumniPageController;
use App\Http\Controllers\AlumniProfileEditController;
use App\Http\Controllers\AlumniProfileFormController;
use App\Http\Controllers\AlumniSelfRegistrationController;
use App\Http\Controllers\AuthLoginController;
use App\Http\Controllers\AuthRegisterController;
use App\Http\Controllers\BoardController;
use App\Http\Controllers\ElectionPageController;
use App\Http\Controllers\ElectionRegistrationController;
use App\Http\Controllers\ContactPageController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DocumentDownloadController;
use App\Http\Controllers\GalleryPageController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsPageController;
use App\Http\Controllers\PartnershipPageController;
use Illuminate\Support\Facades\Route;

Route::get('/favicon.ico', [FaviconController::class, 'favicon'])->name('favicon');
Route::get('/apple-touch-icon.png', [FaviconController::class, 'appleTouchIcon'])->name('favicon.apple');

Route::get('/', HomeController::class)->name('home');
Route::get('/tentang', AboutController::class)->name('about');
Route::get('/kepengurusan', BoardController::class)->name('board');
Route::get('/pemilihan-bgk', ElectionPageController::class)->name('election');
Route::get('/dokumen/{document:slug}/unduh', DocumentDownloadController::class)->name('documents.download');
Route::middleware('guest')->group(function (): void {
    Route::get('/masuk', [AuthLoginController::class, 'create'])->name('login');
    Route::post('/masuk', [AuthLoginController::class, 'store'])->middleware('throttle:10,1')->name('login.store');
    Route::get('/daftar', [AuthRegisterController::class, 'create'])->name('register');
    Route::post('/daftar', [AuthRegisterController::class, 'store'])->middleware('throttle:5,1')->name('register.store');
    Route::get('/auth/google', [GoogleAuthController::class, 'redirect'])->name('auth.google');
    Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback'])->name('auth.google.callback');
});

Route::post('/keluar', [AuthLoginController::class, 'destroy'])->middleware('auth')->name('logout');

Route::middleware('auth')->group(function (): void {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
    Route::get('/dashboard/profil-alumni', [AlumniProfileEditController::class, 'edit'])->name('alumni.profile.edit');
    Route::put('/dashboard/profil-alumni', [AlumniProfileEditController::class, 'update'])->middleware('throttle:10,1')->name('alumni.profile.update');
});

Route::get('/daftar-bgk', ElectionRegistrationController::class)->name('election.register');
Route::post('/daftar-bgk', [ElectionRegistrationController::class, 'submit'])->middleware('throttle:3,1')->name('election.register.submit');

Route::redirect('/admin/login', '/masuk');
Route::get('/alumni/isi-profil/{token}', [AlumniProfileFormController::class, 'show'])->name('alumni.profile.form');
Route::post('/alumni/isi-profil/{token}', [AlumniProfileFormController::class, 'submit'])->middleware('throttle:10,1')->name('alumni.profile.form.submit');
Route::get('/alumni/daftar-profil', [AlumniSelfRegistrationController::class, 'create'])->name('alumni.register');
Route::post('/alumni/daftar-profil', [AlumniSelfRegistrationController::class, 'store'])->middleware('throttle:5,1')->name('alumni.register.store');
Route::get('/alumni', AlumniPageController::class)->name('alumni');
Route::get('/alumni/angkatan/{batch:slug}', [AlumniPageController::class, 'batch'])->name('alumni.batch');
Route::get('/alumni/{alumni:slug}', [AlumniPageController::class, 'show'])->name('alumni.show');
Route::get('/kegiatan', ActivityPageController::class)->name('activities');
Route::get('/kegiatan/{activity:slug}', [ActivityPageController::class, 'show'])->name('activities.show');
Route::get('/berita', NewsPageController::class)->name('news');
Route::get('/berita/{news:slug}', [NewsPageController::class, 'show'])->name('news.show');
Route::post('/berita/langganan', [NewsPageController::class, 'subscribe'])->middleware('throttle:5,1')->name('news.subscribe');
Route::get('/galeri', GalleryPageController::class)->name('gallery');
Route::get('/kemitraan', PartnershipPageController::class)->name('partnership');
Route::redirect('/kemitraan/mitra/bank-syariah-indonesia', '/kemitraan/mitra/bank-mitra-utama', 301);
Route::get('/kemitraan/mitra/{partner:slug}', [PartnershipPageController::class, 'show'])->name('partnership.show');
Route::post('/kemitraan/ajukan', [PartnershipPageController::class, 'submit'])->middleware('throttle:5,1')->name('partnership.submit');
Route::get('/kontak', ContactPageController::class)->name('contact');
Route::post('/kontak/kirim', [ContactPageController::class, 'submit'])->middleware('throttle:5,1')->name('contact.submit');
