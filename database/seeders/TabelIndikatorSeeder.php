<?php

namespace Database\Seeders;

use App\Models\TabelIndikator;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class TabelIndikatorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tables = collect(json_decode(Storage::get('seeds/pusda_lama.json'), true));
        $tables = collect($tables->where('type', 'table')->where('name', 'tabel_indikator')->first()['data']);
        $tables = $tables->map(function ($table) {
            return [
                'id' => $table['id_tabel_indikator'],
                'parent_id' => $table['id_parent'] === '0' ? null : $table['id_parent'],
                'menu_name' => $table['nama_menu']
            ];
        });
        $tables = $tables->filter(function ($table) use ($tables) {
            $parent = $tables->where('id', $table['parent_id'])->first();
            return !is_null($parent) || is_null($table['parent_id']);
        })->toArray();

        TabelIndikator::insert($tables);

        //$tables = collect(json_decode(Storage::get('seeds/pusda_baru.json'), true));
        //$tables = $tables->where('type', 'table')->where('name', 'tabel_indikator')->first()['data'];
        //TabelIndikator::insert($tables);
    }
}
