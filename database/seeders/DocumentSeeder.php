<?php

namespace Database\Seeders;

use App\Models\Document;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Document::create([
            'code' => '1',
            'description' => 'dni',
            'activity_state_id' => '1'
        ]);

        Document::create([
            'code' => '2',
            'description' => 'ruc',
            'activity_state_id' => '1'
        ]);
    }
}
