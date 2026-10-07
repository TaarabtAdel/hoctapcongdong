<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Artisan;

class ToolsController extends Controller
{
    public function clearCache(): RedirectResponse
    {
        Artisan::call('cache:clear');
        Artisan::call('view:clear');

        return back()->with('success', __('admin.messages.cache_cleared'));
    }

    public function backupDatabase(): RedirectResponse
    {
        $connection = config('database.default');
        $dir = storage_path('app/backups');
        if (! is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        $file = $dir.'/backup-'.now()->format('Y-m-d-His').'.sql';
        if ($connection === 'mysql') {
            $db = config('database.connections.mysql.database');
            $user = config('database.connections.mysql.username');
            $pass = config('database.connections.mysql.password');
            $host = config('database.connections.mysql.host');
            $cmd = sprintf('mysqldump -h%s -u%s %s > %s', escapeshellarg($host), escapeshellarg($user), escapeshellarg($db), escapeshellarg($file));
            if ($pass) {
                putenv('MYSQL_PWD='.$pass);
            }
            exec($cmd, $output, $code);
            if ($code !== 0) {
                return back()->with('error', __('admin.messages.backup_failed'));
            }
        } else {
            copy(database_path('database.sqlite'), $file);
        }

        return back()->with('success', __('admin.messages.backup_created', ['path' => $file]));
    }
}
