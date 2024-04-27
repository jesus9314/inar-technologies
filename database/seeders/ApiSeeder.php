<?php

namespace Database\Seeders;

use App\Models\Api;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ApiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $apis = [
            [
                'name' => 'APIS.NET.PE',
                'documentation_link' => 'https://apis.net.pe/',
                'env_name' => 'APIS_NET_PE_KEY',
                'status' => true,
            ],
            [
                'name' => 'Google Maps',
                'documentation_link' => 'https://developers.google.com/maps/documentation/javascript?hl=es-419',
                'env_name' => 'GOOGLE_MAPS_API_KEY',
                'status' => false,
            ],
        ];

        foreach ($apis as $api) {
            Api::create([
                'name' => $api['name'],
                'documentation_link' => $api['documentation_link'],
                'env_name' => $api['env_name'],
                'status' => $api['status']
            ]);
        }
    }
}
