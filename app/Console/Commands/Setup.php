<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Setup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'setup {--full : Run setup command with customized options}
                                  {--key-generate : Generating application key}
                                  {--migrate-fresh-seed : Fresh migrations and run seeders}
                                  {--migrate : Migrate new tables}
                                  {--pm2-startup : Start, startup and save pm2 process}
                                  {--pm2-link : Link pm2 to https://app.pm2.io/}
                                  {--symlinks : Linking filesystem links}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Initialize Setup';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if (
            !$this->option('key-generate') && !$this->option('migrate-fresh-seed')
            && !$this->option('migrate') && !$this->option('pm2-startup')
            && !$this->option('symlinks') && !$this->option('full')
            && !$this->option('help')
        ) {
            $this->error('No option passes. run `php artisan setup --help` to see options.');
            return 0;
        }

        if ($this->option('full')) {
            $this->call('setup', [
                '--migrate-fresh-seed' => 1,
                '--pm2-startup' => 1,
                '--symlinks' => 1,
            ]);
            return 0;
        }

        if ($this->option('key-generate')) {
            $this->call('key:generate', ['--force' => 1]);
            $this->call('jwt:secret', ['--force' => 1]);
        }

        $this->callSilently('optimize:clear');

        if ($this->option('migrate-fresh-seed')) {
            $this->call('migrate:fresh', ['--seed' => 1, '--force' => 1]);
        }

        if ($this->option('migrate')) {
            $this->call('migrate', ['--force' => 1]);
        }

        if ($this->option('pm2-startup')) {
            shell_exec("pm2 stop all");
            shell_exec("pm2 del all");
            shell_exec("pm2 start " . base_path('ecosystem.config.js'));
            shell_exec("pm2 startup");
            shell_exec("pm2 save --force");
            shell_exec("pm2 flush");
        }

        if ($this->option('symlinks')) {
            $this->call('storage:link');
        }

        return 0;
    }

}
