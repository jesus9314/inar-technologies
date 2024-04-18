<?php

namespace Database\Seeders;

use App\Models\OperatingSystem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OperatingSystemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $operatingSystems = [
            [
                'description' => 'Windows 11'
            ],
            [
                'description' => 'Windows 10'
            ],
            [
                'description' => 'Windows 8.1'
            ],
            [
                'description' => 'Windows 7'
            ],
            [
                'description' => 'macOS Ventura'
            ],
            [
                'description' => 'macOS Monterey'
            ],
            [
                'description' => 'macOS Big Sur'
            ],
            [
                'description' => 'macOS Catalina'
            ],
            [
                'description' => 'Ubuntu'
            ],
            [
                'description' => 'Linux Mint'
            ],
            [
                'description' => 'Debian'
            ],
            [
                'description' => 'Fedora'
            ],
            [
                'description' => 'Arch Linix'
            ],
            [
                'description' => 'CentOS'
            ],
            [
                'description' => 'Manjaro'
            ],
            [
                'description' => 'Android 13'
            ],
            [
                'description' => 'Android 12'
            ],
            [
                'description' => 'Android 11'
            ],
            [
                'description' => 'Android 10'
            ],
            [
                'description' => 'iOS 16'
            ],
            [
                'description' => 'iOS 15'
            ],
            [
                'description' => 'iOS 14'
            ],
            [
                'description' => 'iOS 13'
            ],
        ];

        foreach ($operatingSystems as $operatingSystem) {
            OperatingSystem::create([
                'description' => $operatingSystem['description'],
            ]);
        }
    }
}
