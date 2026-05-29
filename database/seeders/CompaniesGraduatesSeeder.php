<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompaniesGraduatesSeeder extends Seeder
{
    public function run(): void
    {
        $companies = \App\Models\Company::factory(30)->create();
        $graduates = \App\Models\Graduate::factory(5)->create();

        // Insertar datos en la tabla pivote
        foreach ($companies as $company) {
            $randomGraduates = $graduates->random(rand(1, 3));

            foreach ($randomGraduates as $graduate) {
                DB::table('companies_graduates')->insert([
                    'graduate_id' => $graduate->id,
                    'company_id' => $company->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
