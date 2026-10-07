<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Spatie\Activitylog\Models\Activity;

class ActivityLogController extends Controller
{
    public function index(Request $request): View
    {
        $query = Activity::query()->with('causer')->latest();

        if ($request->filled('s')) {
            $s = $request->string('s')->toString();
            $query->where('description', 'like', "%{$s}%");
        }

        return view('admin.activity.index', [
            'items' => $query->paginate(40)->withQueryString(),
        ]);
    }
}
