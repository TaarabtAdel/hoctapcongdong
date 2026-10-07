<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(): View
    {
        return view('admin.users.index', ['users' => User::with('roles')->paginate(20)]);
    }

    public function create(): View
    {
        return view('admin.users.form', ['user' => new User, 'roles' => Role::orderBy('name')->get()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'min:8'],
            'role' => ['required', 'exists:roles,name'],
        ]);
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'status' => 'active',
        ]);
        $user->syncRoles([$data['role']]);

        return redirect()->route('admin.users.index')->with('success', __('admin.messages.saved'));
    }

    public function edit(User $user): View
    {
        return view('admin.users.form', ['user' => $user, 'roles' => Role::orderBy('name')->get()]);
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:users,email,'.$user->id],
            'password' => ['nullable', 'min:8'],
            'role' => ['required', 'exists:roles,name'],
            'status' => ['required', 'in:active,inactive'],
        ]);
        $user->fill(collect($data)->except(['password', 'role'])->toArray());
        if ($request->filled('password')) {
            $user->password = Hash::make($data['password']);
        }
        $user->save();
        if ($user->hasRole('super_admin') && User::role('super_admin')->count() <= 1 && $data['role'] !== 'super_admin') {
            return back()->with('error', __('admin.errors.last_super_admin'));
        }
        $user->syncRoles([$data['role']]);

        return redirect()->route('admin.users.index')->with('success', __('admin.messages.updated'));
    }

    public function destroy(User $user): RedirectResponse
    {
        if ($user->hasRole('super_admin') && User::role('super_admin')->count() <= 1) {
            return back()->with('error', __('admin.errors.last_super_admin'));
        }
        $user->delete();

        return back()->with('success', __('admin.messages.deleted'));
    }
}
