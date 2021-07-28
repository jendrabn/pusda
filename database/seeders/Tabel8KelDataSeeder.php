<?php

namespace Database\Seeders;

use App\Models\Tabel8KelData;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class Tabel8KelDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tables = collect(json_decode(Storage::get('seeds/pusda_lama.json'), true));
        $tables = collect($tables->where('type', 'table')->where('name', 'tabel_8keldata')->first()['data']);
        $tables = $tables->map(function ($table) {
            return [
                'id' => $table['id_tabel_8keldata'],
                'skpd_id' => $table['id_skpd'],
                'parent_id' => $table['id_parent'] === '0' ? null : $table['id_parent'],
                'nama_menu' => $table['nama_menu']
            ];
        });
        $tables = $tables->filter(function ($table) use ($tables) {
            $parent = $tables->where('id', $table['parent_id'])->first();
            return !is_null($parent) || is_null($table['parent_id']);
        })->toArray();

        Tabel8KelData::insert($tables);

        //$tables = collect(json_decode(Storage::get('seeds/pusda_baru.json'), true));
        //$tables = $tables->where('type', 'table')->where('name', 'tabel_8keldata')->first()['data'];
        //Tabel8KelData::insert($tables);
    }
}
