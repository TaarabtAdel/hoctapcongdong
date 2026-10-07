<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use App\Services\Media\MediaUploadService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MediaController extends Controller
{
    public function index(Request $request): View
    {
        $media = Media::query()->latest()->paginate(40);

        return view('admin.media.index', compact('media'));
    }

    public function store(Request $request, MediaUploadService $uploadService): JsonResponse|RedirectResponse
    {
        $request->validate(['files' => ['required'], 'files.*' => ['file', 'max:10240']]);
        $created = [];
        foreach ($request->file('files', []) as $file) {
            $created[] = $uploadService->upload($file, $request->user()->id);
        }

        if ($request->expectsJson()) {
            return response()->json(['items' => $created]);
        }

        return back()->with('success', __('admin.messages.uploaded'));
    }

    public function update(Request $request, Media $medium): JsonResponse
    {
        $data = $request->validate([
            'alt' => ['nullable', 'string'],
            'title' => ['nullable', 'string'],
            'caption' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
        ]);
        $medium->update($data);

        return response()->json(['ok' => true, 'item' => $medium]);
    }

    public function destroy(Media $medium): RedirectResponse
    {
        $medium->delete();

        return back()->with('success', __('admin.messages.deleted'));
    }

    public function ajaxList(Request $request): JsonResponse
    {
        $items = Media::query()
            ->when($request->filled('s'), fn ($q) => $q->where('original_filename', 'like', '%'.$request->s.'%'))
            ->latest()
            ->limit(50)
            ->get();

        return response()->json([
            'items' => $items->map(fn (Media $m) => [
                'id' => $m->id,
                'path' => $m->path,
                'original_filename' => $m->original_filename,
                'url' => $m->url('thumb'),
            ]),
        ]);
    }
}
