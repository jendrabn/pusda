<?php

namespace Database\Seeders;

use App\Models\KategoriSkpd;
use Illuminate\Database\Seeder;

class KategoriSkpdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        KategoriSkpd::insert([
            ['nama' => 'Dinas'],
            ['nama' => 'Badan'],
            ['nama' => 'Bagian'],
            ['nama' => 'UPTD'],
            ['nama' => 'Lainnya'],
        ]);
    }
}
