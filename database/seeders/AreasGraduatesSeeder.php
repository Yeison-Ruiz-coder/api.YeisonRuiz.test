<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AreasGraduatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $areas = \App\Models\Area::factory(30)->create();
        $graduates = \App\Models\Graduate::factory(5)->create();

        // Insertar datos en la tabla pivote
        foreach ($areas as $area) {
            $randomGraduates = $graduates->random(rand(1, 3));

            foreach ($randomGraduates as $graduate) {
                DB::table('areas_graduates')->insert([
                    'graduate_id' => $graduate->id,
                    'area_id' => $area->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
