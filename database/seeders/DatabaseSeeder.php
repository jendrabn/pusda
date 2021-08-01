<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            SkpdCategorySeeder::class,
            SkpdSeeder::class,
            UserSeeder::class,
            Tabel8KelDataSeeder::class,
            TabelRpjmdSeeder::class,
            TabelIndikatorSeeder::class,
            TabelBpsSeeder::class,
            Uraian8KelDataSeeder::class,
            UraianRpjmdSeeder::class,
            UraianIndikatorSeeder::class,
            UraianBpsSeeder::class,
            Fitur8KelDataSeeder::class,
            FiturRpjmdSeeder::class,
            FiturBpsSeeder::class,
            FiturIndikatorSeeder::class,
            IsiSeeder::class
        ]);
    }
}
