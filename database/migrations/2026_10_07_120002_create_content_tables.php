<?php

use App\Support\Database\ContentColumns;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            ContentColumns::apply($table);
            $table->unsignedBigInteger('parent_id')->nullable()->index();
            $table->string('template', 30)->default('default');
            $table->integer('menu_order')->default(0);
        });

        Schema::create('news_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable()->index();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('news', function (Blueprint $table) {
            $table->id();
            ContentColumns::apply($table);
        });

        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->timestamps();
        });

        Schema::create('news_category_news', function (Blueprint $table) {
            $table->foreignId('news_id')->constrained('news')->cascadeOnDelete();
            $table->foreignId('news_category_id')->constrained('news_categories')->cascadeOnDelete();
            $table->primary(['news_id', 'news_category_id']);
        });

        Schema::create('news_tag', function (Blueprint $table) {
            $table->foreignId('news_id')->constrained('news')->cascadeOnDelete();
            $table->foreignId('tag_id')->constrained('tags')->cascadeOnDelete();
            $table->primary(['news_id', 'tag_id']);
        });

        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            ContentColumns::apply($table);
            $table->boolean('is_pinned')->default(false);
            $table->timestamp('expires_at')->nullable();
        });

        Schema::create('events', function (Blueprint $table) {
            $table->id();
            ContentColumns::apply($table);
            $table->timestamp('start_at')->index();
            $table->timestamp('end_at')->nullable();
            $table->string('location')->nullable();
            $table->string('audience')->nullable();
            $table->string('registration_url')->nullable();
        });

        Schema::create('programs', function (Blueprint $table) {
            $table->id();
            ContentColumns::apply($table);
            $table->string('color', 20)->nullable();
            $table->string('icon', 100)->nullable();
            $table->string('schedule_note')->nullable();
        });

        Schema::create('role_models', function (Blueprint $table) {
            $table->id();
            ContentColumns::apply($table);
            $table->string('person_name')->nullable();
            $table->string('model_type', 30)->default('individual');
            $table->string('address')->nullable();
        });

        Schema::create('learning_models', function (Blueprint $table) {
            $table->id();
            ContentColumns::apply($table);
            $table->string('icon', 100)->nullable();
            $table->string('color', 20)->nullable();
            $table->longText('criteria')->nullable();
        });

        Schema::create('library_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('icon', 100)->nullable();
            $table->string('color', 20)->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('library_items', function (Blueprint $table) {
            $table->id();
            ContentColumns::apply($table);
            $table->foreignId('library_type_id')->nullable()->constrained('library_types')->nullOnDelete();
            $table->foreignId('file_media_id')->nullable()->constrained('media')->nullOnDelete();
            $table->string('external_url')->nullable();
            $table->string('duration')->nullable();
            $table->string('author_name')->nullable();
            $table->unsignedBigInteger('download_count')->default(0);
        });

        Schema::create('document_levels', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('color', 20)->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            ContentColumns::apply($table);
            $table->foreignId('document_level_id')->nullable()->constrained('document_levels')->nullOnDelete();
            $table->string('document_number')->nullable()->index();
            $table->date('issued_at')->nullable();
            $table->string('issuing_agency')->nullable();
            $table->foreignId('file_media_id')->nullable()->constrained('media')->nullOnDelete();
            $table->unsignedBigInteger('download_count')->default(0);
        });

        Schema::create('galleries', function (Blueprint $table) {
            $table->id();
            ContentColumns::apply($table);
        });

        Schema::create('gallery_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gallery_id')->constrained('galleries')->cascadeOnDelete();
            $table->string('type', 20)->default('image');
            $table->foreignId('media_id')->nullable()->constrained('media')->nullOnDelete();
            $table->string('video_url')->nullable();
            $table->string('caption')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('phone', 20);
            $table->string('email')->nullable();
            $table->string('address')->nullable();
            $table->foreignId('program_id')->nullable()->constrained('programs')->nullOnDelete();
            $table->text('desired_content')->nullable();
            $table->string('status', 30)->default('new')->index();
            $table->text('internal_note')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->timestamps();
        });

        Schema::create('contact_messages', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('email');
            $table->string('phone', 20)->nullable();
            $table->string('subject')->nullable();
            $table->text('message');
            $table->boolean('is_read')->default(false)->index();
            $table->text('reply')->nullable();
            $table->timestamp('replied_at')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->timestamps();
        });

        Schema::create('sliders', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('location', 50)->default('hero')->index();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('slides', function (Blueprint $table) {
            $table->id();
            $table->foreignId('slider_id')->constrained('sliders')->cascadeOnDelete();
            $table->string('title')->nullable();
            $table->text('subtitle')->nullable();
            $table->string('link_url')->nullable();
            $table->string('link_label')->nullable();
            $table->foreignId('image_id')->nullable()->constrained('media')->nullOnDelete();
            $table->string('badge_text')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('location', 50)->default('header')->index();
            $table->foreignId('image_id')->nullable()->constrained('media')->nullOnDelete();
            $table->string('title')->nullable();
            $table->string('link_url')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('location', 50)->nullable()->index();
            $table->timestamps();
        });

        Schema::create('menu_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('menu_id')->constrained('menus')->cascadeOnDelete();
            $table->unsignedBigInteger('parent_id')->nullable()->index();
            $table->string('label');
            $table->string('url')->nullable();
            $table->nullableMorphs('linkable');
            $table->string('target', 20)->nullable();
            $table->string('css_class')->nullable();
            $table->string('icon', 100)->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::table('pages', function (Blueprint $table) {
            $table->foreign('parent_id')->references('id')->on('pages')->nullOnDelete();
        });
        Schema::table('news_categories', function (Blueprint $table) {
            $table->foreign('parent_id')->references('id')->on('news_categories')->nullOnDelete();
        });
        Schema::table('menu_items', function (Blueprint $table) {
            $table->foreign('parent_id')->references('id')->on('menu_items')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        $tables = [
            'menu_items', 'menus', 'banners', 'slides', 'sliders',
            'contact_messages', 'registrations', 'gallery_items', 'galleries',
            'documents', 'document_levels', 'library_items', 'library_types',
            'learning_models', 'role_models', 'programs', 'events', 'announcements',
            'news_tag', 'news_category_news', 'tags', 'news', 'news_categories', 'pages',
        ];
        foreach ($tables as $table) {
            Schema::dropIfExists($table);
        }
    }
};
