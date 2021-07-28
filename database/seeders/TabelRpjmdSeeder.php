<?php

namespace Database\Seeders;

use App\Models\TabelRpjmd;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class TabelRpjmdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tables = collect(json_decode(Storage::get('seeds/pusda_lama.json'), true));
        $tables = collect($tables->where('type', 'table')->where('name', 'tabel_rpjmd')->first()['data']);
        $tables = $tables->map(function ($table) {
            return [
                'id' => $table['id_tabel_rpjmd'],
                'skpd_id' => $table['id_skpd'],
                'parent_id' => $table['id_parent'] === '0' ? null : $table['id_parent'],
                'nama_menu' => $table['nama_menu']
            ];
        });
        $tables = $tables->filter(function ($table) use ($tables) {
            $parent = $tables->where('id', $table['parent_id'])->first();
            return !is_null($parent) || is_null($table['parent_id']);
        })->toArray();

        TabelRpjmd::insert($tables);

        //  $tables = collect(json_decode(Storage::get('seeds/pusda_baru.json'), true));
        //  $tables = $tables->where('type', 'table')->where('name', 'tabel_rpjmd')->first()['data'];
        //  TabelRpjmd::insert($tables);
    }
}
