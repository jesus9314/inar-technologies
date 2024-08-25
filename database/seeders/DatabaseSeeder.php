<?php

namespace Database\Seeders;

use App\Models\Meeting;
use App\Models\User;
use App\Traits\Seeders\DatabaseSeederTrait;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class DatabaseSeeder extends Seeder
{
    use DatabaseSeederTrait;
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        self::create_all_directories();

        User::factory()->create([
            'name' => 'Jesus Inchicaque',
            'email' => 'jesus.9314@gmail.com',
            'password' => bcrypt('alienado123')
        ]);

        $this->call(self::getSeeders());

        // Collection::times(5, function () {
        //     Meeting::factory()
        //         ->hasUsers(random_int(1, 3))
        //         ->create()
        //     ;
        // });
    }
}
