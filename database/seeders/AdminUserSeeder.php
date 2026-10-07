<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $password = (string) config('htcd.default_admin_password', '123456');

        $user = User::query()->updateOrCreate(
            ['email' => config('htcd.default_admin_email')],
            [
                'name' => 'Quản trị viên',
                'password' => $password,
                'status' => 'active',
                'must_change_password' => false,
                'email_verified_at' => now(),
            ]
        );

        $user->syncRoles(['super_admin']);

        $readme = base_path('README.md');
        $block = "\n\n## Tài khoản quản trị (seed)\n\n- Email: `admin@example.com`\n- Mật khẩu: `{$password}` (có thể đặt `ADMIN_PASSWORD` trong `.env` trước khi seed)\n";

        if (File::exists($readme)) {
            $content = File::get($readme);
            if (str_contains($content, '## Tài khoản quản trị (seed)')) {
                $content = preg_replace('/\n## Tài khoản quản trị \(seed\)[\s\S]*/', '', $content) ?? $content;
            }
            File::put($readme, rtrim($content).$block);
        } else {
            File::put($readme, '# HTCD Cửa Tùng'.$block);
        }
    }
}
