<?php

namespace App\Services\Media;

use App\Models\Media;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MediaUploadService
{
    public function __construct(private MediaImageProcessor $imageProcessor) {}

    public function upload(UploadedFile $file, ?int $userId = null): Media
    {
        $folder = 'uploads/'.now()->format('Y/m');
        $safeName = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
        $ext = strtolower($file->getClientOriginalExtension());
        $filename = $safeName.'-'.Str::random(6).'.'.$ext;
        $path = $file->storeAs($folder, $filename, 'public');

        $media = Media::query()->create([
            'path' => $path,
            'filename' => $filename,
            'original_filename' => $file->getClientOriginalName(),
            'mime_type' => $file->getMimeType() ?: 'application/octet-stream',
            'size' => $file->getSize(),
            'uploaded_by' => $userId,
        ]);

        if (str_starts_with($media->mime_type, 'image/')) {
            $fullPath = Storage::disk('public')->path($path);
            $this->imageProcessor->process($media, $fullPath);
        }

        return $media->fresh();
    }
}
