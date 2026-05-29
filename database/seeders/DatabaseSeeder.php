<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AreaSeeder::class,
            CitySeeder::class,
            CompanySeeder::class,
            CountrySeeder::class,
            GraduateSeeder::class,
            StateSeeder::class,
            TitleSeeder::class,
            AreasGraduatesSeeder::class,
            CompaniesGraduatesSeeder::class,
            GraduatesTitlesSeeder::class,
        ]);


    }
}
