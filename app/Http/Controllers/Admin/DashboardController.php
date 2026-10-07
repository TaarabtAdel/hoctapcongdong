<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\ContactMessage;
use App\Models\Event;
use App\Models\News;
use App\Models\Registration;
use App\Services\Slug\SlugService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('admin.dashboard', [
            'stats' => [
                'Tin tức' => News::count(),
                'Thông báo' => Announcement::count(),
                'Sự kiện' => Event::count(),
                'Đăng ký mới' => Registration::where('status', 'new')->count(),
                'Liên hệ chưa đọc' => ContactMessage::where('is_read', false)->count(),
            ],
            'recentRegistrations' => Registration::latest()->limit(5)->get(),
        ]);
    }

    public function slugCheck(Request $request, SlugService $slugService): JsonResponse
    {
        $request->validate([
            'title' => ['required', 'string'],
            'model' => ['required', 'string'],
            'id' => ['nullable', 'integer'],
        ]);

        $class = 'App\\Models\\'.$request->string('model');
        abort_unless(class_exists($class), 422);
        $model = $request->filled('id') ? $class::find($request->integer('id')) : new $class;
        $slug = $slugService->generate($request->string('title')->toString(), $model);

        return response()->json(['slug' => $slug, 'available' => ! $slugService->exists($slug, $model)]);
    }
}
