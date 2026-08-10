<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\ActivityPageController;
use App\Http\Controllers\AlumniPageController;
use App\Http\Controllers\ElectionPageController;
use App\Http\Controllers\ElectionRegistrationController;
use App\Http\Controllers\ContactPageController;
use App\Http\Controllers\DocumentDownloadController;
use App\Http\Controllers\GalleryPageController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsPageController;
use App\Http\Controllers\PartnershipPageController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');
Route::get('/tentang', AboutController::class)->name('about');
Route::get('/pemilihan-bgk', ElectionPageController::class)->name('election');
Route::get('/dokumen/{document:slug}/unduh', DocumentDownloadController::class)->name('documents.download');
Route::get('/daftar-bgk', ElectionRegistrationController::class)->name('election.register');
Route::post('/daftar-bgk', [ElectionRegistrationController::class, 'submit'])->name('election.register.submit');
Route::get('/alumni', AlumniPageController::class)->name('alumni');
Route::get('/alumni/{alumni:slug}', [AlumniPageController::class, 'show'])->name('alumni.show');
Route::get('/kegiatan', ActivityPageController::class)->name('activities');
Route::get('/kegiatan/{activity:slug}', [ActivityPageController::class, 'show'])->name('activities.show');
Route::get('/berita', NewsPageController::class)->name('news');
Route::get('/berita/{news:slug}', [NewsPageController::class, 'show'])->name('news.show');
Route::post('/berita/langganan', [NewsPageController::class, 'subscribe'])->name('news.subscribe');
Route::get('/galeri', GalleryPageController::class)->name('gallery');
Route::get('/kemitraan', PartnershipPageController::class)->name('partnership');
Route::post('/kemitraan/ajukan', [PartnershipPageController::class, 'submit'])->name('partnership.submit');
Route::get('/kontak', ContactPageController::class)->name('contact');
Route::post('/kontak/kirim', [ContactPageController::class, 'submit'])->name('contact.submit');
