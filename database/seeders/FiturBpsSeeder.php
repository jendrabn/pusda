<?php

namespace Database\Seeders;

use App\Models\FiturBps;
use App\Models\TabelBps;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class FiturBpsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $fiturs = collect(json_decode(Storage::get('seeds/pusda_lama.json'), true));
        // $fiturs = collect($fiturs->where('type', 'table')->where('name', 'fitur_bps')->first()['data']);
        // $fiturs = $fiturs->map(function ($fitur) {
        //     return [
        //         'id' => $fitur['id_fitur_bps'],
        //         'tabel_bps_id' => $fitur['id_tabel_bps'],
        //         'deskripsi' => $fitur['deskripsi'],
        //         'analisis' => $fitur['analisis'],
        //         'permasalahan' => $fitur['permasalahan'],
        //         'solusi' => $fitur['solusi'],
        //         'saran' => $fitur['saran'],
        //     ];
        // });

        // $fiturs->each(function ($fitur) {
        //     $tabel = TabelBps::where('id', $fitur['tabel_bps_id'])->first();
        //     if (!is_null($tabel)) {
        //         FiturBps::create($fitur);
        //     }
        // });

        $fiturs = collect(json_decode(Storage::get('seeds/pusda_baru.json'), true));
        $fiturs = $fiturs->where('type', 'table')->where('name', 'fitur_bps')->first()['data'];

        foreach (array_chunk($fiturs, 1000) as $fitur) {
            FiturBps::insert($fitur);
        }
    }
}
