<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Media extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];

    protected $casts = [
        'variants' => 'array',
        'size' => 'integer',
    ];

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function url(?string $variant = null): string
    {
        if ($variant && isset($this->variants[$variant])) {
            return Storage::disk($this->disk)->url($this->variants[$variant]);
        }

        return Storage::disk($this->disk)->url($this->path);
    }
}
