<?php

namespace App\Support\Database;

use Illuminate\Database\Schema\Blueprint;

class ContentColumns
{
    /**
     * Cột dùng chung cho các bảng nội dung.
     */
    public static function apply(Blueprint $table, bool $withAuthor = true): void
    {
        $table->string('title');
        $table->string('slug')->unique();
        $table->text('excerpt')->nullable();
        $table->longText('content')->nullable();
        $table->foreignId('featured_image_id')->nullable()->constrained('media')->nullOnDelete();
        $table->string('status', 20)->default('draft')->index();
        $table->timestamp('published_at')->nullable()->index();
        if ($withAuthor) {
            $table->foreignId('author_id')->nullable()->constrained('users')->nullOnDelete();
        }
        $table->string('seo_title')->nullable();
        $table->text('seo_description')->nullable();
        $table->string('seo_keywords')->nullable();
        $table->foreignId('og_image_id')->nullable()->constrained('media')->nullOnDelete();
        $table->boolean('is_featured')->default(false);
        $table->unsignedBigInteger('view_count')->default(0);
        $table->integer('sort_order')->default(0);
        $table->timestamps();
        $table->softDeletes();

        $table->index(['status', 'published_at']);
    }
}
