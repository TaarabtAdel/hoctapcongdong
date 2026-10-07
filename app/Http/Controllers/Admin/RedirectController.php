<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Redirect;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RedirectController extends Controller
{
    public function index(): View
    {
        return view('admin.redirects.index', [
            'items' => Redirect::query()->orderByDesc('updated_at')->paginate(30),
        ]);
    }

    public function create(): View
    {
        return view('admin.redirects.form', ['item' => new Redirect]);
    }

    public function store(Request $request): RedirectResponse
    {
        Redirect::create($this->validated($request));

        return redirect()->route('admin.redirects.index')->with('success', __('admin.messages.saved'));
    }

    public function edit(Redirect $redirect): View
    {
        return view('admin.redirects.form', ['item' => $redirect]);
    }

    public function update(Request $request, Redirect $redirect): RedirectResponse
    {
        $redirect->update($this->validated($request));

        return back()->with('success', __('admin.messages.updated'));
    }

    public function destroy(Redirect $redirect): RedirectResponse
    {
        $redirect->delete();

        return back()->with('success', __('admin.messages.deleted'));
    }

    /**
     * @return array<string, mixed>
     */
    private function validated(Request $request): array
    {
        return $request->validate([
            'from_path' => ['required', 'string', 'max:255'],
            'to_path' => ['required', 'string', 'max:255'],
            'status_code' => ['required', 'integer', 'in:301,302,307,308'],
        ]);
    }
}
