<?php

namespace Database\Seeders;

use App\Models\Fitur8KelData;
use App\Models\Tabel8KelData;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class Fitur8KelDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $fiturs = collect(json_decode(Storage::get('seeds/pusda_lama.json'), true));
        // $fiturs = collect($fiturs->where('type', 'table')->where('name', 'fitur_8keldata')->first()['data']);
        // $fiturs = $fiturs->map(function ($fitur) {
        //     return [
        //         'id' => $fitur['id_fitur_8keldata'],
        //         'tabel_8keldata_id' => $fitur['id_tabel_8keldata'],
        //         'deskripsi' => $fitur['deskripsi'],
        //         'analisis' => $fitur['analisis'],
        //         'permasalahan' => $fitur['permasalahan'],
        //         'solusi' => $fitur['solusi'],
        //         'saran' => $fitur['saran'],
        //     ];
        // });

        // $fiturs->each(function ($fitur) {
        //     $tabel = Tabel8KelData::where('id', $fitur['tabel_8keldata_id'])->first();
        //     if (!is_null($tabel)) {
        //         Fitur8KelData::create($fitur);
        //     }
        // });

        $fiturs = collect(json_decode(Storage::get('seeds/pusda_baru.json'), true));
        $fiturs = $fiturs->where('type', 'table')->where('name', 'fitur_8keldata')->first()['data'];

        foreach (array_chunk($fiturs, 1000) as $fitur) {
            Fitur8KelData::insert($fitur);
        }
    }
}
