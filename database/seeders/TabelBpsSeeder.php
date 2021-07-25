<?php

namespace Database\Seeders;

use App\Models\TabelBps;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class TabelBpsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tables = collect(json_decode(Storage::get('seeds/pusda_lama.json'), true));
        $tables = collect($tables->where('type', 'table')->where('name', 'tabel_bps')->first()['data']);
        $tables = $tables->map(function ($table) {
            return [
                'id' => $table['id_tabel_bps'],
                'parent_id' => $table['id_parent'] === '0' ? null : $table['id_parent'],
                'menu_name' => $table['nama_menu']
            ];
        });
        $tables = $tables->filter(function ($table) use ($tables) {
            $parent = $tables->where('id', $table['parent_id'])->first();
            return !is_null($parent) || is_null($table['parent_id']);
        })->toArray();

        TabelBps::insert($tables);

        //$tables = collect(json_decode(Storage::get('seeds/pusda_baru.json'), true));
        //$tables = $tables->where('type', 'table')->where('name', 'tabel_bps')->first()['data'];
        //TabelBps::insert($tables);
    }
}
