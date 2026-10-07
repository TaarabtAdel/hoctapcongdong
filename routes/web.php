<?php

use App\Http\Controllers\Front\AnnouncementController;
use App\Http\Controllers\Front\ContactController;
use App\Http\Controllers\Front\DocumentController;
use App\Http\Controllers\Front\EventController;
use App\Http\Controllers\Front\GalleryController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\LearningModelController;
use App\Http\Controllers\Front\LibraryController;
use App\Http\Controllers\Front\NewsController;
use App\Http\Controllers\Front\PreviewController;
use App\Http\Controllers\Front\ProgramController;
use App\Http\Controllers\Front\RegistrationController;
use App\Http\Controllers\Front\RoleModelController;
use App\Http\Controllers\Front\SearchController;
use App\Http\Controllers\Front\SitemapController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

Route::get('/tin-tuc', [NewsController::class, 'index'])->name('front.news.index');
Route::get('/tin-tuc/{slug}', [NewsController::class, 'show'])->name('front.news.show');
Route::get('/thong-bao', [AnnouncementController::class, 'index'])->name('front.announcements.index');
Route::get('/thong-bao/{slug}', [AnnouncementController::class, 'show'])->name('front.announcements.show');
Route::get('/lich-hoat-dong', [EventController::class, 'index'])->name('front.events.index');
Route::get('/lich-hoat-dong/lich-thang', [EventController::class, 'calendar'])->name('front.events.calendar');
Route::get('/su-kien/{slug}', [EventController::class, 'show'])->name('front.events.show');
Route::get('/chuong-trinh-hoc-tap', [ProgramController::class, 'index'])->name('front.programs.index');
Route::get('/chuong-trinh-hoc-tap/{slug}', [ProgramController::class, 'show'])->name('front.programs.show');
Route::get('/van-ban-tai-lieu', [DocumentController::class, 'index'])->name('front.documents.index');
Route::get('/van-ban-tai-lieu/{slug}', [DocumentController::class, 'show'])->name('front.documents.show');
Route::get('/van-ban-tai-lieu/{slug}/tai-xuong', [DocumentController::class, 'download'])->name('front.documents.download');

Route::get('/hoc-tap-suot-doi', [LearningModelController::class, 'index'])->name('front.learning-models.index');
Route::get('/mo-hinh/{slug}', [LearningModelController::class, 'show'])->name('front.learning-models.show');

Route::get('/thu-vien-so', [LibraryController::class, 'index'])->name('front.library.index');
Route::get('/thu-vien-so/{slug}', [LibraryController::class, 'show'])->name('front.library.show');

Route::get('/guong-hoc-tap', [RoleModelController::class, 'index'])->name('front.role-models.index');
Route::get('/guong-hoc-tap/{slug}', [RoleModelController::class, 'show'])->name('front.role-models.show');

Route::get('/hinh-anh-video', [GalleryController::class, 'index'])->name('front.gallery.index');
Route::get('/hinh-anh-video/{slug}', [GalleryController::class, 'show'])->name('front.gallery.show');

Route::get('/lien-he', [ContactController::class, 'create'])->name('front.contact.create');
Route::post('/lien-he', [ContactController::class, 'store'])->middleware('throttle:5,1')->name('front.contact.store');

Route::get('/dang-ky-hoc-tap', [RegistrationController::class, 'create'])->name('front.registration.create');
Route::post('/dang-ky-hoc-tap', [RegistrationController::class, 'store'])->middleware('throttle:5,1')->name('front.registration.store');
Route::get('/cam-on-dang-ky', [RegistrationController::class, 'thanks'])->name('front.registration.thanks');

Route::get('/preview/{type}/{id}', [PreviewController::class, 'show'])->name('front.preview');

Route::get('/tim-kiem', [SearchController::class, 'index'])->name('front.search');
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('front.sitemap');
Route::get('/robots.txt', [SitemapController::class, 'robots'])->name('front.robots');
