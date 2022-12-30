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
            KategoriSkpdSeeder::class,
            SkpdSeeder::class,
            UserSeeder::class,
            Tabel8KelDataSeeder::class,
            TabelRpjmdSeeder::class,
            TabelIndikatorSeeder::class,
            TabelBpsSeeder::class,
            UraianSeeder::class,
            IsiSeeder::class,
            FiturSeeder::class,
        ]);
    }
}
