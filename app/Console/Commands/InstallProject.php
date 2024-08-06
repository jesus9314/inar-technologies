<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class InstallProject extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'project:install {--fresh : Rollback and re-run all migrations}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the project by running necessary commands';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting project installation...');

        // Obtén el valor de la opción --fresh
        $fresh = $this->option('fresh');

        if ($fresh) {
            $commands = [
                ['migrate:fresh', ['--seed' => true]], // Corremos las migraciones con los seeders correspondientes y refrescamos la base de datos
                'shield:install',       // installamos el shield de filament
                ['db:seed', ['--class' => 'ShieldSeeder']],  // Corremos el seeder para genrar los roles
                'shield:super-admin',   // selecionamos el super-admin
            ];
        } else {
            $commands = [
                ['migrate', ['--seed' => true]], // Corremos las migraciones con los seeders correspondientes
                'shield:install',       // installamos el shield de filament
                ['db:seed', ['--class' => 'ShieldSeeder']],  // Corremos el seeder para genrar los roles
                'shield:super-admin',   // selecionamos el super-admin
            ];
        }

        foreach ($commands as $command) {
            if (is_array($command)) {
                $this->call($command[0], $command[1]);
            } else {
                $this->call($command);
            }
        }

        $this->info('Project installation completed successfully.');

        return 0;
    }
}
