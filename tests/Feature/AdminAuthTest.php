<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_login_redirects_to_dashboard(): void
    {
        $this->seed();
        $user = User::where('email', 'admin@example.com')->first();
        $this->assertNotNull($user);
        $user->update(['must_change_password' => false]);

        $response = $this->post('/admin/login', [
            'email' => 'admin@example.com',
            'password' => 'invalid',
        ]);
        $response->assertRedirect(route('admin.login'));
        $response->assertSessionHasErrors('email');
        $this->followRedirects($response)->assertSee('Thông tin đăng nhập không chính xác', false);

        $this->actingAs($user);
        $this->get(route('admin.dashboard'))->assertOk();
    }
}
