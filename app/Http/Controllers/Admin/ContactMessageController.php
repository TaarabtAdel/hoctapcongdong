<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactMessageController extends Controller
{
    public function index(): View
    {
        return view('admin.contacts.index', ['items' => ContactMessage::latest()->paginate(20)]);
    }

    public function show(ContactMessage $contact): View
    {
        $contact->update(['is_read' => true]);

        return view('admin.contacts.show', ['contact' => $contact]);
    }

    public function update(Request $request, ContactMessage $contact): RedirectResponse
    {
        $contact->update($request->validate([
            'reply' => ['nullable', 'string'],
            'is_read' => ['nullable', 'boolean'],
        ]));
        if ($request->filled('reply')) {
            $contact->update(['replied_at' => now()]);
        }

        return back()->with('success', __('admin.messages.updated'));
    }

    public function destroy(ContactMessage $contact): RedirectResponse
    {
        $contact->delete();

        return back()->with('success', __('admin.messages.deleted'));
    }
}
