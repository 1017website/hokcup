<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Throwable;

class MaintenanceCommandController extends Controller
{
    private array $commands = [
        'migrate' => [
            'label' => 'php artisan migrate',
            'command' => 'migrate',
            'params' => ['--force' => true],
            'icon' => 'fa-database',
            'description' => 'Menjalankan database migration terbaru. Dipakai setelah ada file migration baru.',
            'warning' => 'Pastikan backup database sudah aman sebelum menjalankan migrate di production.',
        ],
        'optimize_clear' => [
            'label' => 'php artisan optimize:clear',
            'command' => 'optimize:clear',
            'params' => [],
            'icon' => 'fa-broom',
            'description' => 'Membersihkan cache route, config, view, event, dan cache aplikasi.',
            'warning' => 'Aman dijalankan setelah update file Blade, route, config, atau controller.',
        ],
        'storage_link' => [
            'label' => 'php artisan storage:link',
            'command' => 'storage:link',
            'params' => [],
            'icon' => 'fa-link',
            'description' => 'Membuat symbolic link public/storage ke storage/app/public untuk file upload.',
            'warning' => 'Jika link sudah ada, Laravel bisa menampilkan pesan bahwa link sudah tersedia.',
        ],
    ];

    public function index()
    {
        return view('admin.commands.index', [
            'commands' => $this->commands,
        ]);
    }

    public function run(Request $request): RedirectResponse
    {
        $request->validate([
            'command' => ['required', Rule::in(array_merge(array_keys($this->commands), ['all']))],
        ]);

        $selected = $request->input('command');
        $queue = $selected === 'all'
            ? ['migrate', 'storage_link', 'optimize_clear']
            : [$selected];

        $results = [];

        foreach ($queue as $key) {
            $results[] = $this->executeCommand($key);
        }

        return back()->with('command_results', $results);
    }

    private function executeCommand(string $key): array
    {
        $config = $this->commands[$key];

        try {
            $exitCode = Artisan::call($config['command'], $config['params']);
            $output = trim(Artisan::output());

            return [
                'label' => $config['label'],
                'exit_code' => $exitCode,
                'status' => $exitCode === 0 ? 'success' : 'failed',
                'output' => $output !== '' ? $output : 'Command selesai tanpa output.',
            ];
        } catch (Throwable $exception) {
            Log::error('CMS artisan command failed', [
                'command' => $config['label'],
                'message' => $exception->getMessage(),
            ]);

            return [
                'label' => $config['label'],
                'exit_code' => 1,
                'status' => 'failed',
                'output' => $exception->getMessage(),
            ];
        }
    }
}
