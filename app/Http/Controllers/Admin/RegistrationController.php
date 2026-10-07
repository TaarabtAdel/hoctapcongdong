<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class RegistrationController extends Controller
{
    public function index(): View
    {
        return view('admin.registrations.index', [
            'items' => Registration::with('program')->latest()->paginate(20),
        ]);
    }

    public function show(Registration $registration): View
    {
        return view('admin.registrations.show', compact('registration'));
    }

    public function update(Request $request, Registration $registration): RedirectResponse
    {
        $registration->update($request->validate([
            'status' => ['required', 'in:new,contacted,scheduled,rejected'],
            'internal_note' => ['nullable', 'string'],
        ]));

        return back()->with('success', __('admin.messages.updated'));
    }

    public function destroy(Registration $registration): RedirectResponse
    {
        $registration->delete();

        return back()->with('success', __('admin.messages.deleted'));
    }

    public function export(): StreamedResponse
    {
        $headers = ['Content-Type' => 'text/csv', 'Content-Disposition' => 'attachment; filename=registrations.csv'];
        $callback = function (): void {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['ID', 'Họ tên', 'SĐT', 'Email', 'Trạng thái', 'Ngày']);
            Registration::chunk(200, function ($rows) use ($out): void {
                foreach ($rows as $row) {
                    fputcsv($out, [$row->id, $row->full_name, $row->phone, $row->email, $row->status, $row->created_at]);
                }
            });
            fclose($out);
        };

        return response()->stream($callback, 200, $headers);
    }
}
