<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Country;
use App\DataProviders\CountryDataProvider;
use App\DataProviders\StateDataProvider;
use App\DataProviders\CityDataProvider;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Country::insertOrIgnore(CountryDataProvider::data());
    }
}
