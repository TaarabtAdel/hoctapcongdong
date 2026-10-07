<?php

use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\AnnouncementController;
use App\Http\Controllers\Admin\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Auth\ResetPasswordController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DocumentController;
use App\Http\Controllers\Admin\DocumentLevelController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\LearningModelController;
use App\Http\Controllers\Admin\LibraryItemController;
use App\Http\Controllers\Admin\LibraryTypeController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\NewsCategoryController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ProgramController;
use App\Http\Controllers\Admin\RedirectController;
use App\Http\Controllers\Admin\RegistrationController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\RoleModelController;
use App\Http\Controllers\Admin\ScreenOptionsController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\ToolsController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\WidgetController;
use Illuminate\Support\Facades\Route;

Route::middleware('web')->prefix(config('htcd.admin_path', 'admin'))->name('admin.')->group(function (): void {
    Route::middleware('guest')->group(function (): void {
        Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
        Route::post('login', [LoginController::class, 'login'])->middleware('throttle:5,1');
        Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
        Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
        Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
        Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');
    });

    Route::middleware(['auth', 'admin.access', 'admin.password'])->group(function (): void {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::post('logout', [LoginController::class, 'logout'])->name('logout');

        Route::resource('pages', PageController::class)->except(['show']);
        Route::resource('news', NewsController::class)->except(['show']);
        Route::resource('news-categories', NewsCategoryController::class)->except(['show']);
        Route::resource('tags', TagController::class)->except(['show']);
        Route::resource('announcements', AnnouncementController::class)->except(['show']);
        Route::resource('events', EventController::class)->except(['show']);
        Route::resource('programs', ProgramController::class)->except(['show']);
        Route::resource('role-models', RoleModelController::class)->except(['show']);
        Route::resource('learning-models', LearningModelController::class)->except(['show']);
        Route::resource('library-items', LibraryItemController::class)->except(['show']);
        Route::resource('library-types', LibraryTypeController::class)->except(['show']);
        Route::resource('documents', DocumentController::class)->except(['show']);
        Route::resource('document-levels', DocumentLevelController::class)->except(['show']);
        Route::resource('galleries', GalleryController::class)->except(['show']);
        Route::resource('registrations', RegistrationController::class)->only(['index', 'show', 'update', 'destroy']);
        Route::resource('contacts', ContactMessageController::class)->only(['index', 'show', 'update', 'destroy']);
        Route::resource('media', MediaController::class)->only(['index', 'store', 'update', 'destroy']);
        Route::resource('menus', MenuController::class)->except(['show']);
        Route::post('menus/{menu}/items', [MenuController::class, 'storeItem'])->name('menus.items.store');
        Route::delete('menus/{menu}/items/{item}', [MenuController::class, 'destroyItem'])->name('menus.items.destroy');
        Route::put('screen-options', [ScreenOptionsController::class, 'update'])->name('screen-options.update');
        Route::resource('sliders', SliderController::class)->except(['show']);
        Route::resource('redirects', RedirectController::class)->except(['show']);
        Route::resource('widgets', WidgetController::class)->except(['show']);
        Route::resource('banners', BannerController::class)->except(['show']);
        Route::get('activity-log', [ActivityLogController::class, 'index'])->name('activity.index');
        Route::get('registrations/export/csv', [RegistrationController::class, 'export'])->name('registrations.export');
        Route::resource('users', UserController::class)->except(['show']);
        Route::resource('roles', RoleController::class)->except(['show']);

        Route::get('settings/{group?}', [SettingController::class, 'edit'])->name('settings.edit');
        Route::put('settings/{group?}', [SettingController::class, 'update'])->name('settings.update');

        Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');

        Route::post('tools/clear-cache', [ToolsController::class, 'clearCache'])->name('tools.clear-cache');
        Route::post('tools/backup-database', [ToolsController::class, 'backupDatabase'])->name('tools.backup-database');

        Route::get('ajax/slug-check', [DashboardController::class, 'slugCheck'])->name('ajax.slug-check');
        Route::get('ajax/media', [MediaController::class, 'ajaxList'])->name('ajax.media.list');

        foreach ([
            'news' => NewsController::class,
            'pages' => PageController::class,
            'announcements' => AnnouncementController::class,
            'events' => EventController::class,
            'programs' => ProgramController::class,
            'role-models' => RoleModelController::class,
            'learning-models' => LearningModelController::class,
            'library-items' => LibraryItemController::class,
            'documents' => DocumentController::class,
            'galleries' => GalleryController::class,
        ] as $uri => $controller) {
            Route::post($uri.'/bulk', [$controller, 'bulkAction'])->name($uri.'.bulk');
            Route::post($uri.'/quick-edit', [$controller, 'quickEdit'])->name($uri.'.quick-edit');
            Route::post($uri.'/autosave', [$controller, 'autosave'])->name($uri.'.autosave');
            Route::post($uri.'/restore-revision', [$controller, 'restoreRevision'])->name($uri.'.restore-revision');
        }
    });
});
