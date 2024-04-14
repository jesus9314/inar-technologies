<?php

namespace Database\Seeders;

use App\Models\IdDocument;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IdDocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        IdDocument::create([
            'code' => '1',
            'description' => 'dni',
            'activity_state_id' => '1'
        ]);

        IdDocument::create([
            'code' => '2',
            'description' => 'ruc',
            'activity_state_id' => '1'
        ]);
    }
}
