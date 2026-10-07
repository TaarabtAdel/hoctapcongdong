<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    /** @var list<string> */
    private array $modules = [
        'pages', 'news', 'announcements', 'events', 'programs', 'role_models',
        'learning_models', 'library', 'documents', 'galleries', 'registrations',
        'contacts', 'media', 'menus', 'appearance', 'users', 'roles', 'settings',
        'redirects', 'activity_log', 'tools',
    ];

    /** @var list<string> */
    private array $actions = [
        'view', 'create', 'edit', 'edit_others', 'publish', 'delete', 'restore', 'force_delete',
    ];

    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        foreach ($this->modules as $module) {
            foreach ($this->actions as $action) {
                Permission::findOrCreate("{$module}.{$action}");
            }
            Permission::findOrCreate("manage_{$module}");
        }

        $all = Permission::all();

        $super = Role::findOrCreate('super_admin');
        $super->syncPermissions($all);

        $admin = Role::findOrCreate('administrator');
        $admin->syncPermissions($all->filter(fn ($p) => ! str_starts_with($p->name, 'roles.')));

        $editor = Role::findOrCreate('editor');
        $editor->syncPermissions($all->filter(fn ($p) => ! in_array(explode('.', $p->name)[0], ['users', 'roles', 'settings', 'tools'], true)));

        $author = Role::findOrCreate('author');
        $authorPerms = $all->filter(function ($p) {
            $name = $p->name;
            if (str_contains($name, 'edit_others') || str_contains($name, 'force_delete')) {
                return false;
            }
            if (str_contains($name, 'users.') || str_contains($name, 'roles.') || str_contains($name, 'settings.')) {
                return false;
            }

            return str_contains($name, '.view') || str_contains($name, '.create') || str_contains($name, '.edit') || str_contains($name, '.publish') || str_contains($name, '.delete');
        });
        $author->syncPermissions($authorPerms);

        $contributor = Role::findOrCreate('contributor');
        $contributorPerms = $all->filter(fn ($p) => (str_contains($p->name, '.view') || str_contains($p->name, '.create') || str_contains($p->name, '.edit')) && ! str_contains($p->name, '.publish'));
        $contributor->syncPermissions($contributorPerms);

        $handler = Role::findOrCreate('registration_handler');
        $handler->syncPermissions($all->filter(fn ($p) => str_starts_with($p->name, 'registrations.') || str_starts_with($p->name, 'contacts.')));
    }
}
