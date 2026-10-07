<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Program;
use App\Models\Registration;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RegistrationController extends Controller
{
    public function create(): View
    {
        return view('front.registration.create', [
            'programs' => Program::published()->orderBy('sort_order')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        if ($request->filled('website')) {
            abort(422);
        }

        $data = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'email' => ['nullable', 'email'],
            'address' => ['nullable', 'string'],
            'program_id' => ['nullable', 'exists:programs,id'],
            'desired_content' => ['nullable', 'string'],
        ]);

        Registration::create($data + ['ip_address' => $request->ip(), 'status' => 'new']);

        return redirect()->route('front.registration.thanks');
    }

    public function thanks(): View
    {
        return view('front.registration.thanks');
    }
}
