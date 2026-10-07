<?php

namespace App\Http\Controllers\Front;

use App\Models\Document;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DocumentController extends ContentListController
{
    protected function modelClass(): string
    {
        return Document::class;
    }

    protected function title(): string
    {
        return __('front.menu.documents');
    }

    protected function routeShow(string $slug): string
    {
        return route('front.documents.show', $slug);
    }

    public function download(string $slug): StreamedResponse|RedirectResponse
    {
        $document = Document::published()->with('fileMedia')->where('slug', $slug)->firstOrFail();
        $media = $document->fileMedia;
        if (! $media) {
            return redirect()->route('front.documents.show', $slug);
        }
        $document->increment('download_count');

        return Storage::disk($media->disk)->download($media->path, $media->original_filename);
    }
}
