<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index(): View
    {
        return view('admin.roles.index', ['roles' => Role::withCount('permissions')->get()]);
    }

    public function create(): View
    {
        return view('admin.roles.matrix', [
            'role' => new Role,
            'permissions' => Permission::orderBy('name')->get()->groupBy(fn ($p) => explode('.', $p->name)[0]),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate(['name' => ['required', 'unique:roles,name']]);
        $role = Role::create($data);
        $role->syncPermissions($request->input('permissions', []));

        return redirect()->route('admin.roles.index')->with('success', __('admin.messages.saved'));
    }

    public function edit(Role $role): View
    {
        return view('admin.roles.matrix', [
            'role' => $role,
            'permissions' => Permission::orderBy('name')->get()->groupBy(fn ($p) => explode('.', $p->name)[0]),
        ]);
    }

    public function update(Request $request, Role $role): RedirectResponse
    {
        $role->update($request->validate(['name' => ['required', 'unique:roles,name,'.$role->id]]));
        $role->syncPermissions($request->input('permissions', []));

        return redirect()->route('admin.roles.index')->with('success', __('admin.messages.updated'));
    }

    public function destroy(Role $role): RedirectResponse
    {
        if ($role->name === 'super_admin') {
            return back()->with('error', __('admin.errors.cannot_delete_super_admin'));
        }
        $role->delete();

        return back()->with('success', __('admin.messages.deleted'));
    }
}
