<?php

namespace Database\Seeders;

use App\Models\FiturRpjmd;
use App\Models\TabelRpjmd;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class FiturRpjmdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $fiturs = collect(json_decode(Storage::get('seeds/pusda_lama.json'), true));
        // $fiturs = collect($fiturs->where('type', 'table')->where('name', 'fitur_rpjmd')->first()['data']);
        // $fiturs = $fiturs->map(function ($fitur) {
        //     return [
        //         'id' => $fitur['id_fitur_rpjmd'],
        //         'tabel_rpjmd_id'  => $fitur['id_tabel_rpjmd'],
        //         'deskripsi'  => $fitur['deskripsi'],
        //         'analisis'  => $fitur['analisis'],
        //         'permasalahan' => $fitur['permasalahan'],
        //         'saran' => $fitur['solusi'],
        //         'solusi' => $fitur['saran'],
        //     ];
        // });

        // $fiturs->each(function ($fitur) {
        //     $tabel = TabelRpjmd::where('id', $fitur['tabel_rpjmd_id'])->first();
        //     if (!is_null($tabel)) {
        //         FiturRpjmd::create($fitur);
        //     }
        // });

        $fiturs = collect(json_decode(Storage::get('seeds/pusda_baru.json'), true));
        $fiturs = $fiturs->where('type', 'table')->where('name', 'fitur_rpjmd')->first()['data'];

        foreach (array_chunk($fiturs, 1000)  as $fitur) {
            FiturRpjmd::insert($fitur);
        }
    }
}
