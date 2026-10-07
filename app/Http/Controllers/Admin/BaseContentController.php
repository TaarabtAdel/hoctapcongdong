<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ContentStatus;
use App\Http\Controllers\Controller;
use App\Models\Concerns\BaseContentModel;
use App\Models\Revision;
use App\Models\UserPreference;
use App\Services\Content\ContentPersistenceService;
use App\Services\Content\ContentUrlService;
use App\Services\Content\RevisionService;
use App\Services\Slug\SlugService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\View\View;

abstract class BaseContentController extends Controller
{
    abstract protected function modelClass(): string;

    abstract protected function permissionModule(): string;

    abstract protected function routePrefix(): string;

    abstract protected function viewPrefix(): string;

    abstract protected function singularLabel(): string;

    public function __construct(
        protected ContentPersistenceService $persistence,
        protected SlugService $slugService,
        protected ContentUrlService $urlService,
    ) {}

    public function index(Request $request): View
    {
        $this->authorizeModule('view');
        $model = $this->modelClass();
        $status = $request->string('status', 'all')->toString();

        $query = $model::query()->with(['author', 'featuredImage']);
        if ($status === 'trash') {
            $query->onlyTrashed();
        } elseif ($status !== 'all') {
            $query->where('status', $status);
        }

        if ($search = $request->string('s')->trim()->toString()) {
            $query->where('title', 'like', '%'.$search.'%');
        }

        $items = $query->latest('updated_at')->paginate(20)->withQueryString();
        $counts = $this->statusCounts();
        $screenContext = 'list_table.'.$this->permissionModule();
        $defaultColumns = config('htcd.list_table_columns', []);
        $columns = UserPreference::valueFor($request->user()->id, $screenContext) ?? $defaultColumns;

        return view($this->viewPrefix().'.index', [
            'items' => $items,
            'status' => $status,
            'counts' => $counts,
            'singularLabel' => $this->singularLabel(),
            'routePrefix' => $this->routePrefix(),
            'permissionModule' => $this->permissionModule(),
            'screenContext' => $screenContext,
            'columns' => array_merge($defaultColumns, $columns),
        ]);
    }

    public function create(): View
    {
        $this->authorizeModule('create');

        return view($this->viewPrefix().'.form', array_merge([
            'item' => new ($this->modelClass()),
            'singularLabel' => $this->singularLabel(),
            'routePrefix' => $this->routePrefix(),
            'contentType' => $this->contentType(),
        ], $this->formViewData(new ($this->modelClass()))));
    }

    public function store(Request $request): RedirectResponse
    {
        $this->authorizeModule('create');
        $data = $this->validated($request);
        /** @var BaseContentModel $item */
        $item = $this->persistence->fill(new ($this->modelClass()), $data);
        $this->afterSave($item, $request);

        return redirect()->route($this->routePrefix().'.edit', $item)->with('success', __('admin.messages.saved'));
    }

    public function edit(Request $request): View
    {
        /** @var BaseContentModel $item */
        $item = $this->findModel($this->routeModelId($request));
        $this->authorize('update', $item);

        return view($this->viewPrefix().'.form', array_merge([
            'item' => $item,
            'singularLabel' => $this->singularLabel(),
            'routePrefix' => $this->routePrefix(),
            'previewUrl' => $this->urlService->for($item),
            'signedPreviewUrl' => URL::temporarySignedRoute(
                'front.preview',
                now()->addHour(),
                ['type' => $this->contentType(), 'id' => $item->id]
            ),
            'revisions' => $item->revisions()->limit(10)->get(),
            'contentType' => $this->contentType(),
        ], $this->formViewData($item)));
    }

    public function update(Request $request): RedirectResponse
    {
        /** @var BaseContentModel $item */
        $item = $this->findModel($this->routeModelId($request));
        $this->authorize('update', $item);
        if ($request->input('status') === ContentStatus::Published->value) {
            $this->authorize('publish', $item);
        }

        $this->persistence->fill($item, $this->validated($request));
        $this->afterSave($item, $request);

        return redirect()->route($this->routePrefix().'.edit', $item)->with('success', __('admin.messages.updated'));
    }

    public function restoreRevision(Request $request, RevisionService $revisionService): RedirectResponse
    {
        $this->authorizeModule('edit');
        $revision = Revision::query()->findOrFail($request->integer('revision_id'));
        $item = $revision->revisionable;
        $this->authorize('update', $item);
        $revisionService->restore($revision);

        return back()->with('success', __('admin.messages.revision_restored'));
    }

    public function destroy(Request $request): RedirectResponse
    {
        /** @var BaseContentModel $item */
        $item = $this->findModel($this->routeModelId($request));
        $this->authorize('delete', $item);
        $item->delete();

        return redirect()->route($this->routePrefix().'.index')->with('success', __('admin.messages.trashed'));
    }

    public function bulkAction(Request $request): RedirectResponse
    {
        $this->authorizeModule('edit');
        $action = $request->string('action')->toString();
        $ids = $request->input('ids', []);
        $model = $this->modelClass();

        $query = $model::query()->whereIn('id', $ids);
        match ($action) {
            'trash' => $query->get()->each->delete(),
            'restore' => $model::onlyTrashed()->whereIn('id', $ids)->get()->each->restore(),
            'force_delete' => $model::onlyTrashed()->whereIn('id', $ids)->get()->each->forceDelete(),
            'publish' => $query->update(['status' => ContentStatus::Published->value, 'published_at' => now()]),
            'draft' => $query->update(['status' => ContentStatus::Draft->value]),
            default => null,
        };

        return back()->with('success', __('admin.messages.bulk_done'));
    }

    public function quickEdit(Request $request): RedirectResponse
    {
        $this->authorizeModule('edit');
        /** @var BaseContentModel $item */
        $item = $this->findModel((int) $request->input('id'));
        $this->authorize('update', $item);
        $this->persistence->fill($item, $request->only(['title', 'slug', 'status', 'published_at']));

        return back()->with('success', __('admin.messages.updated'));
    }

    public function autosave(Request $request): JsonResponse
    {
        $this->authorizeModule('edit');
        /** @var BaseContentModel $item */
        $item = $request->filled('id') ? $this->findModel((int) $request->input('id')) : new ($this->modelClass());
        if ($item->exists) {
            $this->authorize('update', $item);
        }
        $data = $this->validated($request);
        $data['status'] = ContentStatus::Draft->value;
        $item = $this->persistence->fill($item, $data);

        return response()->json([
            'id' => $item->id,
            'saved_at' => now()->format('H:i:s'),
        ]);
    }

    /**
     * @return array<string, int>
     */
    protected function statusCounts(): array
    {
        $model = $this->modelClass();
        $counts = ['all' => $model::count()];
        foreach (ContentStatus::values() as $status) {
            $counts[$status] = $model::where('status', $status)->count();
        }
        $counts['trash'] = $model::onlyTrashed()->count();

        return $counts;
    }

    /**
     * @return array<string, mixed>
     */
    protected function contentType(): string
    {
        return str_replace('_', '-', $this->permissionModule());
    }

    /**
     * @return array<string, mixed>
     */
    protected function formViewData(BaseContentModel $item): array
    {
        return [];
    }

    protected function afterSave(BaseContentModel $item, Request $request): void {}

    protected function validated(Request $request): array
    {
        return $request->validate(array_merge([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255'],
            'excerpt' => ['nullable', 'string'],
            'content' => ['nullable', 'string'],
            'featured_image_id' => ['nullable', 'integer', 'exists:media,id'],
            'status' => ['nullable', 'in:'.implode(',', ContentStatus::values())],
            'published_at' => ['nullable', 'date'],
            'seo_title' => ['nullable', 'string', 'max:255'],
            'seo_description' => ['nullable', 'string'],
            'seo_keywords' => ['nullable', 'string', 'max:255'],
            'og_image_id' => ['nullable', 'integer', 'exists:media,id'],
            'is_featured' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer'],
        ], $this->extraValidationRules()));
    }

    /**
     * @return array<string, mixed>
     */
    protected function extraValidationRules(): array
    {
        return [];
    }

    protected function routeModelId(Request $request): int
    {
        $parameters = $request->route()?->parameters() ?? [];
        $value = reset($parameters);

        if ($value instanceof BaseContentModel) {
            return (int) $value->getKey();
        }

        return (int) $value;
    }

    protected function findModel(int $id): BaseContentModel
    {
        /** @var BaseContentModel $model */
        $model = $this->modelClass()::withTrashed()->findOrFail($id);

        return $model;
    }

    protected function authorizeModule(string $action): void
    {
        $user = auth()->user();
        abort_unless($user && ($user->can("{$this->permissionModule()}.{$action}") || $user->can("manage_{$this->permissionModule()}")), 403);
    }
}
