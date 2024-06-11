<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class OptimizeProject extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'project:optimize';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Optimize the filament/laravel project';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting proyect optimization...');

        //List of commands to run
        $commands = [
            'icons:cache', // Caching Blade Icons
            'filament:cache-components', // Caching Filament components
            'optimize',  // Optimizing your Laravel app
        ];

        foreach ($commands as $command) {
            if (is_array($command)) {
                $this->call($command[0], $command[1]);
            } else {
                $this->call($command);
            }
        }

        $this->info('Project optimization completed successfully.');

        return 0;
    }
}
