<?php

namespace Database\Seeders;

use App\Models\SkpdCategory;
use Illuminate\Database\Seeder;

class SkpdCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            ['name' => 'Dinas'],
            ['name' => 'Badan'],
            ['name' => 'Bagian'],
            ['name' => 'UPTD'],
            ['name' => 'Lainnya'],
        ];

        foreach ($categories as $category) {
            SkpdCategory::create($category);
        }
    }
}
