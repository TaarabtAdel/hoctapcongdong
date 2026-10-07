<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Concerns\BaseContentModel;
use App\Models\Document;
use App\Models\Event;
use App\Models\Gallery;
use App\Models\LearningModel;
use App\Models\LibraryItem;
use App\Models\News;
use App\Models\Page;
use App\Models\Program;
use App\Models\RoleModel;
use App\Services\Seo\MetaService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PreviewController extends Controller
{
    public function show(Request $request, string $type, int $id): View
    {
        if (! $request->hasValidSignature()) {
            abort(403);
        }

        $class = match ($type) {
            'news' => News::class,
            'page' => Page::class,
            'announcement' => Announcement::class,
            'event' => Event::class,
            'program' => Program::class,
            'document' => Document::class,
            'learning-model' => LearningModel::class,
            'role-model' => RoleModel::class,
            'library-item' => LibraryItem::class,
            'gallery' => Gallery::class,
            default => abort(404),
        };

        /** @var BaseContentModel $item */
        $item = $class::withTrashed()->findOrFail($id);

        $meta = app(MetaService::class)->forContent($item);
        $meta['title'] = '[Xem trước] '.$meta['title'];
        $meta['robots'] = 'noindex, nofollow';

        return view('front.content.show', [
            'item' => $item,
            'meta' => $meta,
            'isPreview' => true,
        ]);
    }
}
