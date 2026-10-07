<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class AdminModulesTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
        $this->admin = User::where('email', 'admin@example.com')->firstOrFail();
        $this->admin->update(['must_change_password' => false]);
    }

    /**
     * @return array<int, string>
     */
    public static function adminGetRoutesProvider(): array
    {
        return [
            ['admin.dashboard'],
            ['admin.news.index'],
            ['admin.news.create'],
            ['admin.pages.index'],
            ['admin.announcements.index'],
            ['admin.events.index'],
            ['admin.programs.index'],
            ['admin.documents.index'],
            ['admin.library-items.index'],
            ['admin.galleries.index'],
            ['admin.registrations.index'],
            ['admin.contacts.index'],
            ['admin.media.index'],
            ['admin.menus.index'],
            ['admin.sliders.index'],
            ['admin.settings.edit'],
            ['admin.redirects.index'],
            ['admin.widgets.index'],
            ['admin.banners.index'],
            ['admin.activity.index'],
        ];
    }

    #[DataProvider('adminGetRoutesProvider')]
    public function test_admin_module_pages_load(string $routeName): void
    {
        $this->actingAs($this->admin)
            ->get(route($routeName))
            ->assertOk();
    }
}
