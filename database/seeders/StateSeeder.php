<?php

namespace Database\Seeders;

use App\Models\ActivityState;
use App\Models\State;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ActivityState::create([
            'code' => '1',
            'description' => 'activo'
        ]);
        ActivityState::create([
            'code' => '2',
            'description' => 'inactivo'
        ]);
    }
}
