<?php

use App\Http\Controllers\Front\StaticPageController;
use Illuminate\Support\Facades\Route;

Route::middleware('web')->get('/{slug}', [StaticPageController::class, 'resolve'])->name('front.page.resolve');
