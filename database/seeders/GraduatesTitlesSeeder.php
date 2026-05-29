<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GraduatesTitlesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $titles = \App\Models\Title::factory(30)->create();
        $graduates = \App\Models\Graduate::factory(5)->create();

        // Insertar datos en la tabla pivote
        foreach ($titles as $title) {
            $randomGraduates = $graduates->random(rand(1, 3));

            foreach ($randomGraduates as $graduate) {
                DB::table('graduates_titles')->insert([
                    'graduate_id' => $graduate->id,
                    'title_id' => $title->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
